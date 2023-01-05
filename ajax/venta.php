<?php 
date_default_timezone_set('America/Lima');

 if (strlen(session_id()) < 1) 
  session_start(); 
  

  

  /* $inactividad = 10;
    // Comprobar si $_SESSION["timeout"] está establecida
    if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
            session_destroy();
            header("Location: ../index.php");
        }
    }
    // El siguiente key se crea cuando se inicia sesión
    $_SESSION["timeout"] = time(); */




require_once "../modelos/Venta.php";

$venta=new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";

$idusuario= $_SESSION["idusuario"];

$fechaproceso=date('Y-m-d');

$tipoventa=isset($_POST["tipoventa"])? limpiarCadena($_POST["tipoventa"]):"";

if ($tipoventa == 2) 
{
	// $idformapago="5";
}
else
{
	// $idformapago=isset($_POST["idformapago"])? limpiarCadena($_POST["idformapago"]):"";
}

$idformapago=isset($_POST["idformapago"])? limpiarCadena($_POST["idformapago"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$idtipocomprobante=isset($_POST["idtipocomprobante"])? limpiarCadena($_POST["idtipocomprobante"]):"";
$idserienumero=isset($_POST["idserienumero"])? limpiarCadena($_POST["idserienumero"]):"";
//$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$igv=isset($_POST["igv"])? limpiarCadena($_POST["igv"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$idnotapedido=isset($_POST["idnotapedido"])? limpiarCadena($_POST["idnotapedido"]):"";
//$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$dniru=isset($_POST["dniru"])? limpiarCadena($_POST["dniru"]):"";
$nombres=isset($_POST["nombres"])? limpiarCadena($_POST["nombres"]):"";
$direc=isset($_POST["direc"])? limpiarCadena($_POST["direc"]):"";
$tipodoc=isset($_POST["tipodoc"])? limpiarCadena($_POST["tipodoc"]):"";
$procedencia=isset($_POST["procedencia"])? limpiarCadena($_POST["procedencia"]):"";

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idstocklote=isset($_POST["idstocklote"])? limpiarCadena($_POST["idstocklote"]):"";
$lote=isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$vencimiento=isset($_POST["vencimiento"])? limpiarCadena($_POST["vencimiento"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$descuento=isset($_POST["descuento"])? limpiarCadena($_POST["descuento"]):"";
$montoabonado=isset($_POST["montoabonado"])? limpiarCadena($_POST["montoabonado"]):"";
$fecha_vencimiento=isset($_POST["fecha_vencimiento"])? limpiarCadena($_POST["fecha_vencimiento"]):"";
$operacion=isset($_POST["operacion"])? limpiarCadena($_POST["operacion"]):"";
$iddireccion=isset($_POST["iddireccion"])? limpiarCadena($_POST["iddireccion"]):"";

$idespecialidad=isset($_POST["idespecialidad"])? limpiarCadena($_POST["idespecialidad"]):"";
$idciclo=isset($_POST["idciclo"])? limpiarCadena($_POST["idciclo"]):"";

$fechaproceso=date('Y-m-d');


$idindex=isset($_POST["idindex"])? limpiarCadena($_POST["idindex"]):"";

$idindex_venta=isset($_POST["idindex_venta"])? limpiarCadena($_POST["idindex_venta"]):"";

$descuento_general=isset($_POST["descuentogeneral"])? limpiarCadena($_POST["descuentogeneral"]):"";
$precio_compra_promedio=isset($_POST["precio_compra_promedio"])? limpiarCadena($_POST["precio_compra_promedio"]):"";
$fechaoperacion=isset($_POST["fechaoperacion"])? limpiarCadena($_POST["fechaoperacion"]):"";
$idperiodo=isset($_POST["idperiodo"])? limpiarCadena($_POST["idperiodo"]):"";


 require_once "../modelos/Consultas.php";
      $consultas = new Consultas;
      $rspta = $consultas->config_empresa();
      $reg = $rspta->fetch_object();
      $tipoproceso=$reg->tipoproceso;
      if ($tipoproceso=='1')
     {
        $ruta_tipo_proceso='produccion';
     }

     if ($tipoproceso=='3')
     {
        $ruta_tipo_proceso='beta';
     } 
 

switch ($_GET["op"]){
 
case 'guardaryeditar_detalle_temp':
	//$idusuario = 4;

		if (empty($_SESSION["idusuario"]))
		{
			header("Location: ../index.php");
		}else
		{ 
			$rspta=$venta->insertar_venta_temp($idproducto,$idusuario,$idindex,$idperiodo,$cantidad,$precio,$descuento,$precio_compra_promedio,$fechaproceso);

			$rows = mysqli_num_rows($rspta);			
			
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			
		}
	break;

case 'calcular_totales_venta':
	$rspta=$venta->calcular_totales_venta($idindex);
	//Codificar el resultado utilizando json
	echo json_encode($rspta);
break;



case "listar_venta_proceso_temp":		
	$rspta = $venta->listar_venta_proceso_temp($idusuario);
	echo "<option value='0'> Lista de ventas sin procesar </option>";
	while ($reg = $rspta->fetch_object())
	{
		echo '<option value='.$reg->idindex.'>'.$reg->fecha.'</option>';
	}
break;

case 'insertar_venta':
			
		if (empty($_SESSION["idusuario"]))
		{
			header("Location: ../index.php");
		}
		else
		{


			$rspta=$venta->insertar_venta($idusuario,$iddireccion,$idformapago,$tipoventa,$fecha,$idtipocomprobante,$igv,$descuento_general,$idindex_venta,$montoabonado,$fecha_vencimiento,$operacion,$fechaoperacion,$idespecialidad,$idciclo);

			$rows = mysqli_num_rows($rspta);
			
			//if ($rows > 0) 
			//{
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);
			//}
			//else
			//{
			//	echo "error";
		}

	break;

case 'insert_ventas_temp':

			//$rspta=$venta->insert_ventas_temp($_POST["idproductoo"],$_POST["precioo"],$_POST["cantidado"]);
		//	echo $rspta ? "Temp exito" : "tem vent no se puedo insertar..";
		
		break;



	case 'anular':
		$rspta=$venta->anular($idventa);
 		echo $rspta ? "venta anulado" : "venta no se puede anular";
	break;

	case 'eliminar_item':

			$rspta=$venta->eliminar_items_detalle($idproducto,$idindex);
 		//Codificar el resultado utilizando json
 		echo $rspta ? "Item eliminado" : "No se puede eliminar";
		break;

	case 'eliminar_detalle_venta_temp':
		$idindexx = $_REQUEST["idindex"];
		$rspta=$venta->eliminar_detalle_venta($idindexx);
 		//Codificar el resultado utilizando json
 		echo $rspta ? "Venta sin procesar eliminada" : "Venta no se puede eliminar";
		break;


	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	/*case 'mostrar_preventa':
		require_once "../modelos/Producto.php";
		$producto=new Producto();

		$idstocklote=$_REQUEST["idstocklote"];
		$rspta=$producto->mostrar_stock_lotes($idstocklote);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;*/

	case 'obtener_ultimo':
		$rspta=$venta->obtener_ultimo();
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

    case 'mostrar1':
		$rspta=$venta->mostrar($idventa);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'mostrar_cliente':
		require_once "../modelos/Cliente.php";
		$cliente = new Cliente;
		$idcliente=$_REQUEST["idcliente"];
		$rspta=$cliente->mostrar_cliente($idcliente);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;
	
	case 'listar':
		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$rspta=$venta->listar($fecha_inicio,$fecha_fin);


 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$url='../reportes/venta.php?id=';
 			$url2='../reportes/ticketVenta.php?id=';
 			$url3='../reportes/enviar.php?id=';
 			$url6='../reportes/pdf.php?id=';
 			$url4='notacredito.php?id=';
 			$url5='guia.php?id=';
 			/*if($reg->idtipocomprobante=='1'){
 				$anti="F00";
 			}else{
 				$anti="B00";
 			}*/
 			if($reg->idtipocomprobante==="3"){
 			        $documentito="<p style='color:steelblue;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="1") {
 			        $documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="7") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="8") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }else{
 			    	$documentito="<p style='color:orange;'>Verificar tipo comprobante</p>";
 			    }
 			    /* inicio  codigo agregado 31-05-2018 */
 			    if($reg->idtipocomprobante==="7"){
 			        $botones='<ul class="nav nav-tabs">
					 <li class="nav-item dropdown">
					 <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
					 <div class="dropdown-menu">	
						 <a target="_blank" href="'.$url2.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-print text-info"></i> Imprimir ticket</a>		
						 <div class="dropdown-divider"></div>
						 <a href="'.$url6.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-file-pdf text-red"></i> PDF</a>
					 </div>
					 </li>
				 </ul>';
 			    }


 			    else {

 			    	if ($reg->estado==="1" && $reg->nc==="0") {
 			    		$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver detalle de venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.' <a href="'.$url4.$reg->idventa.'" title="Nota de Crédito y Débito" class="btn btn-xs"><i class="fa fa-share-square-o"></i></a>';
 			    		
 			    	}else

 			    	{
 			    		if ($reg->estado==="1" && $reg->nc==="1") {
 			    			$botones='<ul class="nav nav-tabs">
							 <li class="nav-item dropdown">
							 <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
							 <div class="dropdown-menu">	
								 <a target="_blank" href="'.$url2.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-print text-info"></i> Imprimir ticket</a>		
								 
							 </div>
							 </li>
						 </ul>';
 			    		}
 			    		else{
 			    	$botones='<ul class="nav nav-tabs">
						<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Acciones</a>
						<div class="dropdown-menu">	
							<a target="_blank" href="'.$url2.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-print text-info"></i> Imprimir ticket</a>		
							<div class="dropdown-divider"></div>
							<a href="'.$url4.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-share-square text-blue"></i> Nota de Crédito</a>
							
						</div>
						</li>
					</ul>';

 			    }
				/* <div class="dropdown-divider"></div>
								 <a href="'.$url6.$reg->idventa.'" class="dropdown-item" ><i class="fas fa-file-pdf text-red"></i> PDF</a>
								 */

				// <a target="_blank" href="'.$url.$reg->idventa.'"  class="dropdown-item"><i class="fas fa-print text-warning"></i> Imprimir A4</a>							
				// <div class="dropdown-divider"></div>

 			    }
			}
			
			if($reg->msj_sunat==="soap-env:Client.1032"){
 			 	    
				$valsunat='<span class="badge bg-red">RECHAZADO</span>';
		}
			elseif(($reg->estadoenvio==='1' &&  $reg->hash_cpe==='' &&  $reg->respuesta==='') ||($reg->cod_sunat==='0000' || $reg->cod_sunat==='soap-env:Client.0109' || $reg->cod_sunat==='soap-env:Client.0200' || $reg->cod_sunat==='soap-env:Client.0201' || $reg->cod_sunat==='soap-env:Client.0202' || $reg->cod_sunat==='soap-env:Client.0203' || $reg->cod_sunat==='soap-env:Client.0204' || $reg->cod_sunat==='soap-env:Client.0250' || $reg->cod_sunat==='soap-env:Client.0251' || $reg->cod_sunat==='soap-env:Client.0252' || $reg->cod_sunat==='soap-env:Client.0253' || $reg->cod_sunat==="soap-env:Client.0110" || $reg->cod_sunat==="soap-env:Client.0111" || $reg->cod_sunat==="soap-env:Client.0112" || $reg->cod_sunat==="soap-env:Client.0113" || $reg->cod_sunat==="soap-env:Client.0130" || $reg->cod_sunat==="soap-env:Client.0131" || $reg->cod_sunat==="soap-env:Client.0132" || $reg->cod_sunat==="soap-env:Client.0133" || $reg->cod_sunat==="soap-env:Client.0134" || $reg->cod_sunat==="soap-env:Client.0135" || $reg->cod_sunat==="soap-env:Client.0136" || $reg->cod_sunat==="soap-env:Client.0137" || $reg->cod_sunat==="soap-env:Client.0138"))
 			 	{
 			 		$valsunat='<button title="Enviar a sunat" class="btn btn-xs btn-warning" onclick="enviar_sunat('.$reg->idventa.')"><i class="fa fa-check-o text-red"></i> Enviar a sunat</button>';
 			 	}
 			 		else{
 			 		$valsunat='<span class="badge bg-blue">SUNAT</span>';
 								 				
 			 	}
 			 	
 			 	/* inicio  codigo agregado 31-05-2018 
				'<a href="'.$url6.$reg->idventa.'"> <button title="PDF" class="btn btn-danger btn-xs">pdf</button></a>'
 			 	*/
 			 	$empresa_ruc=substr($reg->archivo,0,11);

 			 	if ($reg->estadoenvio==='0')
 			 	{

 			 		//$descarga_archivos='<a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/pdf/'.$reg->archivo.'.PDF'.'"> <button title="PDF" class="btn btn-primary btn-xs">pdf</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/'.$reg->archivo.'.XML'.'"> <button title="XML CPE" class="btn btn-info btn-xs">cpe</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/R-'.$reg->archivo.'.XML'.'"> <button title="XML CDR" class="btn btn-warning btn-xs">cdr</button></a>';
 			 		
 			 		$descarga_archivos='<a href="'.$url6.$reg->idventa.'"> <button title="PDF" class="btn btn-primary btn-xs">pdf</button></a>'.' <a target="_blank" href="https://siqay.com/public/sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/'.$reg->archivo.'.XML'.'"> <button title="XML CPE" class="btn btn-info btn-xs">cpe</button></a>'.' <a target="_blank" href="https://siqay.com/public/sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/R-'.$reg->archivo.'.XML'.'"> <button title="XML CDR" class="btn btn-warning btn-xs">cdr</button></a>';
 			 

 			 		# code...
 			 	}
 			 	else
 			 	{
 			 		$descarga_archivos="";

 			 	}

 				$data[]=array(
 			    
 				"10"=>$botones,
 				//"12"=>$descarga_archivos,
 				"0"=>$reg->idventa,
 				"2"=>date("d-m-Y H:i:s",strtotime($reg->fechahora)),
 				"3"=>$reg->cliente,
 				"4"=>$reg->dniruc,
 				"5"=>$documentito,
				"6"=>$reg->formapago,
 				"7"=>$reg->comprobante,
 				"8"=>$reg->comprobanteref,
 				"9"=>$reg->total,
 		    /*	"3"=>($reg->cod_sunat==='0000')?'<button title="Enviar a sunat" class="btn btn-xs btn-warning" onclick="enviar_sunat('.$reg->idventa.')"><i class="fa fa-check-o text-red"></i> Enviar a sunat</button>':'<a href="../161/pag_cliente/" target="_blank" class="btn btn-primary btn-xs">SUNAT</a>',*/
 		    	//"3"=>$valsunat,
 				//"2"=>($reg->estadoenvio=='0')?'<span class="label bg-green">Enviado</span>':
 				'<span class="label bg-red">Pendiente</span>',
 				"1"=>($reg->estado=='0')?'<span class="badge bg-green">Aceptado</span>':
 				'<span class="badge bg-red">Anulado</span>'
 				);
 		
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	

    case 'listar_ticket':
		$fecha_inicio_t=$_REQUEST["fecha_inicio_t"];
		$fecha_fin_t=$_REQUEST["fecha_fin_t"];
		$rspta=$venta->listar_ticket($fecha_inicio_t,$fecha_fin_t);


 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$url='../reportes/venta.php?id=';
 			$url2='../reportes/ticketVenta.php?id=';
 			$url3='../reportes/enviar.php?id=';
 			$url6='../reportes/pdf.php?id=';
 			$url4='notacredito.php?id=';
 			$url5='guia.php?id=';
 			/*if($reg->idtipocomprobante=='1'){
 				$anti="F00";
 			}else{
 				$anti="B00";
 			}*/
 			if($reg->idtipocomprobante==="3"){
 			        $documentito="<p style='color:steelblue;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="1") {
 			        $documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="7") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="8") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="5") {
 			    	$documentito="<p style='color:orange;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="11") {
					$documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
				}elseif($reg->idtipocomprobante==="12" || $reg->idtipocomprobante==="88") {
					$documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
				}
 			    /* inicio  codigo agregado 31-05-2018 */
 			    if($reg->idtipocomprobante==="7"){
 			        $botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver Venta A4" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.'&nbsp;'.
 					'<a target="_blank" href="'.$url2.$reg->idventa.'"> <button title="Ver ticket Venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-blue"></i></button></a>';
 			    }


 			    else {

 			    	if ($reg->estado==="1" && $reg->nc==="0") {
 			    		$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver detalle de venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.' <a href="'.$url4.$reg->idventa.'" title="Nota de Crédito y Débito" class="btn btn-xs"><i class="fa fa-share-square-o"></i></a>';
 			    		
 			    	}else

 			    	{
 			    		if ($reg->estado==="1" && $reg->nc==="1") {
 			    			$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver detalle de venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>';
 			    		}
 			    		else{
 			    	$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver Venta A4" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.'&nbsp;'.
 					'<a href="'.$url4.$reg->idventa.'" title="Nota de Crédito y Débito" class="btn btn-xs"><i class="fa fa-share-square-o"></i></a>'.'<a target="_blank" href="'.$url2.$reg->idventa.'"> <button title="Ver ticket Venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-blue"></i></button></a>';
 			    }

 			    }
			}
 			 	
 			 	 if(($reg->estadoenvio==='1' &&  $reg->hash_cpe==='' &&  $reg->respuesta==='') ||($reg->cod_sunat==='0000' || $reg->cod_sunat==='soap-env:Client.0109' || $reg->cod_sunat==='soap-env:Client.0200' || $reg->cod_sunat==='soap-env:Client.0201' || $reg->cod_sunat==='soap-env:Client.0202' || $reg->cod_sunat==='soap-env:Client.0203' || $reg->cod_sunat==='soap-env:Client.0204' || $reg->cod_sunat==='soap-env:Client.0250' || $reg->cod_sunat==='soap-env:Client.0251' || $reg->cod_sunat==='soap-env:Client.0252' || $reg->cod_sunat==='soap-env:Client.0253' || $reg->cod_sunat==="soap-env:Client.0110" || $reg->cod_sunat==="soap-env:Client.0111" || $reg->cod_sunat==="soap-env:Client.0112" || $reg->cod_sunat==="soap-env:Client.0113" || $reg->cod_sunat==="soap-env:Client.0130" || $reg->cod_sunat==="soap-env:Client.0131" || $reg->cod_sunat==="soap-env:Client.0132" || $reg->cod_sunat==="soap-env:Client.0133" || $reg->cod_sunat==="soap-env:Client.0134" || $reg->cod_sunat==="soap-env:Client.0135" || $reg->cod_sunat==="soap-env:Client.0136" || $reg->cod_sunat==="soap-env:Client.0137" || $reg->cod_sunat==="soap-env:Client.0138"))
 			 	{
 			 		$valsunat='<button title="Enviar a sunat" class="btn btn-xs btn-warning" onclick="enviar_sunat('.$reg->idventa.')"><i class="fa fa-check-o text-red"></i> Enviar a sunat</button>';
 			 	}
 			 		else{
 			 		$valsunat='<a href="../161/pag_cliente/" target="_blank" class="btn btn-primary btn-xs">SUNAT</a>';
 								 				
 			 	}
 			 	
 			 	/* inicio  codigo agregado 31-05-2018 
				'<a href="'.$url6.$reg->idventa.'"> <button title="PDF" class="btn btn-danger btn-xs">pdf</button></a>'
 			 	*/
 			 	$empresa_ruc=substr($reg->archivo,0,11);

 			 	if ($reg->estadoenvio==='0')
 			 	{

 			 		$descarga_archivos='<a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/pdf/'.$reg->archivo.'.PDF'.'"> <button title="PDF" class="btn btn-primary btn-xs">pdf</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/'.$reg->archivo.'.XML'.'"> <button title="XML CPE" class="btn btn-info btn-xs">cpe</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/R-'.$reg->archivo.'.XML'.'"> <button title="XML CDR" class="btn btn-warning btn-xs">cdr</button></a>';
 			 		# code...
 			 	}
 			 	else
 			 	{
 			 		$descarga_archivos="";

 			 	}

 				$data[]=array(
 			    
 			"9"=>$botones,
 				"10"=>$descarga_archivos,
 				"0"=>$reg->idventa,
 				"2"=>date("d-m-Y H:i:s",strtotime($reg->fechahora)),
 				"3"=>$reg->cliente,
 				"4"=>$reg->dniruc,
 				"5"=>$documentito,
 				"6"=>$reg->comprobante,
 				"7"=>$reg->comprobanteref,
 				"8"=>$reg->total,
 				"1"=>($reg->estado=='0')?'<span class="label bg-green">R</span>':
 				'<span class="label bg-red">A</span>'
 				);
 		
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;


case 'listar_otrasalidas':
		$fecha_inicio_t=$_REQUEST["fecha_inicio_t"];
		$fecha_fin_t=$_REQUEST["fecha_fin_t"];
		$rspta=$venta->listar_otrasalida($fecha_inicio_t,$fecha_fin_t);


 		//Vamos a declarar un array
 		$data= Array();
 		while ($reg=$rspta->fetch_object()){
 			$url='../reportes/venta.php?id=';
 			$url2='../reportes/ticketVenta.php?id=';
 			$url3='../reportes/enviar.php?id=';
 			$url6='../reportes/pdf.php?id=';
 			$url4='notacredito.php?id=';
 			$url5='guia.php?id=';
 			/*if($reg->idtipocomprobante=='1'){
 				$anti="F00";
 			}else{
 				$anti="B00";
 			}*/
 			if($reg->idtipocomprobante==="3"){
 			        $documentito="<p style='color:steelblue;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="1") {
 			        $documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="7") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="8") {
 			    	$documentito="<p style='color:green;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="5") {
 			    	$documentito="<p style='color:orange;'>".$reg->tipocomprobante."</p>";
 			    }elseif($reg->idtipocomprobante==="11") {
					$documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
				}elseif($reg->idtipocomprobante==="12" || $reg->idtipocomprobante==="88") {
					$documentito="<p style='color:red;'>".$reg->tipocomprobante."</p>";
				}
 			    /* inicio  codigo agregado 31-05-2018 */
 			    if($reg->idtipocomprobante==="7"){
 			        $botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver Venta A4" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.'&nbsp;'.
 					'<a target="_blank" href="'.$url2.$reg->idventa.'"> <button title="Ver ticket Venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-blue"></i></button></a>';
 			    }


 			    else {

 			    	if ($reg->estado==="1" && $reg->nc==="0") {
 			    		$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver detalle de venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.' <a href="'.$url4.$reg->idventa.'" title="Nota de Crédito y Débito" class="btn btn-xs"><i class="fa fa-share-square-o"></i></a>';
 			    		
 			    	}else

 			    	{
 			    		if ($reg->estado==="1" && $reg->nc==="1") {
 			    			$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver detalle de venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>';
 			    		}
 			    		else{
 			    	$botones='<a target="_blank" href="'.$url.$reg->idventa.'"> <button title="Ver Venta A4" class="btn btn-xs"><i class="fa fa-file-pdf-o text-red"></i></button></a>'.'&nbsp;'.
 					'<a href="'.$url4.$reg->idventa.'" title="Nota de Crédito y Débito" class="btn btn-xs"><i class="fa fa-share-square-o"></i></a>'.'<a target="_blank" href="'.$url2.$reg->idventa.'"> <button title="Ver ticket Venta" class="btn btn-xs"><i class="fa fa-file-pdf-o text-blue"></i></button></a>';
 			    }

 			    }
			}
 			 	
 			 	 if(($reg->estadoenvio==='1' &&  $reg->hash_cpe==='' &&  $reg->respuesta==='') ||($reg->cod_sunat==='0000' || $reg->cod_sunat==='soap-env:Client.0109' || $reg->cod_sunat==='soap-env:Client.0200' || $reg->cod_sunat==='soap-env:Client.0201' || $reg->cod_sunat==='soap-env:Client.0202' || $reg->cod_sunat==='soap-env:Client.0203' || $reg->cod_sunat==='soap-env:Client.0204' || $reg->cod_sunat==='soap-env:Client.0250' || $reg->cod_sunat==='soap-env:Client.0251' || $reg->cod_sunat==='soap-env:Client.0252' || $reg->cod_sunat==='soap-env:Client.0253' || $reg->cod_sunat==="soap-env:Client.0110" || $reg->cod_sunat==="soap-env:Client.0111" || $reg->cod_sunat==="soap-env:Client.0112" || $reg->cod_sunat==="soap-env:Client.0113" || $reg->cod_sunat==="soap-env:Client.0130" || $reg->cod_sunat==="soap-env:Client.0131" || $reg->cod_sunat==="soap-env:Client.0132" || $reg->cod_sunat==="soap-env:Client.0133" || $reg->cod_sunat==="soap-env:Client.0134" || $reg->cod_sunat==="soap-env:Client.0135" || $reg->cod_sunat==="soap-env:Client.0136" || $reg->cod_sunat==="soap-env:Client.0137" || $reg->cod_sunat==="soap-env:Client.0138"))
 			 	{
 			 		$valsunat='<button title="Enviar a sunat" class="btn btn-xs btn-warning" onclick="enviar_sunat('.$reg->idventa.')"><i class="fa fa-check-o text-red"></i> Enviar a sunat</button>';
 			 	}
 			 		else{
 			 		$valsunat='<a href="../161/pag_cliente/" target="_blank" class="btn btn-primary btn-xs">SUNAT</a>';
 								 				
 			 	}
 			 	
 			 	/* inicio  codigo agregado 31-05-2018 
				'<a href="'.$url6.$reg->idventa.'"> <button title="PDF" class="btn btn-danger btn-xs">pdf</button></a>'
 			 	*/
 			 	$empresa_ruc=substr($reg->archivo,0,11);

 			 	if ($reg->estadoenvio==='0')
 			 	{

 			 		$descarga_archivos='<a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/pdf/'.$reg->archivo.'.PDF'.'"> <button title="PDF" class="btn btn-primary btn-xs">pdf</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/'.$reg->archivo.'.XML'.'"> <button title="XML CPE" class="btn btn-info btn-xs">cpe</button></a>'.' <a target="_blank" href="../sis_facturacion/archivos_xml_sunat/cpe_xml/'.$ruta_tipo_proceso.'/'.$empresa_ruc.'/R-'.$reg->archivo.'.XML'.'"> <button title="XML CDR" class="btn btn-warning btn-xs">cdr</button></a>';
 			 		# code...
 			 	}
 			 	else
 			 	{
 			 		$descarga_archivos="";

 			 	}

 				$data[]=array(
 			    
 			"9"=>$botones,
 				"10"=>$descarga_archivos,
 				"0"=>$reg->idventa,
 				"2"=>date("d-m-Y H:i:s",strtotime($reg->fechahora)),
 				"3"=>$reg->cliente,
 				"4"=>$reg->dniruc,
 				"5"=>$documentito,
 				"6"=>$reg->comprobante,
 				"7"=>$reg->comprobanteref,
 				"8"=>$reg->total,
 				"1"=>($reg->estado=='0')?'<span class="label bg-green">R</span>':
 				'<span class="label bg-red">A</span>'
 				);
 		
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	
/*

	case 'selectProveedor':
		require_once "../modelos/Proveedor.php";
		$proveedor = new Proveedor();

	//	$rspta = $proveedor->listarP();

	//	while ($reg = $rspta->fetch_object())
			//	{
		//		echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
			//	}
	break;*/

	/*case 'listarProducto1':
		require_once "../modelos/Producto.php";
		$producto=new Producto();

		$rspta=$producto->listarActivos_con_stock();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"3"=>'<button class="btn btn-primary btn-xs" onclick="verificar('.$reg->idproducto.',\''.$reg->descripcion.'\',\''.$reg->stock.'\',\''.$reg->precioventa.'\',\''.$reg->preciocompra.'\')"><span class="fa fa-plus"></span></button>',
 				"1"=>number_format($reg->precioventa, 2, '.', ''),
 				"2"=>number_format($reg->stock, 0, '.', ''),
 				"0"=>$reg->descripcion
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;*/


case 'listar_detalle_venta_temp':
		
		$idindexx = $_REQUEST["idindex"];
		
		// $idusuario = 4; // remplasar al implemenra sesiones
		$rspta=$venta->listar_detalle_venta_temp($idusuario,$idindexx);
 		//Vamos a declarar un array
 		$data= Array();
 		$x=0;

 		while ($reg=$rspta->fetch_object()){
 			$x++;
 			$data[]=array(

 				"6"=>'<button type="button" class="btn btn-danger btn-xs" onclick="eliminar_item('.$reg->idproducto.',\''.$reg->idindex.'\')"><i class="fas fa-trash"></i></button">',
 				"0"=>$x,
 				"1"=>$reg->descripcion,
				"2"=>$reg->periodo,
 				"3"=>$reg->cantidad,
 				"4"=>$reg->precio,
 				// "6"=>$reg->descuento,				
 				"5"=>'S/. '.number_format(round(($reg->subtotal),2), 2, '.', '')
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

}
