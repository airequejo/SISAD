<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Direcciones.php";
$direc=new Direcciones();

$iddireccion=isset($_POST["iddireccion"])? limpiarCadena($_POST["iddireccion"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$ubigeo=isset($_POST["ubigeo"])? limpiarCadena($_POST["ubigeo"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$referencia=isset($_POST["referencia"])? limpiarCadena($_POST["referencia"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if(empty($iddireccion)){
			$rspta=$direc->insertar($iddireccion,$idcliente,$ubigeo,$tipo,$direccion,$referencia);
			echo $rspta ? "Operación Aceptada" : "Operación no se pudo completar : insertar direción";
		}else{
			$rspta=$direc->editar($iddireccion,$idcliente,$ubigeo,$tipo,$direccion,$referencia);
			echo $rspta ? "Operación Aceptada" : "Operación no se pudo completar : actualizar direción";
		}
		
		break;

	case 'desactivar':
		$rspta=$direc->desactivar($iddireccion);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar ";
		break;

	case 'activar':
		$rspta=$direc->activar($iddireccion);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar direccion";
		break;	

	case 'mostrar':
		$rspta=$direc->mostrar($iddireccion);
		echo json_encode($rspta);
		break;
	
	case "select_combo_cliente":
		require_once "../modelos/Cliente.php";
		$cliente = new Cliente;
		$rspta = $cliente->select_combo_cliente();
		echo "<option value=' '>SELECCIONE UN CLIENTE</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcliente.'>'.$reg->nombre .' - '.$reg->dniruc.'</option>';
		}
	break;	
	
	
	case "select_combo_direccion_cliente":

		$rspta = $direc->select_combo_direccion_cliente($idcliente);
	//	echo "<option value='1'></option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->iddireccion.'>'.$reg->nombredireccion .'</option>';
		}
	break;

	case "select_combo_ubigeo":
		$rspta = $direc->select_combo_ubigeo();
		echo "<option value=''>SELECCIONE UN DISTITO</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->id_ubigeo_inei.'>'.$reg->departamentos .' / '.$reg->provincia.' / '.$reg->distrito.'</option>';
		}
	break;	


	
	case 'listar':
		$rspta=$direc->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
		    if ($reg->ubigeo=='0')
			{
				$edit = ' <a data-toggle="modal" href="#myModal"><button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddireccion.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>';
			}
			else
			{
				$edit = ' <a data-toggle="modal" href="#myModal"><button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->iddireccion.')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></a>';
			}
			
			$data[]=array(
				"9"=>($reg->estado)?'<button class="btn btn-success btn-xs" title="Activar" onclick="activar('.$reg->iddireccion.')"><i class="fa fa-check" aria-hidden="true"></i></button>':
					' <button class="btn btn-danger btn-xs" title="Desactivar" onclick="desactivar('.$reg->iddireccion.')"><i class="fa fa-trash" aria-hidden="true"></i></button>'.$edit,
				"1"=>$reg->nombre,
				"2"=>$reg->dniruc,
				"3"=>($reg->tipo)?'<span>ANEXO</span>':'<span>PRINCIPAL</span>',
				"4"=>$reg->departamento,
				"5"=>$reg->provincia,
				"6"=>$reg->distrito,
				"7"=>$reg->localidad,
				"8"=>$reg->nombredireccion,
				"0"=>$reg->iddireccion);
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

}
?>