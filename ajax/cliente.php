<?php
if (strlen(session_id()) < 1)
  session_start();

require_once "../modelos/Cliente.php";
$cliente=new Cliente();

$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idclientex=isset($_POST["idclientex"])? limpiarCadena($_POST["idclientex"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipodocumento=isset($_POST["tipodocumento"])? limpiarCadena($_POST["tipodocumento"]):"";
$dniruc=isset($_POST["dniruc"])? limpiarCadena($_POST["dniruc"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$referencia=isset($_POST["referencia"])? limpiarCadena($_POST["referencia"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";

$ubigeo=isset($_POST["ubigeo"])? limpiarCadena($_POST["ubigeo"]):"";

/*$departamento=isset($_POST["departamento"])? limpiarCadena($_POST["departamento"]):"";
$provincia=isset($_POST["provincia"])? limpiarCadena($_POST["provincia"]):"";
$distrito=isset($_POST["distrito"])? limpiarCadena($_POST["distrito"]):""; */

switch ($_GET["op"]) {

	case 'guardaryeditar':
		if(empty($idcliente)){
			
			$rspta=$cliente->insertar($idcliente,$nombre,$tipodocumento,$dniruc,$direccion,$referencia,$celular,$email,$ubigeo);			
			$rows = mysqli_num_rows($rspta);
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);

		}else{
			$rspta=$cliente->editar($idcliente,$nombre,$tipodocumento,$dniruc,$celular,$email);
			$rows = mysqli_num_rows($rspta);
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);

		}

		break;
		
	case 'guardar_cliente':
			$rspta=$cliente->insertar($idclientex,$nombre,$tipodocumento,$dniruc,$direccion,$referencia,$celular,$email,$ubigeo);			
			$rows = mysqli_num_rows($rspta);
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);

		break;

	case 'desactivar':
		$rspta=$cliente->desactivar($idcliente);
			echo $rspta ? "Operación Aceptada" : "Operación no se pudo completar : insertar cliente";
		break;

	case 'activar':
		$rspta=$cliente->activar($idcliente);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar cliente";
		break;

	case 'mostrar':
		$rspta=$cliente->mostrar($idcliente);
		echo json_encode($rspta);
		break;
		
	case 'buscar':
		$rspta=$cliente->buscar($dniruc);
		echo json_encode($rspta);
		break;
		
	
	case "llenar_cliente":
	
			$rspta = $cliente->select_combo_cliente();
			$json = [];

			
			while ($reg = $rspta->fetch_assoc())
			{
				 $json[] = ['id'=>$reg['idcliente'], 'text'=>$reg['nombre'].' - '.$reg['dniruc']];
			}
			echo json_encode($json);

		break;	

	case 'listar':
		$rspta=$cliente->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idcliente.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idcliente.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idcliente.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}

			$data[]=array(
				"6"=>$opt,
				"1"=>$reg->idcliente,
				"2"=>$reg->nombre,
				"3"=>$reg->dniruc,
				"4"=>$reg->direccion,
				"5"=>$reg->celular,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

	case "select_combo_cliente":
		$rspta = $cliente->select_combo_cliente();
		echo "<option value='0'>SELECCIONE</option>";
		while ($reg = $rspta->fetch_object())
		{
			echo '<option value='.$reg->idcliente.'>'.$reg->nombre .' - '.$reg->dniruc.'</option>';
		}
	break;	


}

?>
