<?php 
date_default_timezone_set('America/Lima');
if (strlen(session_id()) < 1) 
  session_start();

require_once "../modelos/Compra.php";

$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
$idusuario= $_SESSION["idusuario"];
$idformapago=isset($_POST["idformapago"])? limpiarCadena($_POST["idformapago"]):"";
$tipocompra=isset($_POST["tipocompra"])? limpiarCadena($_POST["tipocompra"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$tipocomprobante=isset($_POST["tipocomprobante"])? limpiarCadena($_POST["tipocomprobante"]):"";
$serie=isset($_POST["serie"])? limpiarCadena($_POST["serie"]):"";
$numero=isset($_POST["numero"])? limpiarCadena($_POST["numero"]):"";
$igv=isset($_POST["igv"])? limpiarCadena($_POST["igv"]):"";
$total=isset($_POST["total"])? limpiarCadena($_POST["total"]):"";


## COMPRA DETALLE TEMP

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$lote=isset($_POST["lote"])? limpiarCadena($_POST["lote"]):"";
$registrosanitario=isset($_POST["registrosanitario"])? limpiarCadena($_POST["registrosanitario"]):"";
$vencimiento=isset($_POST["vencimiento"])? limpiarCadena($_POST["vencimiento"]):"";
$cantidad=isset($_POST["cantidad"])? limpiarCadena($_POST["cantidad"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$precioventa=isset($_POST["precioventa"])? limpiarCadena($_POST["precioventa"]):"";
$descuento=isset($_POST["descuento"])? limpiarCadena($_POST["descuento"]):"";

$idindex=isset($_POST["idindex"])? limpiarCadena($_POST["idindex"]):"";
$idindex_p=isset($_POST["idindex_p"])? limpiarCadena($_POST["idindex_p"]):"";
$descuento_general=isset($_POST["montodscto"])? limpiarCadena($_POST["montodscto"]):"";

$iddetallecompra=isset($_POST["iddetallecompra"])? limpiarCadena($_POST["iddetallecompra"]):"";

$montoabonado=isset($_POST["montoabonado"])? limpiarCadena($_POST["montoabonado"]):"";
$fecha_vencimiento=isset($_POST["fecha_vencimiento"])? limpiarCadena($_POST["fecha_vencimiento"]):"";
$operacion=isset($_POST["operacion"])? limpiarCadena($_POST["operacion"]):"";

$idactividad=isset($_POST["idactividad"])? limpiarCadena($_POST["idactividad"]):"";

$idconceptocp=isset($_POST["idconceptocp"])? limpiarCadena($_POST["idconceptocp"]):"";
$numerocp=isset($_POST["numerocp"])? limpiarCadena($_POST["numerocp"]):"";
$fechacp=isset($_POST["fechacp"])? limpiarCadena($_POST["fechacp"]):"";
$numerocheque=isset($_POST["numerocheque"])? limpiarCadena($_POST["numerocheque"]):"";
$documentoautoriza=isset($_POST["documentoautoriza"])? limpiarCadena($_POST["documentoautoriza"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";


switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcompra)){
			//$rspta=$compra->insertar($idproveedor,$idusuario,$idformapago,$tipocompra,$fecha,$tipocomprobante,$serie,$numero,$igv,$total,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio"],$_POST["lote"],$_POST["fechavencimiento"]);
			//echo $rspta ? "Compra registrada" : "No se pudo registrar todos los datos de la compra";
		}
		else {
		}
	break;

	case 'guardaryeditar_detalle_temp':
			$rspta=$compra->insertar_compra_temp($idproducto,$idactividad,$idusuario,$idindex,$lote,$registrosanitario,$vencimiento,$cantidad,$precio,$precioventa,$descuento);
			echo $rspta ? "Compra registrada" : "No se pudo registrar todos los datos de la compra";

	break;

	case 'insertar_compra':
				$rspta=$compra->insertar_compra($idusuario,$idproveedor,$idformapago,$idconceptocp,$numerocp,$fechacp,$numerocheque,$tipocompra,$fecha,$tipocomprobante,$serie,$numero,$igv,$idindex_p,$descuento_general,$montoabonado,$fecha_vencimiento,$operacion,$documentoautoriza,$observacion);
				$rows = mysqli_num_rows($rspta);
				$data = mysqli_fetch_assoc($rspta);
				echo json_encode($data,JSON_UNESCAPED_UNICODE);

		break;

	case 'anular':
		$rspta=$compra->anular($idcompra);
 		echo $rspta ? "compra anulado" : "compra no se puede anular";
	break;

	case 'eliminar_detalle_temp':
		$rspta=$compra->eliminar_detalle_temp($iddetallecompra);
 		echo $rspta ? "Item Anulado" : "Item no se puede anular";
	break;

	case 'mostrar':
		$rspta=$compra->mostrar($idcompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'calcular_totales_compra':
		$rspta=$compra->calcular_totales_compra($idindex);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case "select_combo_proveedor":
			require_once "../modelos/Proveedor.php";
			$proveedor = new Proveedor;
			$rspta = $proveedor->select_combo_proveedor();
			echo "<option value=''>SELECCIONE</option>";
			while ($reg = $rspta->fetch_object())
			{
				echo '<option value='.$reg->idproveedor.'>'.$reg->nombrerazon .'-'.$reg->dniruc .'-'.$reg->direccion.'</option>';
			}
		break;	
		
		case "select_combo_tipocomprobante":
			require_once "../modelos/Tipocomprobante.php";
			$tipocomprobante = new Tipocomprobante;
			$rspta = $tipocomprobante->select_combo_tipocomprobante_compra();
			echo "<option value=''>SELECCIONE</option>";
			while ($reg = $rspta->fetch_object())
			{
				echo '<option value='.$reg->idtipocomprobante.'>'.$reg->descripcion.'</option>';
			}
		break;	

		case "select_combo_formapago":
			require_once "../modelos/Formapago.php";
			$formapago = new Formapago;
			$rspta = $formapago->select_combo_formapago();
			//echo "<option value=''>SELECCIONE</option>";
			while ($reg = $rspta->fetch_object())
			{
				echo '<option value='.$reg->idformapago.'>'.$reg->descripcion .'</option>';
			}
		break;
		

	case 'listarDetalle':
		//Recibimos el idcompra
		$id=$_GET['id'];

		$rspta = $compra->listarDetalle($id);
		$tot=0;
		echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                   
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas"><td></td><td>'.$reg->descripcion.'</td><td>'.$reg->cantidad.'</td><td>'.$reg->precio.'</td><td>'.$reg->precio*$reg->cantidad.'</td></tr>';
					$tot=$tot+($reg->precio*$reg->cantidad);
				}
		echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                   
                                    <th></th>
                                    <th><h4 id="total">S/.'.$tot.'</h4><input type="hidden" name="total" id="total"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$compra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

 			$url='../reportes/compra.php?id=';

 			$desc = round($reg->descuento,2) + round($reg->descuento_general,2);
			$imp = $reg->total * (1 +($reg->igv / 100));

 			$tt= round(($imp - $desc),2);

 			$data[]=array(
 				"8"=>($reg->estado=='0')?'<a type="button" class="btn btn-xs btn-info" target="_blank" href="'.$url.$reg->idcompra.'"> <i class="fas fa-pencil-alt"></i></a>'.'&nbsp;'.
 					'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idcompra.')" title="Anular Documento"><i class="fas fa-trash"></i> </button>':
 					'<a type="button" class="btn btn-xs btn-info" target="_blank" href="'.$url.$reg->idcompra.'"> <i class="fas fa-pencil-alt"></i></a>',
 				"0"=>$reg->idcompra,
 				"2"=>date("d-m-Y",strtotime($reg->fecha)),
 				"3"=>$reg->proveedor,
 				"4"=>$reg->usuario,
 				"5"=>$reg->descripcion,
 				"6"=>$reg->serie.'-'.$reg->numero,
 				"7"=>round($tt,2),
 				"8"=>$reg->numerocp,
 				"9"=>$reg->numerocheque,
 				"1"=>($reg->estado=='0')?'<span class="badge badge-info">Activo</span>':'<span class="badge badge-danger">Anulado</span>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'selectProveedor':
		require_once "../modelos/Proveedor.php";
		$proveedor = new Proveedor();

		//$rspta = $proveedor->listarP();

		//while ($reg = $rspta->fetch_object())
			//	{
			//	echo '<option value=' . $reg->idpersona . '>' . $reg->nombre . '</option>';
			//	}
	break;

	case "listar_compra_proceso_temp":		
			$rspta = $compra->listar_compra_proceso_temp($idusuario);
			echo "<option value='0'> Lista de compras sin procesar </option>";
			while ($reg = $rspta->fetch_object())
			{
				echo '<option value='.$reg->idindex.'>'.$reg->fecha.'</option>';
			}
		break;

	

	/*case 'listarProducto':
		require_once "../modelos/Producto.php";
		$producto=new Producto();

		$rspta=$producto->listarActivos();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"3"=>'<button class="btn btn-success btn-xs" onclick="verificar('.$reg->idproducto.',\''.$reg->descripcion.'\','.$reg->fechavencimiento.')"><span class="fa fa-plus"></span></button>',
 				"0"=>$reg->codigobarra,
 				"2"=>number_format($reg->stock, 0, '.', ''),
 				"1"=>$reg->descripcion
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;*/



case 'listar_detalle_compra_temp':
		
		$idindex = $_REQUEST["idindex"];
		
		$rspta=$compra->listar_detalle_compra_temp($idusuario,$idindex);
 		//Vamos a declarar un array
 		$data= Array();
 		$x=0;

 		while ($reg=$rspta->fetch_object()){
 			$x++;
 			$data[]=array(

				"10"=>'<button type="button" class="btn btn-danger btn-xs" onclick="eliminar_detalle_temp('.$reg->iddetallecompra.')"><i class="fas fa-trash"></i></button">',
				"0"=>$x,
				"1"=>$reg->idproducto,
				"2"=>$reg->descripcion,
				"3"=>$reg->actividad,
				"4"=>$reg->lote,
				"5"=>$reg->vencimiento==null?'':date("d-m-Y",strtotime($reg->vencimiento)),
				"6"=>$reg->cantidad,
				"7"=>$reg->precio,
				"8"=>$reg->precioventa,			
				"9"=>'S/. '.number_format(round((($reg->cantidad*$reg->precio)-$reg->descuento),2), 2, '.', '')
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


