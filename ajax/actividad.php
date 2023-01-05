<?php
if (strlen(session_id()) < 1) 
    session_start();



require_once "../modelos/Actividad.php";
$actividad = new Actividad();

$idactividad = isset($_POST["idactividad"]) ? limpiarCadena($_POST["idactividad"]) : "";
$descripcion = isset($_POST["descripcion"]) ? limpiarCadena($_POST["descripcion"]) : "";
$idsubgasto = isset($_POST["idsubgasto"]) ? limpiarCadena($_POST["idsubgasto"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";
$idperiodo = isset($_POST["idperiodo"]) ? limpiarCadena($_POST["idperiodo"]) : "";

switch ($_GET["op"]) {
	case 'guardaryeditar':
		if (empty($idactividad)) {
			$rspta = $actividad->insertar($descripcion, $idsubgasto, $fecha, $idperiodo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		} else {
			$rspta = $actividad->editar($idactividad, $descripcion, $idsubgasto, $fecha, $idperiodo);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
		}

		break;

	case 'activar':
		$rspta = $actividad->activar($idactividad);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar actividad";
		break;

	case 'desactivar':
		$rspta = $actividad->desactivar($idactividad);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar actividad";
		break;

	case 'mostrar':
		$rspta = $actividad->mostrar($idactividad);
		echo json_encode($rspta);
		break;

	case 'listar':
		$rspta = $actividad->listar();
		$data = array();
		while ($reg = $rspta->fetch_object()) {
			if ($reg->estado == 1) {
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar(' . $reg->idactividad . ')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar(' . $reg->idactividad . ')"><i class="fas fa-trash text-red"></i> Cerrar</a>
				  </div>
				</li>
			  </ul>';
			} else {

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar(' . $reg->idactividad . ')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';
			}
			$data[] = array(
				"5" => $opt,
				"4" => $reg->descripcion,
				"3" => $reg->subgasto,
				"2" => $reg->gasto,
				"1" => $reg->idactividad,
				"0" => ($reg->estado == 1) ? '<span class="badge badge-info">Vigente</span>' : '<span class="badge badge-danger">Cerrado</span>'
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

	case "select_combo_actividad":
		$rspta = $actividad->select_combo_actividad();
		echo "<option value=''>SELECCIONE ACTIVIDAD</option>";
		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idactividad . '>' . $reg->descripcion . '   ( ' . $reg->subgasto . ' - ' . $reg->gasto . ' )</option>';
		}

		break;
}
