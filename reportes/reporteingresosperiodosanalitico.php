<?php
    require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $periodo=$_GET["id"];
      $rsptac = $consultas->cuentasingresos($periodo);
    
   
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">

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

<table border="0" align="center" width="90%">
      <tr>
        <td align="rigth">
            <img align="center" src="logo.png" width="170" height="40">
        </td>
        <td align="center">
        ESCUELA DE EDUCACIÓN SUPERIOR PEDAGÓGICA PÚBLICA<br>"GENERALÍSIMO JOSÉ DE SAN MARTÍN"
        </td>
    </tr>
     <tr>
      <td colspan='2' align="center"><hr></td>
    </tr>
    <tr>
        <td colspan='2'  align=""><font size="4px">INGRESOS DEL PERIODO</font></td>
    </tr>
    <tr>
        <td colspan='2'  align=""><font size="2px">Fecha de Reporte: <?php 
        
        $hoy = date("F j, Y, g:i a"); 
        echo $hoy;  ?></font></td>
    </tr>
   
    <tr>
        <td colspan='2'  align="center">
        <hr>
        </td>
    </tr>  
</table>

<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="90%">
    <?php
    $v=1;
    $sumatoria=0;
    while ($regc = $rsptac->fetch_object()) {
    $sumatoria=$sumatoria+$regc->total;
        echo "<tr><td colspan='9'><font size='1px'><b>".$regc->codigocuenta." ".$regc->cuenta."</b></font></td><td align='right'><font size='1px'><b>".$regc->total."</b></font></td></tr>";
        $rsptasc = $consultas->subcuentasingresos($periodo,$regc->idcuenta);
        while ($regsc = $rsptasc->fetch_object()) {
            echo "<tr><td valign='top'>&nbsp;</font></td><td colspan='7'><font size='1px' color='blue'><b>".$regsc->codigosubcuenta." ".$regsc->subcuenta."</b></font></td><td align='right' valign='top'><font size='1px' color='blue'>".$regsc->total."</font></td><td valign='top'>&nbsp;</td></tr>";
            $rsptadi = $consultas->divisionariaingresos($periodo,$regc->idcuenta,$regsc->idsubcuenta);
        while ($regdi = $rsptadi->fetch_object()) {
            echo "<tr><td valign='top'>&nbsp;</td><td valign='top'>&nbsp;</td><td colspan='5'><font size='1px' color='purple'><b>".$regdi->codigodivisionaria." ".$regdi->divisionaria."</b></font></td><td align='right'><font size='1px'>".$regdi->total."</font></td><td>&nbsp;</td><td>&nbsp;</td></tr>";
            $rsptabo = $consultas->comprobantesingresos($periodo,$regc->idcuenta,$regsc->idsubcuenta,$regdi->iddivisionaria);
            while ($regbo = $rsptabo->fetch_object()) {
                echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><font size='1px'>".$regbo->fecha."</font><td><font size='1px'>".$regbo->comprobante."</font></td><td valign='top'><font size='1px'>".$regbo->nombre."</font></td><td valign='top'><font size='1px'>".$regbo->total."</font></td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
                
            }
        }
        }
    }
    echo "<tr><td colspan='9' align='right'><hr><font size='1px'><b>TOTAL S/ </b></font></td><td align='right' valign='top'><hr><font size='1px'><b>".number_format($sumatoria,2)."</b></font></td></tr>";
    ?>
</table>
<br>


</body>
</html>