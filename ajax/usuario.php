<?php
session_start();
require_once "../modelos/Usuarios.php";

$usuario = new Usuario();

$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}

		}
		//Hash SHA256 en la contraseña

		$clavehash=hash("SHA256",$clave);


		if (empty($idusuario)){
			$rspta=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $rspta ? "Operación aceptada" : "Operación no se pudo completar : insertar usuario";
		}
		else {
			$rspta=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
			echo $rspta ? "Operación aceptada" : "Operación no se pudo completar : actualizar usuario";
		}
	break;

	case 'desactivar':
		$rspta=$usuario->desactivar($idusuario);
 		echo $rspta ? "Operación aceptada" : "Operación no se pudo completar : desactivar usuario";

	break;

	case 'activar':
		$rspta=$usuario->activar($idusuario);
 		echo $rspta ? "Operación aceptada" : "Operación no se pudo completar : activar usuario";

	break;

	case 'mostrar':
		$rspta=$usuario->mostrar($idusuario);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;

	case 'listar':
		$rspta=$usuario->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
            if($reg->condicion==1)
			{
				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">			
					<a data-toggle="modal"  href="#mymodal"  class="dropdown-item"  onclick="mostrar('.$reg->idusuario.')"><i class="fas fa-pencil-alt text-orange"></i> Modificar</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#" onclick="desactivar('.$reg->idusuario.')"><i class="fas fa-trash text-red"></i> Anular</a>
				  </div>
				</li>
			  </ul>';
			}else{

				$opt = '<ul class="nav nav-tabs">
				<li class="nav-item dropdown">
				  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
				  <div class="dropdown-menu">				
					<a class="dropdown-item" href="#" onclick="activar('.$reg->idusuario.')"><i class="far fa-check-circle text-green"></i> Activar</a>
				  </div>
				</li>
			  </ul>';

			}

 			$data[]=array(
 				"8"=>$opt,
 				"1"=>$reg->nombre,
 				"2"=>$reg->tipo_documento,
 				"3"=>$reg->num_documento,
 				"4"=>$reg->telefono,
 				"5"=>$reg->email,
 				"6"=>$reg->login,
 				"7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
 				"0"=>($reg->condicion==1)?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Inactivo</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'permisos':
	//Obtenemos todos los permisos de la tabla perisos
		require_once "../modelos/Permisos.php";
		$permiso = new Permiso();
		$rspta = $permiso->listar();

		//obtener permisos asignados al usuario
		$id=$_GET['id'];
		$marcados = $usuario->listarmarcados($id);
		$valores=array();

		//almacenar los permisos asignados al usuario en el array
		while ($per = $marcados->fetch_object())
		{
			array_push($valores,$per->idpermiso);
		}

		//Mostramos la lista de permisos en la vista y si estan o no marcados
		while ($reg = $rspta->fetch_object())
			{
				$sw=in_array($reg->idpermiso,$valores)?'checked':'';
				echo '<li><input type="checkbox" '.$sw.' name="permiso[]" value="'.$reg->idpermiso.'">'.$reg->nombre.' </li>';
			}

	break;

	case 'verificar':
		$logina=$_POST['logina'];
		$clavea=$_POST['clavea'];

		//encriptamos la clave ingresada por el usuario para luego compararla
		$clavehash=hash("SHA256",$clavea);

		$rspta=$usuario->verificar($logina,$clavehash);
		$fetch=$rspta->fetch_object();

		if (isset($fetch))
		{
			//Declaramos las variables de Sesion
			$_SESSION['idusuario']=$fetch->idusuario;
			$_SESSION['nombre']=$fetch->nombre;
			$_SESSION['imagen']=$fetch->imagen;
			$_SESSION['login']=$fetch->login;
			//$_SESSION['url_public']=$fetch->url_public;

			//obtener los permisos del usuario
			$marcados = $usuario->listarmarcados($fetch->idusuario);

			//Declaramos un array para almaenar todos los permisos mrcados
			$valores=array();
			//almacenamos los permisos marcados en el array
			while  ($per = $marcados->fetch_object())
				{
					array_push($valores,$per->idpermiso);

				}
			//Determinamos los accesos de los usuarios
				in_array(1,$valores)?$_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
				in_array(2,$valores)?$_SESSION['ingresos']=1:$_SESSION['ingresos']=0;
				in_array(3,$valores)?$_SESSION['egresos']=1:$_SESSION['egresos']=0;
				in_array(4,$valores)?$_SESSION['bancos']=1:$_SESSION['bancos']=0;
				in_array(5,$valores)?$_SESSION['productos']=1:$_SESSION['productos']=0;
				in_array(6,$valores)?$_SESSION['cuentas']=1:$_SESSION['cuentas']=0;
				in_array(7,$valores)?$_SESSION['actividades']=1:$_SESSION['actividades']=0;
				in_array(8,$valores)?$_SESSION['configuracion']=1:$_SESSION['configuracion']=0;
				in_array(9,$valores)?$_SESSION['caja']=1:$_SESSION['caja']=0;
				in_array(10,$valores)?$_SESSION['reportes']=1:$_SESSION['reportes']=0;
				in_array(11,$valores)?$_SESSION['accesos']=1:$_SESSION['accesos']=0;
				in_array(12,$valores)?$_SESSION['gestion']=1:$_SESSION['gestion']=0;
				in_array(13,$valores)?$_SESSION['ctscobrar']=1:$_SESSION['ctscobrar']=0;
				
	

		}
		echo json_encode($fetch);

	break;
	case 'salir':
		//Limpiamos las variables de session
		session_unset();
		//Destruimos la sesion
		session_destroy();
		//redireccionamos al login
		header("Location: ../index.php");
	break;
}

