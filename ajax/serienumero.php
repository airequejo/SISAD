<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Serienumero.php";
$serienumeronumero=new Serienumero();



switch ($_GET["op"])
{
    case "mostrar_serie":
		$idtipocomprobante=$_REQUEST["idtipocomprobante"];
		$rspta = $serienumeronumero->mostrar_serie($idtipocomprobante);
		echo "<option value=''>SELECCIONE</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idserienumero.'>'.$reg->serie .'-'.$reg->concepto .'</option>';
		}
	break;	


	case 'serie_mostrar':
		$idserienumero=$_REQUEST["idserienumero"];
		$rspta=$serienumeronumero->serie_mostrar($idserienumero);
		echo json_encode($rspta);
		break;	



}


