<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Proveedor.php";

$proveedor = new Proveedor();

$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$dniruc=isset($_POST["dniruc"])? limpiarCadena($_POST["dniruc"]):"";
$nombrerazon=isset($_POST["nombrerazon"])? limpiarCadena($_POST["nombrerazon"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$celular=isset($_POST["celular"])? limpiarCadena($_POST["celular"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$paginaweb=isset($_POST["paginaweb"])? limpiarCadena($_POST["paginaweb"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if(empty($idproveedor)){
			$rspta=$proveedor->insertar($dniruc,$nombrerazon,$direccion,$telefono,$celular,$email,$paginaweb);
			echo $rspta ? "Operación Aceptada" : "Operación no se pudo completar : insertar proveedor";
		}else{
			$rspta=$proveedor->editar($idproveedor,$dniruc,$nombrerazon,$direccion,$telefono,$celular,$email,$paginaweb);
			echo $rspta ? "Operación Aceptada" : "Operación no se pudo completar : actualizar proveedor";
		}
		
		break;

	case 'desactivar':
		$rspta=$proveedor->desactivar($idproveedor);
 		echo $rspta ? "Proveedor se desactivo" : "Proveedor no se puede desactivar";
	break;

	case 'activar':
		$rspta=$proveedor->activar($idproveedor);
 		echo $rspta ? "Proveedor se activo" : "Proveedor no se puede activar";
	break;

	case 'mostrar':
		$rspta=$proveedor->mostrar($idproveedor);
		echo json_encode($rspta);
	break;

	
	case 'listar':
		$rspta=$proveedor->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a  class="dropdown-item"  onclick="mostrar('.$reg->idproveedor.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idproveedor.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idproveedor.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}

			$data[]=array(

				"5"=>$opt,
				"1"=>$reg->nombrerazon,
				"2"=>$reg->dniruc,
				"3"=>$reg->direccion,
				"4"=>$reg->celular,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>'
				);
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

}
