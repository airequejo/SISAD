<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Divisionarias.php";
$divisionaria=new Divisionaria();

$iddivisionaria=isset($_POST["iddivisionaria"])? limpiarCadena($_POST["iddivisionaria"]):"";
$codigodivisionaria=isset($_POST["codigodivisionaria"])? limpiarCadena($_POST["codigodivisionaria"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idsubcuenta=isset($_POST["idsubcuenta"])? limpiarCadena($_POST["idsubcuenta"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($iddivisionaria)){
			$rspta=$divisionaria->insertar($codigodivisionaria,$descripcion,$idsubcuenta);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$divisionaria->editar($iddivisionaria,$codigodivisionaria,$descripcion,$idsubcuenta);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;
   
	case 'activar':
		$rspta=$divisionaria->activar($iddivisionaria);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar divisionaria";
		break;	
	
		case 'desactivar':
			$rspta=$divisionaria->desactivar($iddivisionaria);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar divisionaria";
			break;

	case 'mostrar':
		$rspta=$divisionaria->mostrar($iddivisionaria);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$divisionaria->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->iddivisionaria.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->iddivisionaria.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->iddivisionaria.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}
			$data[]=array(
				"5"=>$opt,
                "4"=>$reg->codigodivisionaria.'-'.$reg->descripcion,
                "3"=>$reg->subcuenta,
                "2"=>$reg->cuenta,
				"1"=>$reg->iddivisionaria,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_divisionarias":		
		$rspta = $divisionaria->select_combo_divisionarias();
		echo "<option value=''>SELECCIONE DIVISIONARIA</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->iddivisionaria.'>'.$reg->codigodivisionaria.'-'.$reg->descripcion .'</option>';
		}

	break;		


}


