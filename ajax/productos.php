<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Productos.php";
$producto = new Productos();

$idproducto = isset($_POST["idproducto"]) ? limpiarCadena($_POST["idproducto"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$idunidadmedida = isset($_POST["idunidadmedida"]) ? limpiarCadena($_POST["idunidadmedida"]) : "";
$aplicamovimiento = isset($_POST["aplicamovimiento"]) ? limpiarCadena($_POST["aplicamovimiento"]) : "";
$tipo = isset($_POST["tipo"]) ? limpiarCadena($_POST["tipo"]) : "";

// detale producto diviionaria
$idproducto_detalle = isset($_POST["idproducto_detalle"]) ? limpiarCadena($_POST["idproducto_detalle"]) : "";
$iddivisionaria = isset($_POST["iddivisionaria"]) ? limpiarCadena($_POST["iddivisionaria"]) : "";

$codigobarra = isset($_POST["codigobarra"]) ? limpiarCadena($_POST["codigobarra"]) : "";

$fechaproceso = date('Y-m-d');

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idproducto)) {
			$rspta = $producto->insertar($descripcion, $idunidadmedida, $aplicamovimiento, $tipo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		} else {
			$rspta = $producto->editar($idproducto, $descripcion, $idunidadmedida, $aplicamovimiento, $tipo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		break;

	case 'guardardetalleproducto':
		$rspta = $producto->insertar_detalle_producto($idproducto_detalle, $iddivisionaria);
		$rows = mysqli_num_rows($rspta);
		$data = mysqli_fetch_assoc($rspta);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		break;

	case 'activar':
		$rspta = $producto->activar($idproducto);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar cuenta";
		break;

	case 'desactivar':
		$rspta = $producto->desactivar($idproducto);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar cuenta";
		break;

	case 'mostrar':
		$rspta = $producto->mostrar($idproducto);
		echo json_encode($rspta);
		break;

	case 'mostrar_stock_lotes':
		$rspta = $producto->mostrar_stock_lotes($codigobarra);
		echo json_encode($rspta);
		break;

	case 'mostrar_detalle_producto':
		$rspta = $producto->mostrar_detalle_producto($idproducto);
		echo json_encode($rspta);
		break;


	case 'listar':
		$rspta = $producto->listar();
		$data = array();
		while ($reg = $rspta->fetch_object()) {
			if ($reg->tipo == 1) {
				$tipo = '<span class="text-blue">SERVICIO</span>';
			} else {
				$tipo = '<span class="text-blue">BIEN</span>';
			}
			if ($reg->estado == 1) {
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">	
				  	<a  class="dropdown-item" href="#" onclick="modal_asignar(' . $reg->idproducto . ')"><i class="fas fa-plus text-primary"></i> Asignar divisionaria</a>	
					  <div class="dropdown-divider"></div>			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar(' . $reg->idproducto . ')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar(' . $reg->idproducto . ')"><i class="fas fa-trash text-red"></i> Anular</a>
					<div class="dropdown-divider"></div>
					<a data-toggle="modal"  class="dropdown-item" href="#mymodaldetalle_producto" onclick="listar_detalle(' . $reg->idproducto . ')"><i class="fas fa-align-justify text-info"></i> Detalle</a>
				  </div>
				</li>
			  </ul>';
			} else {

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar(' . $reg->idproducto . ')"><i class="far fa-check-circle text-green"></i> Activar</a>
					<div class="dropdown-divider"></div>
					<a data-toggle="modal"  class="dropdown-item"  href="#mymodaldetalle_producto" onclick="listar_detalle(' . $reg->idproducto . ')"><i class="fas fa-align-justify text-info"></i> Detalle</a>
				  </div>
				</li>
			  </ul>';
			}
			if ($reg->aplicamovimiento == 1) {
				$aplicamovimiento = '<span class="text-green"><b>APLICA</b></span>';
			} else {
				$aplicamovimiento = '<span class="text-red"><b>NO APLICA</b></span>';
			}
			$data[] = array(
				"9" => $opt,
				"8" => $aplicamovimiento,
				"7" => $reg->stock,
				"6" => $reg->preventa,
				"5" => $reg->precompra,
				"4" => $reg->unidadmedida,
				"3" => $reg->descripcion,
				"1" => $reg->idproducto,
				"2" => $tipo,
				"0" => ($reg->estado == 1) ? '<span class="badge badge-info">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case 'listar_detalle_producto':
		$id = $_GET['id'];
		$rspta = $producto->listar_detalle_producto($id);
		$data = array();
		while ($reg = $rspta->fetch_object()) {

			$data[] = array(
				"3" => '<b class="text-green">' . $reg->producto . '</b>',
				"2" => $reg->divisionaria,
				"1" => $reg->subcuenta,
				"0" => $reg->cuenta,
				"4" => ($reg->estado == 1) ? '<span class="badge badge-info">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>'
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);
		break;

	case "select_combo_productos":
		$rspta = $producto->select_combo_productos();
		echo "<option value=''>SELECCIONE UN PRODUCTO</option>";

		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->iddetalleproductodivisionaria . '>' . $reg->iddetalleproductodivisionaria . '-' . $reg->descripcion . '</option>';
		}

		break;


	case "select_combo_unidadmedidas":
		$rspta = $producto->select_combo_unidadmedidas();
		echo "<option value=''>SELECCIONE UNA UNIDAD MEDIDAD</option>";
		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idunidadmedida . '>' . $reg->codigounidadmedida . '-' . $reg->descripcion . '</option>';
		}

		break;

		// caso listar productos modal venta productos para agregar a venta

	case 'listarProducto':
		//require_once "../modelos/Productos.php";
		//$producto=new Productos();

		$rspta = $producto->listar_stock_lotes($fechaproceso);
		$data = array();
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"6" => '<button type="button" class="btn btn-success btn-xs" onclick="mostrar_codigobarra(' . $reg->codigobarra . ')" data-dismiss="modal" aria-hidden="true" ><span class="fa fa-plus"></span></button> ',
				"3" => '<span class="text-primary text-center">' . date("d-m-Y", strtotime($reg->codigobarra)) . '</span>',
				"4" => '<span class="badge bg-orange text-center">' . $reg->stock . '</span>',
				"0" => '<span class="badge bg-red">' . $reg->codigobarra . '</span>',
				"5" => '<span class="badge bg-purple">' . $reg->precioventa . '</span>',
				"2" => $reg->codigobarra,
				"1" => $reg->descripcion
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;

		// listar producto compra

	case 'listar_productos_compra':
		$rspta = $producto->listar_productos_compra();
		//Vamos a declarar un array
		$data = array();

		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"3" => '<button type="button" class="btn btn-warning btn-xs" onclick="agregar_compra_temp(' . $reg->iddetalleproductodivisionaria . ')"><span class="fa fa-plus"> Agregar</span></button>',
				"0" => $reg->iddetalleproductodivisionaria,
				"1" => $reg->descripcion,
				"2" => $reg->divisionaria
			);
		}
		$results = array(
			"sEcho" => 1, //Información para el datatables
			"iTotalRecords" => count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
			"aaData" => $data
		);
		echo json_encode($results);
		break;



	case 'listar_productos_precio':
		// '.$reg->idproducto.',\''.$reg->stock.'\'
		$rspta = $producto->listar_productos_precios();
		$data = array();
		// tipo   bien =0   servicio=1
		// aplicamovimiento si= 1 no=0
		while ($reg = $rspta->fetch_object()) {
			$data[] = array(
				"0" => '<span class="label text-red">( ' . $reg->idproducto . ' )</span>' . $reg->descripcion,
				//"1" => $reg->preciocompra,
				//"2" => $reg->precioventa,
				"1" => '<button type="button" class="btn btn-info btn-xs" onclick="mostrar_producto_precio('.$reg->idproducto.','.$reg->tipo.','.$reg->aplicamovimiento.','.$reg->tipocuenta.')" title="Agregar"><i class="fa fa-plus" aria-hidden="true" ></i> Modificar </button>'
			);
		}
		$results = array(
			"sEcho" => 1,
			"iTotalRecords" => count($data),
			"iTotalDisplayRecords" => count($data),
			"aaData" => $data
		);
		echo json_encode($results);
		break;
}
