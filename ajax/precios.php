<?php 

date_default_timezone_set('America/Lima');

if (strlen(session_id()) < 1) 
  session_start(); 

require_once "../modelos/Precios.php";
$precio=new Precios();

$idprecio=isset($_POST["idprecio"])? limpiarCadena($_POST["idprecio"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idperiodo=isset($_POST["idperiodo"])? limpiarCadena($_POST["idperiodo"]):"";
$preciocompra=isset($_POST["preciocompra"])? limpiarCadena($_POST["preciocompra"]):"";
$precioventa=isset($_POST["precioventa"])? limpiarCadena($_POST["precioventa"]):"";
$fecha = date('Y-m-d H:i:s');

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if(empty($idprecio)){

			$rspta=$precio->insertar($idproducto,$idperiodo,$preciocompra,$precioventa,$fecha);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);	
		}
		else
		{
			$rspta=$precio->editar($idprecio,$preciocompra,$precioventa,$fecha);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);	

		}		
		
		break;
		

	case 'mostrar':
		$rspta=$precio->mostrar($idprecio);
		echo json_encode($rspta);
		break;
	
	case 'mostrar_precio_periodo':
		$rspta=$precio->mostrar_precio_periodo($idproducto,$idperiodo);
		echo json_encode($rspta);
		break;
	
	case 'listar':
		$idproducto=$_REQUEST["idproducto"];
		
		$rspta=$precio->listar($idproducto);
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				//"0"=>$reg->idproducto,
				"0"=>date("d-m-Y H:i:s",strtotime($reg->fecha)),
				"1"=>$reg->periodo,
				"2"=>$reg->preciocompra,
				"3"=>$reg->precioventa,
				"4"=>($reg->estado >=1)?'<button type="button" class="btn btn-success btn-xs" onclick="mostrar('.$reg->idprecio.')" title="Modificar precio de producto o servicio"><i class="fa fa-plus" aria-hidden="true" ></i> Modificar </button>':'');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

		case 'listar_historial':
			$idproducto=$_REQUEST["idproducto"];
			
			$rspta=$precio->listar_historial($idproducto);
			$data= Array();
			while ($reg=$rspta->fetch_object()){
				$data[]=array(
					//"0"=>$reg->idproducto,
					"0"=>date("d-m-Y H:i:s",strtotime($reg->fecha)),
					"1"=>$reg->periodo,
					"2"=>$reg->preciocompra,
					"3"=>$reg->precioventa);
			}
			$results = array(
				"sEcho"=>1,
				"iTotalRecords"=>count($data),
				"iTotalDisplayRecords"=>count($data),
				"aaData"=>$data);
			echo json_encode($results);
			break;

		

}
