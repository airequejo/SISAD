<?php

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
if ($_SESSION['ctscobrar']==1)
{

    require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $rspta = $consultas->config_empresa();
      $reg = $rspta->fetch_object();
   
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
require_once "../modelos/Gestionarcompromisos.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
$credito = new Gestionarcompromiso();
//$rsptav = $venta->mostrar_venta_cabecera($_GET["id"]);
$rsptac = $credito->mostrar_detalle_pagos($_GET["id"]);
//Recorremos todos los valores obtenidos
$regc = $rsptac->fetch_object();


//Establecemos los datos de la empresa
$empresa = $reg->nombre;
$documento = $reg->ruc;
$direccion = $reg->direccion;
$telefono = $reg->celular;
$email = $reg->email;
$servicio = $reg->servicio;
$autorizacion=$reg->autorizacion;
$url_consulta=$reg->url_consultas;
?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="600">
    <tr>
         <td>
            <table border='1' style="border-color:black;" cellspacing="0" cellpading="0" width="100%">
                <tr>
                    <td align="center">
                        <h2><b>Recibo detallado de pago de compromisos</b></h2>
                    </td>
                    
                </tr>
                <tr>
                    <td align="center">
                                                <?php
         echo "<h2> <b>Crédito Nº ".$regc->idcredito."</b></h2>"; 
         ?>
                    </td>
                </tr>
            </table>
           
        </td>
    </tr>

    <tr>
      <td align="center" colspan="3"></td>
    </tr>
        <tr>
        <td colspan="3">
            <b>INFORMACIÓN DEL CLIENTE</b>
            <hr>
            <?php
                echo "CLIENTE: ".$regc->nombre."<br>DNI/RUC Nº: ".$regc->dniruc."<br>DIRECCIÓN: ".$regc->direccion;
                echo "<br><hr><b>INFORMACIÓN DEL CRÉDITO</b><br><hr>FECHA CRÉDITO: ".$regc->fecha_credito."<br>Monto Venta S/: ".$regc->monto_venta."<br>Pag Inicial S/: ".$regc->montoabonado."<br>Monto Crédito S/: ".$regc->monto_credito."<br>Deuda Actual S/: ".$regc->deuda_actual;
            ?>
            <hr>
        </td>
    </tr> 
    <tr>
    
     
</table>

<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="600">
    <tr>
        <td><b>N°</b></td>
        <td align="center"><b>Fecha Pago</b></td>
        <td align="center"><b>Usuario</b></td>
        <td align="center"><b>Monto Pago S/</b></td>
        <td align="center"><b>Forma de Pago</b></td>
        <td align="center"><b>Obs</b></td>
    </tr>
    <tr>
      <?php
    $tt=0;
    $v=1;
    $items=0;
    $rsptac1 = $credito->mostrar_detalle_pagos($_GET["id"]);
    while ($regc1 = $rsptac1->fetch_object()) {

        $val ='';

        if ($regc1->estado==0) 
        {

            $val ='Anulado';
            
        }
        

        echo "<tr>";
        echo "<td>".$v++."</td>";
        echo "<td>".$regc1->fechapago."</td>";
        echo "<td>(C)".$regc1->u_cobro.'- (A)'.$regc1->u_anula."</td>";
        echo "<td align='right'>".$regc1->monto."</td>";
        echo "<td align='right'>".$regc1->descripcion."</td>";
        echo "<td align='right'>".$val."</td>";
        echo "</tr>";
      }
    
    ?>

    </tr>
   

    <tr>
      <td colspan="5">&nbsp;</td>
    </tr> 

<!-- GENERACIÓN DEL QR-->
   
   
</table>

</div>
<p>&nbsp;</p>
<script src="../public/js/jquery.number.js"></script>
</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>