<?php 
  
# Cargamos la librería dompdf.
require_once '../public/plugins/dompdf/vendor/autoload.php';
use Dompdf\Dompdf;

# Contenido HTML del documento que queremos generar en PDF.
require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $rspta = $consultas->config_empresa();
      $reg = $rspta->fetch_object();


//Incluímos la clase Venta
require_once "../modelos/Venta.php";
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
$rsptav = $venta->mostrar_venta_cabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();


//Establecemos los datos de la empresa
$empresa = $reg->nombre;
$documento = $reg->ruc;
$direccion = $reg->direccion;
$telefono = $reg->celular;
$email = $reg->email;
$servicio = $reg->servicio;
$autorizacion=$reg->autorizacion;
$url_consulta=$reg->url_consultas;
$tipoproceso=$reg->tipoproceso;

    include "..public//plugins/phpqrcode/qrlib.php";
        //include "../161/plugins/phpqrcode/qrlib.php";

    $nombreqr=substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
    $nombre_pdf=$documento.'-'.substr("00".$regv->idtipocomprobante,-2)."-".$regv->comprobante;
    $textoqr=$documento."|".substr("00".$regv->idtipocomprobante,-2)."|".$regv->serie_generada."|".substr("00000000".$regv->numero,-8) ."|"."0.00"."|".$regv->total_venta."|".date("d-m-Y",strtotime($regv->fecha))."|".$regv->tipodocumento."|".$regv->dniruc."|";
       // $ruta_qr = "qr/".$nombreqr.".png";
    if ($tipoproceso=='1')
     {
        $ruta_tipo_proceso='produccion';
     }

     if ($tipoproceso=='3')
     {
        $ruta_tipo_proceso='beta';
     }

        $ruta_qr = '../public/sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$documento.'/qr/'.$nombreqr.'.png';
        
        
        $sqr_genrado=QRcode::png(''.$textoqr, $ruta_qr, "H",8, 2);



        if($regv->comprobanteref==="")
            {

                $compro_ref= ""; 

            }
            else
            {
        
           
                $compro_ref= '<tr>
                  <td align="center" colspan="3"><hr></td>
                </tr><tr>
                    <td><b>DOCUMENTO MODIFICA</b></td>
                     <td><b>SERIE Y NUMERO QUE MODIFICA</b></td>
                     <td><b>MOTIVO</b></td>
                </tr>
                <tr><td>'.$regv->nombrecomprobante.'</td>
                     <td>'.$regv->comprobanteref.'</td>
                     <td>'.$regv->descripcionmotivo.'</td></tr><tr>
                  <td align="center" colspan="3"><hr></td>
                </tr>';
            }



   
    
    require_once "Letras.php";
    $V=new EnLetras(); 
    $con_letra=strtoupper($V->ValorEnLetras($regv->total_venta," CON "));
    //$pdf->addCadreTVAs($con_letra);



   
    $rsptad = $venta->listarDetalle($_GET["id"]);
    $cantidad=0;
    $tt=0;
    $v=1;
    $items=0;

    $detalle_ven='';
   
    while ($regd = $rsptad->fetch_object()) {

        $detalle_ven=$detalle_ven.'<tr>
                    <td>'.$v++.'</td>
                    <td>'.$regd->descripcion.'</td>
                    <td align="right">'.$regd->precio.'</td>
                    <td align="right">'.$regd->cantidad.'</td>
                    <td align="right">'.$regd->subtotales.'</td>
            </tr>';

        $cantidad+=$regd->cantidad;
        $items++;

        $tt+=$regd->subtotales;
       
    }

    
     $detalle_ven=$detalle_ven;

   

   
$html='
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>


<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="200%">
    <tr>
        <td align="center">
            <img align="left" src="logo.jpg" width="120" height="120">
            </td>
            <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <h2><strong>'.$empresa.'</strong></h2><br> <h3><p>'.$servicio.'</p></h3>
        '.$direccion.'<br>'.$telefono.'<br>
        </td>
        <td>
            <table border="1" style="border-color:black;" cellspacing="0" cellpading="0" width="100%">
                <tr>
                    <td align="center">
                         <h2>R.U.C.'.$documento.'</h2>
                    </td>
                </tr>
                <tr>
                    <td align="center"><h2> <b>'.$regv->tipocomprobante.'</b></h2> 

                    </td>
                    
                </tr>
                <tr>
                    <td align="center">
        <h2> <b>'.$regv->comprobante.'</b></h2> 
       
                    </td>
                </tr>
            </table>
           
        </td>
    </tr>
     <tr>
        <td align="center" colspan="3">'.$sqr_genrado.

        '</td>
        
    </tr>   
    <tr>
        <td align="center" colspan="3">FECHA DE EMISIÓN:'.date("d-m-Y H:i:s",strtotime($regv->fecha_hora)).'</td>
    </tr>
    <tr>
      <td align="center" colspan="3"></td>
    </tr>
        <tr>
        <td colspan="3">
            INFORMACI&Oacute;N GENERAL
            <hr>
        </td>
    </tr> 
    <tr>
    <td colspan="3">
    <table  border="0" style="border-color:black;" cellspacing="0" cellpading="0" width="100%">
        <tr>
                    <!-- Mostramos los datos del cliente en el documento HTML -->
        <td width="15%"><b>CLIENTE: </b></td><td width="85%">'.$regv->nombre.'</td>
    </tr>
    <tr>
        <td width="15%"><b>DNI/RUC: </b></td><td width="85%">'.$regv->dniruc.'</td>

    </tr>

    <tr>
        <td width="15%"><b>DIRECCIÓN: </b></td><td width="85%">'.$regv->direc.'</td>

    </tr> 
    </table>
            <hr>
    </td>'.$compro_ref.'

    
     
</table>

<table border="0" align="center" width="200%">
    <tr>
        <td><b>N°</b></td>
        <td align="center"><b>DESCRIPCIÓN</b></td>
        <td align="center"><b>PRECIO UNITARIO</b></td>

        <td align="center"><b>CANTIDAD</b></td>
        <td align="right"><b>IMPORTE</b></td>
    </tr>
    <tr>
      <td colspan="5"><hr></td>
    </tr>'.

         $detalle_ven.'
        
   
   
    <tr>
       <td colspan="5"><hr></td>
    </tr>
    <tr> <td colspan="5">Nº de artículos:'. $items.'</td></tr>
   <tr>
    <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>TOTAL:</b></td>
    <td colspan="2" align="right"><b>S/ '.number_format($tt,2).'</b></td>
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Igv (18%):</b></td>
    <td colspan="2" align="right"><b>S/  00.00</b></td>
     
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Exonerada:</b></td>
    <td colspan="2" align="right"><b>S/  '.number_format($tt,2).'</b></td>
     
    </tr>

    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Inafecta:</b></td>
    <td colspan="2" align="right"><b>S/  00.00</b></td>
     
    </tr>
    <tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Gravada:</b></td>
    <td colspan="2" align="right"><b>S/  00.00</b></td>
     
    </tr><tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Op. Gratuita:</b></td>
    <td colspan="2" align="right"><b>S/  00.00</b></td>
     
    </tr><tr>

      <td colspan="2">&nbsp;</td>
  
    <td align="right"><b>Importe a Pagar:</b></td>
    <td colspan="2" align="right"><b>S/  '.number_format($tt,2).'</b></td>
     
    </tr>
    <tr><td colspan="5"><hr></td></tr>
    <tr>

      <td colspan="5">SON: '.$con_letra.'</td><br>
     
    </tr>

    <tr>
      <td colspan="5">&nbsp;</td>
    </tr> 

<!-- GENERACIÓN DEL QR-->

   
</table>
<table cellpadding="0" align="center" width="200%">
                <tbody>
                    <tr>    
                        <td class="fg2" colspan="5" align="center"><img src="'.$ruta_qr.'" width="120" height="120" /></td>                    
                        <td>
                            <div>Autorizado mediante Resolución de Intendencia N° '. $autorizacion.' -Representación impresa de la '. $regv->tipocomprobante.' 
                            . Consulte su documento electrónico en: <br /> <span style="font-size: 10px">'.$url_consulta.'</span></div>
                            <br><span class="codigofac">HASH: '.$regv->hash_cpe.'</span>
                        </td>
                    </tr>   
                </tbody>
            </table>
<br>
</div>
<p>&nbsp;</p>
<script src="../public/js/jquery.number.js"></script>
</body>
</html>
';

# Instanciamos un objeto de la clase DOMPDF.
$mipdf = new Dompdf();


# Definimos el tamaño y orientación del papel que queremos.
# O por defecto cogerá el que está en el fichero de configuración.
$mipdf ->set_paper("A4", "portrait");

# Cargamos el contenido HTML.
$mipdf ->load_html(utf8_decode(utf8_encode($html)));

# Renderizamos el documento PDF.
$mipdf ->render();

# Enviamos el fichero PDF al navegador.


$output = $mipdf->output();
file_put_contents('../public/sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$documento.'/pdf/'.$nombre_pdf.'.PDF', $output);

$mipdf ->stream($nombre_pdf);
?>
