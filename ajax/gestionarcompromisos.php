<?php 
if (strlen(session_id()) < 1) 
  session_start();

date_default_timezone_set('America/Lima');

require_once "../modelos/Gestionarcompromisos.php";
$cuentapc = new Gestionarcompromiso();

$idusuario=$_SESSION["idusuario"];

$idcredito=isset($_POST["idcredito"])? limpiarCadena($_POST["idcredito"]):"";
$fechapago=isset($_POST["fechapago"])? limpiarCadena($_POST["fechapago"]):"";
$monto=isset($_POST["monto"])? limpiarCadena($_POST["monto"]):"";
$idformapago=isset($_POST["idformapago"])? limpiarCadena($_POST["idformapago"]):"";
$operacion=isset($_POST["operacion"])? limpiarCadena($_POST["operacion"]):"";
$fechaoperacion=isset($_POST["fechaoperacion"])? limpiarCadena($_POST["fechaoperacion"]):"";


switch ($_GET["op"]) {

	case 'insert_credito':
		if (empty($_SESSION["idusuario"]))
		{
			header("Location: ../index.php");
		}
		else
		{
			$rspta = $cuentapc->insert_credito($idcredito,$fechapago,$monto,$idformapago,$operacion,$fechaoperacion,$idusuario);

			$rows = mysqli_num_rows($rspta);			
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);			

		}
		break;

	case 'desactivar':
		$rspta=$cuentapc->anular_pago_credito($_POST["id"],$idusuario);
		echo $rspta ? "Operación Aceptada" : "No se pudo completar : Anular pago";
		break;

	case 'combo_cliente_credito':

			$rspta = $cuentapc->combo_cliente_credito();
			echo "<option value='0'> SELECCIONE UN NOMBRE O DNI</option>";
			while ($reg = $rspta->fetch_object())
			{
				echo '<option value='.$reg->idcliente.'>'.$reg->nombre .' - '.$reg->dniruc.'</option>';
			}
		break;

	case 'mostrar_detalle_credito':

		$rspta=$cuentapc->mostrar_detalle_credito($idcredito);
		echo json_encode($rspta);
		break;
		
		
	case 'listar':

		$idcliente = $_REQUEST["idcliente"];
		$rspta=$cuentapc->listar($idcliente );

		$data= Array();
		while ($reg=$rspta->fetch_object()){			
				$hoy = date('Y-m-d'); 
				$dias	= (strtotime($hoy)-strtotime($reg->fecha_vencimiento))/86400;
				$dias 	= abs($dias); $dias = floor($dias);	
				$x=$dias;

				if ($reg->deuda_actual==0.00) {
					$opt = '<ul class="nav nav-tabs">
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
					  <div class="dropdown-menu">			
						<a data-toggle="modal"  href="#modal_detalle_pagos"  class="dropdown-item"  onclick="mostrar_detalle_pagos('.$reg->idcredito.');"><i class="fas fa-align-justify text-orange"></i> Detalle pagos</a>
					  </div>
					</li>
				  </ul>';
				} else {
	
					$opt = '<ul class="nav nav-tabs">
					<li class="nav-item dropdown">
					  <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
					  <div class="dropdown-menu">				
					  <a data-toggle="modal"  href="#modal_pagar_credito_ingreso"  class="dropdown-item"  onclick="mostrar_detalle_credito('.$reg->idcredito.');"><i class="fas fa-plus text-primary"></i> Registrar pago</a>
					  <div class="dropdown-divider"></div> 
					  <a data-toggle="modal"  href="#modal_detalle_pagos"  class="dropdown-item"  onclick="mostrar_detalle_pagos('.$reg->idcredito.');"><i class="fas fa-align-justify text-orange"></i> Detalle pagos</a>
					    </div>
					</li>
				  </ul>';
				}

				if ($reg->deuda_actual=="0.00") 				{
					$fech_est = '<span class="text-green"> Deuda Pagada</span>';
				}

				elseif ($reg->fecha_vencimiento>$hoy) 
				{
					$fech_est = '<span class="text-blue">Vence '.$x.' Dias</span>';
				}
				else
				{
					$fech_est = '<span class="text-red">Vencido '.$x.' Dias</span>';
				}
				$data[]=array(				
				"0"=>$reg->idcredito,
				"1"=>'<a href="../reportes/ticketVenta.php?id='.$reg->idventa.'" target="_blank" title="Ver Detalle">'.$reg->comprobante.'</a>',
				//"2"=>$reg->usuario,
				//"3"=>$reg->nombre,
				"2"=>date("d-m-Y H:i:s",strtotime($reg->fecha_credito)),
				"3"=>$reg->total,
				"4"=>$reg->montoabonado,
				"5"=>$reg->monto_credito,
				"6"=>$reg->deuda_actual, 
				"7"=>date("d-m-Y",strtotime($reg->fecha_vencimiento)),
				"8"=>($reg->deuda_actual < $reg->monto_credito )?'<span class="badge badge-blue"><a href="../reportes/detalle_pagos.php?id='.$reg->idcredito.'" target="_blank" title="Detalle de pagos"><font color="green">Ver pagos</font></a></span>':'<span class="text-orange">Pendiente</span>',
				"9"=>$fech_est,
				"10"=>$opt
				
			);
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

// '<span class="badge badge-yellow"><a href="../reportes/detalle_pagos.php?id='.$reg->idcredito.'" target="_blank" title="Detalle de pagos"><font color="red">Pendiente</font></a></span>'
// <span class="badge badge-blue"><a href="../reportes/detalle_pagos.php?id='.$reg->idcredito.'" target="_blank" title="Detalle de pagos"><font color="green">Ver pagos</font></a></span>
	case 'listar_detalle_pagos':

		$rspta=$cuentapc->listar_detalle_pagos($_GET["idcredito"]);
		$data= Array();
		while ($reg=$rspta->fetch_object()){
			$data[]=array(
				"3"=>($reg->estado)?'<button type="button" class="btn btn-warning btn-xs" title="Desactivar" onclick="desactivar('.$reg->iddetallecredito.')"><i class="fa fa-trash text-white" aria-hidden="true"></i></button>':
					'<b class="text-red">Anulado<b>',
				"1"=>date("d-m-Y H:i:s",strtotime($reg->fechapago)),
				"2"=>$reg->monto,
				"0"=>$reg->comprobante);
		}
		$results = array(
			"sEcho"=>1,
			"iTotalRecords"=>count($data),
			"iTotalDisplayRecords"=>count($data),
			"aaData"=>$data);
		echo json_encode($results);
		break;

		

}
?>