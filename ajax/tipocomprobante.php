<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Tipocomprobante.php";
$tipocomprobante=new Tipocomprobante();



switch ($_GET["op"])
{
    case "select_combo_tipocomprobante":
		$rspta = $tipocomprobante->select_combo_tipocomprobante();
		echo "<option value='3'>BOLETA ELECTRONICA</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idtipocomprobante.'>'.$reg->descripcion.'</option>';
		}
		
		//echo "<option value='11'>SALIDA  ALMACENES PRINCIPAL</option>";
		//echo "<option value='88'>SALIDA POR VENCIMIENTO</option>";
	break;
	
	
	
	case "select_combo_tipocomprobante_salidas":
		$rspta = $tipocomprobante->select_combo_tipocomprobante_salidas();
	
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idtipocomprobante.'>'.$reg->descripcion.'</option>';
		}
		
		//echo "<option value='11'>SALIDA  ALMACENES PRINCIPAL</option>";
		//echo "<option value='88'>SALIDA POR VENCIMIENTO</option>";
	break;

}


