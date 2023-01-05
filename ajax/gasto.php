<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Gasto.php";
$gasto=new Gastos();

$idgasto=isset($_POST["idgasto"])? limpiarCadena($_POST["idgasto"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idgasto)){
			$rspta=$gasto->insertar($descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$gasto->editar($idgasto,$descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;

   
	case 'activar':
		$rspta=$gasto->activar($idgasto);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar gasto";
		break;	
	
		case 'desactivar':
			$rspta=$gasto->desactivar($idgasto);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar gasto";
			break;

	case 'mostrar':
		$rspta=$gasto->mostrar($idgasto);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$gasto->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idgasto.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idgasto.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idgasto.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}


			$data[]=array(
				"3"=>$opt,
                "2"=>$reg->descripcion,
				"1"=>$reg->idgasto,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_gastos":		
		$rspta = $gasto->select_combo_gastos();
		echo "<option value=''>SELECCIONE UN GASTO</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idgasto.'>'.$reg->descripcion .'</option>';
		}

	break;	


}


