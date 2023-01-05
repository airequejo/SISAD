<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Ubigeo.php";
$ubig=new Ubigeo();



switch ($_GET["op"])
{
    case "select_combo_ubigeo":
		$rspta = $ubig->select_combo_ubigeo();
		echo "<option value=''>SELECCIONE UN DISTRITO</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->id_ubigeo_inei.'>'.$reg->departamentos .' / '.$reg->provincia.' / '.$reg->distrito.'</option>';
		}
	break;	

}


