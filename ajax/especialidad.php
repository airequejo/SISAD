<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Especialidad.php";
$especialidades=new Especialidad();

$idespecialidad=isset($_POST["idespecialidad"])? limpiarCadena($_POST["idespecialidad"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idespecialidad)){
			$rspta=$especialidades->insertar($descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$especialidades->editar($idespecialidad,$descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;

   
	case 'activar':
		$rspta=$especialidades->activar($idespecialidad);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar especialidad";
		break;	
	
		case 'desactivar':
			$rspta=$especialidades->desactivar($idespecialidad);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar especialidad";
			break;

	case 'mostrar':
		$rspta=$especialidades->mostrar($idespecialidad);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$especialidades->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idespecialidad.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idespecialidad.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idespecialidad.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}


			$data[]=array(
				"3"=>$opt,
                "2"=>$reg->descripcion,
				"1"=>$reg->idespecialidad,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_especialidad":		
		$rspta = $especialidades->select_combo_especialidad();
		echo "<option value='-'>SELECCIONE UNA CUENTA</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idespecialidad.'>'.$reg->descripcion .'</option>';
		}
		echo "<option value='0'>NO APLICA</option>";

	break;	


}


