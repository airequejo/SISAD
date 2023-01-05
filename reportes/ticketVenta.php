<?php

//Activamos el almacenamiento en el buffer
/*ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{*/

    require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $rspta = $consultas->config_empresa();
      $reg = $rspta->fetch_object();
   
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
$rsptav = $venta->mostrar_venta_cabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();


//Establecemos los datos de la empresa
$empresa = $reg->nombre;
$razon = $reg->razon;
$documento = $reg->ruc;
$direccion = $reg->direccion;
$telefono = $reg->celular;
$email = $reg->email;
$autorizacion=$reg->autorizacion;
$url_consulta=$reg->url_consultas;
$servicio=$reg->servicio;
$tipoproceso=$reg->tipoproceso;
?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<style>
    
    h1 {
    display: block;
    font-size: 2em;
    margin-block-start: 0.0em;
    margin-block-end: 0.2em;
    margin-inline-start: 0px;
    margin-inline-end: 0px;
    font-weight: bold;
}
</style>

<table border="0" align="center" width="270px">
      <tr>
        <td align="center">
            <img align="center" src="logo.png" width="270" height="70">
        </td>
    </tr> 
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML 
        <h1><strong> <?php echo $razon; ?></strong></h1>-->
        <!-- <h3><strong>DE: <?php echo $empresa; ?></strong></h3> -->
        
        <font size="2px">
            <b>
            <?php echo "RUC N° ".$documento; ?>
            </b><br>
        </font>
    
        <font size="1px">
        
        <?php echo $servicio; ?><br>
        <?php echo $direccion .' '.$telefono; ?>
        
        </font>
        </td>
    </tr>
     <tr>
      <td align="center"></td>
    </tr>
     <tr>
        <td align=""><?php 
        
         
        $seriebuena=$regv->tipocomprobante." ".$regv->comprobante;

        echo "<font size='2px'> <b>".$seriebuena."</b></font>"; 

        //include "../161/plugins/phpqrcode/qrlib.php";
        include "../public/plugins/phpqrcode/qrlib.php";

        /***** FACTURA: DATOS OBLIGATORIOS PARA EL CÓDIGO QR *****/
        /*RUC | TIPO DE DOCUMENTO | SERIE | NUMERO | MTO TOTAL IGV | MTO TOTAL DEL COMPROBANTE | FECHA DE EMISION |TIPO DE DOCUMENTO ADQUIRENTE | NUMERO DE DOCUMENTO ADQUIRENTE |*/
            $nombreqr=substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
            $nombre_pdf=$documento.'-'.substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
            $textoqr=$documento."|".substr("00".$regv->idtipocomprobante,-2)."|".$regv->serie_generada."|".substr("00000000".$regv->numero,-8) ."|"."0.00"."|".$regv->total_venta."|".date("d-m-Y",strtotime($regv->fecha))."|".$regv->tipodocumento."|".$regv->dniruc."|";

    if ($tipoproceso=='1')
     {
        $ruta_tipo_proceso='produccion';
     }

     if ($tipoproceso=='3')
     {
        $ruta_tipo_proceso='beta';
     }
     
         $ruta_qr = "qr/".$nombreqr.".png";
        // $ruta_qr = '../../../public/sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$documento.'/qr/'.$nombreqr.'.png';
        
        $sqr_genrado=QRcode::png(''.$textoqr, $ruta_qr, "H",8, 2);

         ?></td>
        
    </tr>   
    <tr>
        <td align=""><font size="1px">FECHA DE EMISIÓN: <b><?php echo date("d-m-Y H:i:s",strtotime($regv->fecha_hora)); ?></b></font></td>
    </tr>
   
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td><font size="1px">CLIENTE : <b> <?php echo $regv->nombre; ?></b></font></td>
    </tr>
    <tr>
        <td><font size="1px"><?php echo "DNI/RUC".":<b> ".$regv->dniruc; ?></b></font></td>
    </tr>
    <tr>
        <td><font size="1px"><?php echo "DIRECCIÓN :<b> ".$regv->direc; ?></b></font></td>
    </tr>
    <tr>
        <td><font size="1px"><?php echo "ESPECIALIDAD : <b>".$regv->especialidad; ?></b></font></td>
    </tr>
    <tr>
        <td><font size="1px"><?php echo "CICLO : <b>".$regv->ciclo; ?></b></font></td>
    </tr>
         <?php 
         //$regv->comprobanteref==="" quité un signo igual para que no muestre la parte de nota de crédito en el ticket
        if($regv->comprobanteref==""){

        }else{
    
       
            echo "<tr>
      <td align='center' colspan='3'><hr></td>
    </tr><tr>
        <td><b>DOCUMENTO MODIFICA</b></td>
    </tr>
    <tr><td>".$regv->nombrecomprobante."</td>
        </tr>

    <tr>
<td><b>SERIE Y NUMERO QUE MODIFICA</b></td>
        
    </tr>
    <tr> <td>".$regv->comprobanteref."</td>
         
        </tr>

    <tr>
     <td><b>MOTIVO </b></td>
    </tr>
            <tr><td>".$regv->descripcionmotivo."</td></tr>
            <tr><td colspan='3'><hr></td></tr>";
        }
        ?>
    
    
    
    
    
</table>

<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="270px">
    <tr>
        <td align="center"><b>DESCRIPCIÓN</b></td>
        <td align="center"><b> P.UNIT</b></td>

        <td><b>CANT</b></td>
        <td align="center"><b>SUBTOTAL</b></td>
    </tr>
    <tr>
      <td colspan="4"><hr></td>
    </tr>
    <?php
    $rsptad = $venta->listarDetalle($_GET["id"]);
    $cantidad=0;
    $tt=0;
    $v=1;
    $items=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td><font size='1px'>".$regd->descripcion."</font></td>";
        echo "<td valign='top'><font size='1px'>".$regd->precio."</font></td>";
        echo "<td valign='top'><font size='1px'>".$regd->cantidad."</font></td>";
        echo "<td align='right' valign='top'><font size='1px'>".$regd->subtotales."</font></td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
        $items++;

        $tt+=$regd->subtotales;
    }
    ?>

    <?php 
    
    require_once "Letras.php";
    $V=new EnLetras(); 
    $con_letra=strtoupper($V->ValorEnLetras($regv->total_venta," CON "));
//$pdf->addCadreTVAs($con_letra);

 ?>

    <!-- Mostramos los totales de la venta en el documento HTML -->
    <tr>
       <td colspan="4"><hr></td>
    </tr>
    <tr> <td colspan="4"><font size="1px">Nº de artículos: <?php echo $items; ?></font></td></tr>
   <tr>
    <td rowspan="5"><img src="<?php echo $ruta_qr; ?>" width="100" height="100" /></td>
  
    <td colspan="2" align="right"><font size="1px"><b>TOTAL S/:</b></font></td>
    <td  align="right"><font size="1px"><b> <?php echo number_format($tt,2); ?></font></b></td>
    </tr>
    <tr>

      
  
    <td colspan="2" align="right"><font size="1px"><b>Igv (18%) S/:</b></font></td>
    <td  align="right"><font size="1px"><b> 0.00</b></font></td>
     
    </tr>


    <tr>

     
  
    <td colspan="2" align="right"><font size="1px"><b>Inafecta S/:</b></font></td>
    <td align="right"><font size="1px"><b> 0.00</b></font></td>
     
    </tr>
<tr>

      
  
    <td colspan="2" align="right"><font size="1px"><b>Gratuita S/:</b></font></td>
    <td align="right"><font size="1px"><b> 0.00</b></font></td>
     
    </tr><tr>

      
  
    <td colspan="2" align="right"><font size="1px"><b>Importe a Pagar S/:</b></font></td>
    <td align="right"><font size="1px"><b> <?php echo number_format($tt,2); ?></b></font></td>
     
    </tr>
    <tr><td colspan="4"><hr></td></tr>
    <tr>

      <td colspan="4"><?php echo "SON: ". $con_letra; ?></td><br>
     
    </tr>

     <?php

    if($regv->tipoventa==="2"){

      echo '<tr>
      <td colspan="4"><b>TIPO DE TRANSACCIÓN:</b> CRÉDITO</td>
    </tr>
    <tr>
      <td colspan="4"><b>INFORMACIÓN DEL CRÉDITO:</b></td>
    </tr>
    <tr>
      <td colspan="4">MONTO PENDIENTE DE PAGO :</b>'.$regv->monto_credito.'  </td>
    </tr>
    <tr>
      <td colspan="4">FECHA DE VENCIMIENTO :</b>'.date("d-m-Y",strtotime($regv->fecha_vencimiento)).'  </td>
    </tr>';
    }
    else{

    echo '<tr>
    <td colspan="4"><b>TIPO DE TRANSACCIÓN:</b> CONTADO</td>
  </tr>';

    }


?>
<!-- GENERACIÓN DEL QR-->

<!-- <tr>
    <td colspan="4">
        <p align="justify">
            Representación impresa de la <?php echo $regv->tipocomprobante; ?> . Consulte su documento electrónico en: <br /> <span style="font-size: 10px"> <?php echo $url_consulta; ?></span>
        </p>
    </td>
</tr> -->
<tr>
    <td colspan="4">
        BIENES  TRANSFERIDOS  EN  LA  AMAZONÍA  PARA  SER  CONSUMIDOS EN  LA  MISMA
    </td>
</tr>
    <tr>
        <td> </td>
    </tr>
    <tr>
      
      <td colspan="4" align="center">¡Gracias por su compra!</td>
    </tr>
    <tr>
      <td colspan="4" align="center"></td>
    </tr>
    <tr>
      <td colspan="4" align="center">Moyobamba - Perú</td>
    </tr>
</table>
<br>
</div>
<p>&nbsp;</p>
<script src="../public/js/jquery.number.js"></script>
</body>
</html>
<?php 
/*}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>*/