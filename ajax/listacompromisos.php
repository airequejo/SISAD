<?php 
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Listacompromisos.php";
$cuentac=new Listacompromiso();

switch ($_GET["op"]) {
		
	case 'listar':
		$rspta=$cuentac->listar();
		$data= Array();

		date_default_timezone_set('America/Lima');

		while ($reg=$rspta->fetch_object()){
			
				$hoy = date('Y-m-d'); 

				$dias	= (strtotime($hoy)-strtotime($reg->fecha_vencimiento))/86400;
				$dias 	= abs($dias); $dias = floor($dias);	
				$x=$dias;

				if ($reg->deuda_actual=="0.00") 
				{
					$fech_est = '<span class="text-green"> Deuda Pagada</span>';
				}

				elseif ($reg->fecha_vencimiento>$hoy) 
				{
					$fech_est = '<span class="text-blue">Credito vence '.$x.' Dias</span>';
				}
				else
				{
					$fech_est = '<span class="text-red">Credito vencido '.$x.' Dias</span>';
				}
				$data[]=array(				
				"0"=>$reg->idcredito,
				"1"=>$reg->comprobante,
				"2"=>$reg->usuario,
				"3"=>$reg->nombre,
				"4"=>date("d-m-Y H:i:s",strtotime($reg->fecha_credito)),
				"5"=>$reg->total,
				"6"=>$reg->montoabonado,
				"7"=>$reg->monto_credito,
				"8"=>$reg->deuda_actual, 
				"9"=>date("d-m-Y",strtotime($reg->fecha_vencimiento)),
				"10"=>$fech_est,
				"11"=>($reg->estado_deuda=='0')?'<span class="badge badge-warning text-white"><i class="fa fa-check-square-o" aria-hidden="true"></i>
  Pendiente</span>':'<span class="badge badge-green"><i class="fa fa-check-square-o" aria-hidden="true"></i>
  Pagado</span>' 
				
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
?>