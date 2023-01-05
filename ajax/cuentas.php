<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Cuentas.php";
$cuenta=new Cuentas();

$idcuenta=isset($_POST["idcuenta"])? limpiarCadena($_POST["idcuenta"]):"";
$codigocuenta=isset($_POST["codigocuenta"])? limpiarCadena($_POST["codigocuenta"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$tipo=isset($_POST["tipo"])? limpiarCadena($_POST["tipo"]):"";

switch ($_GET["op"])
{
    case 'guardaryeditar':
		if(empty($idcuenta)){
			$rspta=$cuenta->insertar($codigocuenta,$descripcion,$tipo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		
		}else{
			$rspta=$cuenta->editar($idcuenta,$codigocuenta,$descripcion,$tipo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}
		
	break;

   
	case 'activar':
		$rspta=$cuenta->activar($idcuenta);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar cuenta";
		break;	
	
		case 'desactivar':
			$rspta=$cuenta->desactivar($idcuenta);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar cuenta";
			break;

	case 'mostrar':
		$rspta=$cuenta->mostrar($idcuenta);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$cuenta->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idcuenta.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idcuenta.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idcuenta.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}

            if($reg->tipo==1) { $tipo = 'INGRESOS';  }else { $tipo = 'EGRESOS'; }

			$data[]=array(
				"5"=>$opt,
                "4"=>$tipo,
                "3"=>$reg->descripcion,
                "2"=>$reg->codigocuenta,
				"1"=>$reg->idcuenta,
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
		$rspta = $cuenta->select_combo_cuentas();
		echo "<option value=''>SELECCIONE UNA CUENTA</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcuenta.'>'.$reg->descripcion .'</option>';
		}

	break;	


}


