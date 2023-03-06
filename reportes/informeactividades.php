<?php
    require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $idactividad=$_GET["id"];
      $rsptac = $consultas->ingresosporactividad($_GET["id"]);
    
      $rsptag = $consultas->egresosporactividad($_GET["id"]);
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
        <td colspan='2'  align=""><font size="4px">INFORME ECONÓMICO DE ACTIVIDADES</font></td>
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
<table border="0" align="center"  width="90%">
<tr><td valign="top">
    <?php
    $totalingresos=0;
    echo "<table border='0'>";
    while ($regc = $rsptac->fetch_object()) {
        echo "<tr><td colspan='5'><font size='1px'><b>".$regc->codigocuenta." ".$regc->cuenta."</b></font></td><td align='right' valign='top'><font size='1px'><b>".number_format($regc->total,2)."</b></font></td></tr>";
        $rsptasc = $consultas->subcuentaporactividad($idactividad,$regc->idcuenta);
$totalingresos=number_format($regc->total,2);
        while ($regsc = $rsptasc->fetch_object()) {
            echo "<tr><td valign='top'><font size='1px'>&nbsp;</font></td><td colspan='3'><font size='1px' color='blue'>".$regsc->codigosubcuenta." ".$regsc->subcuenta."</font></td><td align='right' valign='top'><font size='1px' color='blue'>".number_format($regsc->total,2)."</font></td><td valign='top'><font size='1px'>&nbsp;</font></td></tr>";
            $rsptadi = $consultas->divisionariaporactividad($idactividad,$regc->idcuenta,$regsc->idsubcuenta);
        while ($regdi = $rsptadi->fetch_object()) {
            echo "<tr><td valign='top'><font size='1px'>&nbsp;</font></td><td valign='top'><font size='1px'>&nbsp;</font></td><td><font size='1px'>".$regdi->codigodivisionaria." ".$regdi->divisionaria."</font></td><td align='right' valign='top'><font size='1px'>".number_format($regdi->total,2)."</font></td><td valign='top'><font size='1px'>&nbsp;</font></td><td valign='top'><font size='1px'>&nbsp;</font></td></tr>";
        }
        }
    }
    echo "</table>";
    ?>
    </td><td valign="top">
    <?php
    $totalegresos=0;
    echo "<table border='0'>";
    while ($regcg = $rsptag->fetch_object()) {
        echo "<tr><td colspan='5'><font size='1px'><b>".$regcg->codigocuenta." ".$regcg->cuenta."</b></font></td><td align='right' valign='top'><font size='1px'><b>".number_format($regcg->total,2)."</b></font></td></tr>";
        $rsptascg = $consultas->subcuentaegresosporactividad($idactividad,$regcg->idcuenta);
        while ($regscg = $rsptascg->fetch_object()) {
            echo "<tr><td valign='top'><font size='1px'>&nbsp;</font></td><td colspan='3'><font size='1px' color='blue'>".$regscg->codigosubcuenta." ".$regscg->subcuenta."</font></td><td align='right' valign='top'><font size='1px' color='blue'>".number_format($regscg->total,2)."</font></td><td valign='top'><font size='1px'>&nbsp;</font></td></tr>";
            $rsptadig = $consultas->divisionariaegresosporactividad($idactividad,$regcg->idcuenta,$regscg->idsubcuenta);
        while ($regdig = $rsptadig->fetch_object()) {
            echo "<tr><td valign='top'><font size='1px'>&nbsp;</font></td><td valign='top'><font size='1px'>&nbsp;</font></td><td><font size='1px'>".$regdig->codigodivisionaria." ".$regdig->divisionaria."</font></td><td align='right' valign='top'><font size='1px'>".number_format($regdig->total,2)."</font></td><td valign='top'><font size='1px'>&nbsp;</font></td><td valign='top'><font size='1px'>&nbsp;</font></td></tr>";
            
        }
        }
        $totalegresos=$totalegresos+number_format($regcg->total,2);
        }
    echo "</table>";
    ?>
    </td></tr>
    <tr>
    <td colspan="2">
    RESUMEN DE INGRESOS Y EGRESOS DE LA ACTIVIDAD
    </td>
    </tr>
    <td>
    Ingresos S/ <?echo $totalingresos;?>
    </td>
    <td>
    Egresos S/ <?echo $totalegresos;?>
    </td>
    </tr>
</table>
<br>


</body>
</html>