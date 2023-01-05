<?php
date_default_timezone_set('America/Lima');
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['compras']==1)
{
//Incluímos el archivo Factura.php
require('configCompra.php');

require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $rspta = $consultas->config_empresa();
      $reg = $rspta->fetch_object();

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Compra.php";
$compra= new Compra();
$rsptac = $compra->mostrar_compra_cabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptac->fetch_object();
echo "<p style = 'font-family:courier,arial,helvética;'>";
echo "<style type='text/css'>
tr:nth-child(odd) {
    background-color:#f2f2f2;
}
tr:nth-child(even) {
    background-color:#fbfbfb;
}
</style>";
echo "<table border='0' width='100%'><tr><td><table border='0' width='100%' colspan='0' cellspan='0'>";
echo "<tr><td colspan='4'><b>Datos del Ingreso</b></td></tr>";
echo "<tr><td width='20%'><b>RUC</b></td><td width='40%'>".$regv->dniruc."</td><td width='20%'><b>Comprobante</td><td><b>Serie-Número</b></td></tr>";
echo "<tr><td width='20%'><b>Proveedor</b></td><td width='40%'>".utf8_decode($regv->nombrerazon)."</td><td width='20%'>$regv->tipocomprobante</td><td>$regv->serie-$regv->numero</td></tr>";
echo "<tr><td width='20%'><b>Direcci&oacute;n</b></td><td width='40%'>".utf8_decode($regv->direccion)."</td><td width='20%'><b>Fecha Ingreso</td><td>".date("d-m-Y",strtotime($regv->fecha))."</td></tr>";
echo "<tr><td colspan='4'><b>Detalle</b></td></tr></table><table border='0'>";
echo "<tr><td width='5%'><b>N°</b></td><td width='40%'><b>Descripción</b></td><td width='15%' align='right'><b>Cantidad</b></td><td width='20%' align='right'><b>Precio Unitario</b></td><td width='20%' align='right'><b>Sub Total</b></td></tr>";
$rsptad = $compra->listarDetalle($_GET["id"]);
$n=1;
while ($regd = $rsptad->fetch_object()) {
echo "<tr><td width='5%'>".$n."</td><td width='40%'>".htmlspecialchars_decode("$regd->descripcion")."</td><td width='15%' align='right'>".$regd->cantidad."</td><td width='20%' align='right'>".$regd->precio."</td><td width='20%' align='right'>".$regd->subtotales."</td></tr>";
            $n++;
}

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->total_compra*(1+($regv->impuesto/100))," SOLES CON "));
//$pdf->addCadreTVAs($con_letra);

echo "<tr><td colspan='2'><b>Monto en Letras</b><td width='20%'><b>I.G.V.</b></td><td><b>Total S/</b></td></tr>";
echo "<tr><td colspan='2'>SON: ".$con_letra."<td width='20%'>".$regv->impuesto." %</td><td>".$regv->total_compra."</td></tr>";
echo "</table></td></tr></table>";
echo "</p>";
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>