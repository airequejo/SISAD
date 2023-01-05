<?php

if (strlen(session_id()) < 1)
  session_start();
   
require_once "../modelos/Detalleproductos.php";
$detalleproducto=new Detalleproducto();

$iddetalleproductodivisionaria=isset($_POST["iddetalleproductodivisionaria"])? limpiarCadena($_POST["iddetalleproductodivisionaria"]):"";
$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$iddivisionaria=isset($_POST["iddivisionaria"])? limpiarCadena($_POST["iddivisionaria"]):"";

switch ($_GET["op"])
{
	case 'guardaryeditar':
	$rspta=$detalleproducto->editar($iddetalleproductodivisionaria,$idproducto,$iddivisionaria);
			$rows = mysqli_num_rows($rspta);
			$data = mysqli_fetch_assoc($rspta);
			echo json_encode($data,JSON_UNESCAPED_UNICODE);		
		
	break;    
   
	case 'activar':
		$rspta=$detalleproducto->activar($iddetalleproductodivisionaria);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : activar divisionaria";
		break;	
	
		case 'desactivar':
			$rspta=$detalleproducto->desactivar($iddetalleproductodivisionaria);
			echo $rspta ? "Operación Aceptada" : "No se pudo completar : desactivar divisionaria";
			break;

	case 'mostrar':
		$rspta=$detalleproducto->mostrar($iddetalleproductodivisionaria);
		echo json_encode($rspta);
		break;

    case 'listar':
		$rspta=$detalleproducto->listar();
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			if($reg->estado==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->iddetalleproductodivisionaria.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->iddetalleproductodivisionaria.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->iddetalleproductodivisionaria.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}
			$data[]=array(
				"6"=>$opt,
				"5"=>$reg->idproducto.'-'.$reg->producto,
                "4"=>$reg->divisionaria,
                "3"=>$reg->subcuenta,
                "2"=>$reg->cuenta,
				"1"=>$reg->iddetalleproductodivisionaria,
				"0"=>($reg->estado==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>');
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
	break;

		


}


