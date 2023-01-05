<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Subgasto.php";
$subgasto=new Subgastos();

$idsubgasto=isset($_POST["idsubgasto"])? limpiarCadena($_POST["idsubgasto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idgasto=isset($_POST["idgasto"])? limpiarCadena($_POST["idgasto"]):"";

$country=isset($_POST["country"])? limpiarCadena($_POST["country"]):"";


switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idsubgasto)){
			$rspta=$subgasto->insertar($descripcion,$idgasto);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$subgasto->editar($idsubgasto,$descripcion,$idgasto);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;
   
	case 'activar':
		$rspta=$subgasto->activar($idsubgasto);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar cuenta";
		break;	
	
		case 'desactivar':
			$rspta=$subgasto->desactivar($idsubgasto);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar cuenta";
			break;

	case 'mostrar':
		$rspta=$subgasto->mostrar($idsubgasto);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$subgasto->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
            if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idsubgasto.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idsubgasto.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idsubgasto.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}
			$data[]=array(
				"4"=>$opt,
                "3"=>$reg->gasto,
                "2"=>$reg->descripcion,
				"1"=>$reg->idsubgasto,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_subgasto":	
		$rspta = $subgasto->select_combo_subgastos();
		echo "<option value=''>SELECCIONE UNA SUBGASTO</option>";

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idsubgasto.'>'.$reg->gasto.' // '.$reg->subgasto .'</option>';
	
		}

	break;		




}


