<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Formapago.php";
$formapago=new Formapago();



switch ($_GET["op"])
{
    case "select_combo_formapago":

		$rspta = $formapago->select_combo_formapago();
		echo "<option value='-'>SELECCIONE</option>";
		while ($reg = $rspta->fetch_object())
			
		{
			echo '<option value='.$reg->idformapago.'>'.$reg->descripcion .'</option>';
		}
	break;

	case "select_combo_formapago_credito":

		$rspta = $formapago->select_combo_formapago_credito();
		 echo "<option value='-'>SELECCIONE</option>";
		while ($reg = $rspta->fetch_object())
			
		{
			echo '<option value='.$reg->idformapago.'>'.$reg->descripcion .'</option>';
		}
	break;

	


	case "select_combo_formapago_compra":

		$rspta = $formapago->select_combo_formapago_compra();
		//echo "<option value='2'>DEPOSTITO EN CUENTA INSTITUCIONAL</option>";
		while ($reg = $rspta->fetch_object())
			
		{
			echo '<option value='.$reg->idformapago.'>'.$reg->descripcion .'</option>';
		}
	break;


}


