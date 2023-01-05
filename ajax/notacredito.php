<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Notacredito.php";
$notacredito=new Enviar();

$id=isset($_POST["id"])? limpiarCadena($_POST["id"]):"";
$idcomprobantenc=isset($_POST["idcomprobantenc"])? limpiarCadena($_POST["idcomprobantenc"]):"";
$idmotivo=isset($_POST["idmotivo"])? limpiarCadena($_POST["idmotivo"]):"";
$descripcionmotivo=isset($_POST["descripcionmotivo"])? limpiarCadena($_POST["descripcionmotivo"]):"";
$idusuario=$_SESSION["idusuario"];
$fecha=date('Y-m-d');

switch ($_GET["op"]) {
	case 'guardaryeditar':
		$idusuario=$_SESSION["idusuario"];

		if (empty($_SESSION["idusuario"]))
		{
			header("Location: ../index.php");
		}
		else
		{


			$rspta=$notacredito->nota_credito($id,$idusuario,$fecha,$idcomprobantenc,$idmotivo,$descripcionmotivo);

			$rows = mysqli_num_rows($rspta);		

            $data = mysqli_fetch_assoc($rspta);
            echo json_encode($data,JSON_UNESCAPED_UNICODE);


		}
		
			
		break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
		echo json_encode($rspta);
		break;

}
