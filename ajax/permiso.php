<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Permisos.php";
$permiso=new Permiso();

switch ($_GET["op"]) {
		
	case 'listar':
		$rspta=$permiso->listar();
		$data= Array();

		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				
				"0"=>$reg->nombre);
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;
}
