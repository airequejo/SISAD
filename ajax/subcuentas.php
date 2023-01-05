<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Subcuentas.php";
$subcuenta=new Subcuentas();

$idsubcuenta=isset($_POST["idsubcuenta"])? limpiarCadena($_POST["idsubcuenta"]):"";
$codigosubcuenta=isset($_POST["codigosubcuenta"])? limpiarCadena($_POST["codigosubcuenta"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";

$country=isset($_POST["country"])? limpiarCadena($_POST["country"]):"";


switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idsubcuenta)){
			$rspta=$subcuenta->insertar($codigosubcuenta,$descripcion,$idcuenta);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$subcuenta->editar($idsubcuenta,$codigosubcuenta,$descripcion,$idcuenta);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;
   
	case 'activar':
		$rspta=$subcuenta->activar($idsubcuenta);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar cuenta";
		break;	
	
		case 'desactivar':
			$rspta=$subcuenta->desactivar($idsubcuenta);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar cuenta";
			break;

	case 'mostrar':
		$rspta=$subcuenta->mostrar($idsubcuenta);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$subcuenta->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
            if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idsubcuenta.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idsubcuenta.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idsubcuenta.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}
			$data[]=array(
				"5"=>$opt,
                "4"=>$reg->cuenta,
                "3"=>$reg->descripcion,
                "2"=>$reg->codigosubcuenta,
				"1"=>$reg->idsubcuenta,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

	case "select_combo_cuentas":	
		$rspta = $subcuenta->select_combo_subcuentas();
		echo "<option value=''>SELECCIONE UNA SUBCUENTA</option>";

		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idsubcuenta.'>'.$reg->cuenta.' / '.$reg->subcuenta .'</option>';
	
		}

	break;		




}


