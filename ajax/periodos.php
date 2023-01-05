<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Periodos.php";
$periodo=new Periodos();

$idperiodo=isset($_POST["idperiodo"])? limpiarCadena($_POST["idperiodo"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idperiodo)){
			$rspta=$periodo->insertar($descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$periodo->editar($idperiodo,$descripcion);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;

   
	case 'activar':
		$rspta=$periodo->activar($idperiodo);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar periodo";
		break;	
	
		case 'desactivar':
			$rspta=$periodo->desactivar($idperiodo);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar periodo";
			break;

	case 'mostrar':
		$rspta=$periodo->mostrar($idperiodo);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$periodo->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idperiodo.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idperiodo.')"><i class="fas fa-trash text-red"></i> Cerrar</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idperiodo.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}
			
			$data[]=array(
				"3"=>$opt,
                "2"=>$reg->descripcion,
				"1"=>$reg->idperiodo,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Cerrado</span>');
			
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_periodos":		
		$rspta = $periodo->select_combo_periodos();
		//echo "<option value='-'>SELECCIONE</option>";
		//echo "<option value='0'>NO APLICA</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idperiodo.'>'.$reg->descripcion .'</option>';
		}

	break;	

	case "select_combo_periodos_noaplica":		
		// $rspta = $periodo->select_combo_periodos();
		//echo "<option value='-'>SELECCIONE</option>";
		echo "<option value='0'>NO APLICA</option>";
		/*while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idperiodo.'>'.$reg->descripcion .'</option>';
		}*/

	break;	

	case "select_combo_periodo_precio_producto":		
		$rspta = $periodo->select_combo_periodo_precio_producto($idproducto);
		echo "<option value='-'>SELECCIONE UN PERIODO</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idperiodo.'>'.$reg->periodo .'</option>';
		}

	break;	


}


