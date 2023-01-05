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
if ($_SESSION['ventas']==1)
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
$servicio = $reg->servicio;
$autorizacion=$reg->autorizacion;
$url_consulta=$reg->url_consultas;
?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="600">
    <tr>
         <td align="center">
            <img align="left" src="logo.png" width="180" height="120">
            </td> 
            <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <h1><strong> <?php echo $razon; ?></strong><br> <h3><p>DE: <?php echo $empresa; ?></p></h3></h1>
        <?php echo $direccion .'<br>'.$telefono; ?><br>
        </td>
        <td>
            <table border='1' style="border-color:black;" cellspacing="0" cellpading="0" width="100%">
                <tr>
                    <td align="center">
                         <?php echo "<h2>R.U.C.".$documento."</h2>"; ?> 
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?php
                        $seriebuena=$regv->tipocomprobante." ".$regv->comprobante;
                        
         echo "<h2> <b>".$regv->tipocomprobante." </b></h2>"; 
         ?>
                    </td>
                    
                </tr>
                <tr>
                    <td align="center">
                                                <?php
         echo "<h2> <b>".$regv->comprobante."</b></h2>"; 
         ?>
                    </td>
                </tr>
            </table>
           
        </td>
    </tr>
     <tr>
        <td align="center" colspan="3"><?php 
        
        
         include "../public/plugins/phpqrcode/qrlib.php";
        //include "../161/plugins/phpqrcode/qrlib.php";

        $nombreqr=substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
        $nombre_pdf=$documento.'-'.substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
        $textoqr=$documento."|".substr("00".$regv->idtipocomprobante,-2)."|".$regv->serie_generada."|".substr("00000000".$regv->numero,-8) ."|"."0.00"."|".$regv->total_venta."|".date("d-m-Y",strtotime($regv->fecha))."|".$regv->tipodocumento."|".$regv->dniruc."|";
        $ruta_qr = "qr/".$nombreqr.".png";
        
        $sqr_genrado=QRcode::png(''.$textoqr, $ruta_qr, "H",8, 2);

       // QRcode::png($textoqr, $ruta_qr, 'Q',15, 0);

         ?></td>
        
    </tr>   
    <tr>
        <td align="" colspan="3">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($regv->fecha_hora)); ?></td>
    </tr>
    <tr>
      <td align="center" colspan="3"></td>
    </tr>
        <tr>
        <td colspan="3">
            INFORMACIÓN GENERAL
            <hr>
        </td>
    </tr> 
    <tr>
    <td colspan="3">
    <table  border='0' style="border-color:black;" cellspacing="0" cellpading="0" width="100%">
        <tr>
                    <!-- Mostramos los datos del cliente en el documento HTML -->
        <td width="15%"><b>CLIENTE: </b></td><td width="85%"><?php echo $regv->nombre; ?></td>
    </tr>
    <tr>
        <td width="15%"><b>DNI/RUC: </b></td><td width="85%"><?php echo $regv->dniruc; ?></td>

    </tr>

    <tr>
        <td width="15%"><b>DIRECCI&Oacute;N: </b></td><td width="85%"><?php echo $regv->direc; ?></td>

    </tr> 
    </table>
            <hr>
    </td>
     <?php 
        if($regv->comprobanteref==""){

        }else{
    
       
            echo "<tr>
      <td align='center' colspan='3'><hr></td>
    </tr><tr>
        <td><b>DOCUMENTO MODIFICA</b></td>
         <td><b>SERIE Y NUMERO QUE MODIFICA</b></td>
         <td><b>MOTIVO</b></td>
    </tr>
    <tr><td>".$regv->nombrecomprobante."</td>
         <td>".$regv->comprobanteref."</td>
         <td>".$regv->descripcionmotivo."</td></tr><tr>
      <td align='center' colspan='3'><hr></td>
    </tr>";
        }
        ?>
    
     
</table>

<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="600">
    <tr>
        <td><b>N°</b></td>
        <td align="center"><b>DESCRIPCIÓN</b></td>
        <td align="center"><b>PRECIO UNITARIO</b></td>

        <td align="center"><b>CANTIDAD</b></td>
        <td align="right"><b>IMPORTE S/</b></td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>
    <?php
    $rsptad = $venta->listarDetalle($_GET["id"]);
    $cantidad=0;
    $tt=0;
    $v=1;
    $items=0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$v++."</td>";
        echo "<td>".$regd->descripcion."</td>";
        echo "<td align='right'>".$regd->precio."</td>";
        echo "<td align='right'>".$regd->cantidad."</td>";
        echo "<td align='right'>".$regd->subtotales."</td>";
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
       <td colspan="5"><hr></td>
    </tr>
    <tr> <td colspan="5">Nº de artículos: <?php echo $items; ?></td></tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>TOTAL S/:</b></td>
    <td colspan="2" align="right"><b><?php echo number_format($tt,2); ?></b></td>
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Igv (18%) S/:</b></td>
    <td colspan="2" align="right"><b>0.00</b></td>
     
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Exonerada S/:</b></td>
    <td colspan="2" align="right"><b><?php echo number_format($tt,2); ?></b></td>
     
    </tr>

    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Inafecta S/:</b></td>
    <td colspan="2" align="right"><b>0.00</b></td>
     
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Gravada S/:</b></td>
    <td colspan="2" align="right"><b>0.00</b></td>
     
    </tr><tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Gratuita S/:</b></td>
    <td colspan="2" align="right"><b>0.00</b></td>
     
    </tr><tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Importe a Pagar S/:</b></td>
    <td colspan="2" align="right"><b><?php echo number_format($tt,2); ?></b></td>
     
    </tr>
    <tr><td colspan="5"><hr></td></tr>
    <tr>

      <td colspan="5"><?php echo "SON: ". $con_letra; ?></td><br>
     
    </tr>

    <tr>
      <td colspan="5">&nbsp;</td>
    </tr> 

<!-- GENERACIÓN DEL QR-->
   
   
</table>
 <table cellpadding="0" align="center" width="600">
                <tbody>
                    <tr>    
                        <td class="fg2" colspan="5" align="center"><img src="<?php echo $ruta_qr; ?>" width="120" height="120" /></td>                    
                        <td>
                            <!-- <div>Representación impresa de la <?php echo $regv->tipocomprobante; ?> . Consulte su documento electrónico en: <br /> <span style="font-size: 10px"> <?php echo $url_consulta; ?></span></div>
                            <br><span class="codigofac">HASH: <?php echo $regv->hash_cpe; ?></span> -->
                            <div>BIENES  TRANSFERIDOS  EN  LA  AMAZONÍA  PARA  SER  CONSUMIDOS EN  LA  MISMA.</div>
                            <br><span class="codigofac">HASH: <?php echo $regv->hash_cpe; ?></span>
                        </td>
                    </tr>  
                   <!-- <tr>
                        <td colspan="6">
                            BIENES  TRANSFERIDOS  EN  LA  AMAZONÍA  PARA  SER  CONSUMIDOS EN  LA  MISMA.
                        </td>
                    </tr> -->
                </tbody>
            </table>
<br>
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