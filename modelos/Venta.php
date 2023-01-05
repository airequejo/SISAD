<?php
//session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";   

Class Venta
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	//Implementamos un método para insertar registros
	public function insertar($idcliente,$idusuario,$idformapago,$tipoventa,$fecha,$idtipocomprobante,$idserienumero,$serie,$igv,$total,$idnotapedido,$idproducto,$cantidad,$precio,$dniru,$nombres,$procedencia,$tipodoc,$direc)
	{

		$num=ejecutarConsulta("SELECT
				serienumero.idserienumero,
				serienumero.serie,
				serienumero.numero,
				serienumero.estado,
				serienumero.concepto,
				serienumero.idtipocomprobante,
				tipocomprobante.tipo,
				CONCAT(tipocomprobante.tipo,(SUBSTRING((CONCAT('000',serienumero.serie)),-3)),'-',(SUBSTRING((CONCAT('00000000',serienumero.numero)),-8))) as comprobante
				FROM
				serienumero
				INNER JOIN tipocomprobante ON serienumero.idtipocomprobante = tipocomprobante.idtipocomprobante
				WHERE
				serienumero.idserienumero = '$idserienumero'");
				$reg = $num->fetch_object();
				$nuevonum=$reg->numero;
				$nuevocom=$reg->comprobante;

				$sql="INSERT INTO venta (idcliente,idusuario,idformapago,tipoventa,fecha,idtipocomprobante,idserienumero,numero,comprobante,igv,total,idnotapedido,estado)
				VALUES ('$idcliente','$idusuario','$idformapago','$tipoventa','$fecha','$idtipocomprobante','$idserienumero','$nuevonum','$nuevocom','$igv','$total','$idnotapedido','0')";
				//return ejecutarConsulta($sql);
				$idingresonew=ejecutarConsulta_retornarID($sql);

				$num_elementos=0;
				$sw=true;
				$x=0;

				$detalle=array();
				$campos=array();


				while ($num_elementos < count($idproducto))
				{

					$sql_detalle = "INSERT INTO detalleventa(idventa,idproducto,cantidad,precio) VALUES ('$idingresonew','$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio[$num_elementos]')";

						  		$x=$x+1;

						  		$nump=ejecutarConsulta("SELECT descripcion FROM producto WHERE idproducto = '$idproducto[$num_elementos]'");
								$regp = $nump->fetch_object();
								$produc=$regp->descripcion;

		                $campos['txtITEM']=$x;
		                $campos['txtUNIDAD_MEDIDA_DET']='NIU';
		                $campos['txtCANTIDAD_DET']=$cantidad[$num_elementos];
		                $campos['txtPRECIO_DET']=$precio[$num_elementos];
		                $campos['txtIMPORTE_DET']=round($precio[$num_elementos]*$cantidad[$num_elementos],2);
		                $campos['txtPRECIO_TIPO_CODIGO']='01';
		                $campos['txtIGV']='0'; //Traer de la venta en caso se aplique
		                $campos['txtISC']='0';
		                $campos['txtCOD_TIPO_OPERACION']='20'; 
		                $campos['txtCODIGO_DET']=$idproducto[$num_elementos];
		                $campos['txtDESCRIPCION_DET']=$produc; //MOdificar por valores de la caja de texto


		               $select_producto=ejecutarConsulta("SELECT * FROM producto WHERE idproducto = '$idproducto[$num_elementos]'");
						$val_producto = $select_producto->fetch_object();
						$stoc_producto=$val_producto->stock;
						$saldo_actual=$stoc_producto-$cantidad[$num_elementos];

		              $sql_kardex = "INSERT INTO kardex(idproducto,fecha,comprobante,operacion,ingreso,salida,saldo) VALUES 
		              							('$idproducto[$num_elementos]','$fecha','$nuevocom','SALIDA','0','$cantidad[$num_elementos]','$saldo_actual')";
		              							ejecutarConsulta($sql_kardex);

		            
		              	$sql_producto="UPDATE producto SET stock='$saldo_actual' WHERE idproducto='$idproducto[$num_elementos]'";
		              	ejecutarConsulta($sql_producto);


					 	ejecutarConsulta($sql_detalle) or $sw = false;
						$num_elementos=$num_elementos + 1;


		           $detalle[]=$campos;

			}

	return $sw;

	}
	

	public function insertar_venta($idusuario,$iddireccion,$idformapago,$tipoventa,$fecha,$idtipocomprobante,$igv,$descuento_general,$idindex_venta,$montoabonado,$fecha_vencimiento,$operacion,$fechaoperacion,$idespecialidad,$idciclo)

	{
		$sql="CALL sp_procesar_venta('$idusuario','$iddireccion','$idformapago','$tipoventa','$fecha','$idtipocomprobante','$igv','$descuento_general','$idindex_venta','$montoabonado','$fecha_vencimiento','$operacion','$fechaoperacion','$idespecialidad','$idciclo');";

		return ejecutarConsulta($sql);
	}

	public function insertar_venta_temp($idproducto,$idusuario,$idindex,$idperiodo,$cantidad,$precio,$descuento,$precio_compra_promedio,$fechaproceso)

	{
		$sql="CALL sp_insertar_detalle_venta_temps('$idproducto','$idusuario','$idindex','$idperiodo','$cantidad','$precio','$descuento','$precio_compra_promedio','$fechaproceso');";

		return ejecutarConsulta($sql);
	}


	public function listar_detalle_venta_temp($idusuario,$idindex)
	{
		$sql="CALL sp_listar_detalle_venta_temp('$idusuario','$idindex');";
		return ejecutarConsulta($sql);		
	}


	public function listar_venta_proceso_temp($idusuario)
	{
		$sql="CALL sp_listar_venta_proceso_temp('$idusuario');";

		return ejecutarConsulta($sql);		
	}

	public function calcular_totales_venta($idindex)
	{
		$sql="CALL sp_calcular_totales_venta('$idindex');";

		return ejecutarConsultaSimpleFila($sql);		
	}

	//Implementamos un método para anular categorías
	public function anular($idventa)
	{
		$sql="UPDATE venta SET estado='1' WHERE idventa='$idventa'";
		return ejecutarConsulta($sql);
	}
//Implementamos un método para anular categorías
	public function eliminar_items_detalle($idproducto,$idindex)
	{
		$sql="CALL sp_eliminar_items('$idproducto','$idindex');";
		return ejecutarConsulta($sql);
	}

	public function eliminar_detalle_venta($idindex)
	{
		$sql="CALL eliminar_items_venta_temp('$idindex');";
		return ejecutarConsulta($sql);
	}



	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idventa)
	{
		$sql="SELECT c.idventa,DATE(c.fecha) as fecha,c.idcliente,p.nombre as cliente,u.idusuario,u.nombre as usuario,c.idtipocomprobante,c.idserienumero,c.numero,c.igv,c.total,c.estado FROM venta c INNER JOIN cliente p ON c.idcliente=p.idcliente INNER JOIN usuario u ON c.idusuario=u.idusuario WHERE c.idventa='$idventa'";
		return ejecutarConsultaSimpleFila($sql);
	}
public function obtener_ultimo()
	{
		$sql="SELECT max(idventa) as ultimo_documento FROM venta";
		return ejecutarConsultaSimpleFila($sql);
	}



	//Implementar un método para listar los registros
public function listar($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT
				v.fecha,
				v.idventa,
				c.nombre AS cliente,
				IF(c.dniruc='00000000','-',c.dniruc) AS dniruc,
				usuario.nombre AS usuario,
				tipocomprobante.idtipocomprobante,
				tipocomprobante.descripcion AS tipocomprobante,
				serienumero.serie,
				v.numero,
				v.comprobante,
				v.total as total,					
				v.estado,
				v.operacion,
				v.comprobanteref,
				v.nc,
				fp.descripcion as formapago,
				fp.iniciales,
				enviosunat.estadoenvio,
				enviosunat.fecha AS fechahora,
				enviosunat.hash_cpe,
				enviosunat.hash_cdr,
				enviosunat.msj_sunat,
				enviosunat.archivo,
				IF(enviosunat.cod_sunat='',enviosunat.respuesta,enviosunat.cod_sunat) AS cod_sunat,
				enviosunat.respuesta
				FROM
				venta as v
				LEFT JOIN direcciones as d ON v.iddireccioncliente = d.iddireccion
				LEFT JOIN clientes as c ON d.idcliente=c.idcliente
				LEFT JOIN usuario ON v.idusuario = usuario.idusuario
				LEFT JOIN tipocomprobante ON v.idtipocomprobante = tipocomprobante.idtipocomprobante
				LEFT JOIN serienumero ON serienumero.idtipocomprobante = tipocomprobante.idtipocomprobante AND v.idserienumero = serienumero.idserienumero
				LEFT JOIN enviosunat ON v.idventa = enviosunat.idventa
				LEFT JOIN formapago as fp ON v.idformapago = fp.idformapago
				WHERE DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' AND v.idserienumero NOT IN (11,12,13,14,15,16,17,18,19,20)
				ORDER BY	v.idventa DESC";
		return ejecutarConsulta($sql);
	}


public function listar_ticket($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT
					venta.fecha,
					venta.idventa,
					cliente.nombre AS cliente,
					IF(cliente.dniruc='00000000','-',cliente.dniruc) AS dniruc,
					usuario.nombre AS usuario,
					tipocomprobante.idtipocomprobante,
					tipocomprobante.descripcion AS tipocomprobante,
					serienumero.serie,
					venta.numero,
					venta.comprobante,
					venta.total as total,
					
					venta.estado,
					venta.comprobanteref,
					venta.nc,
					enviosunat.estadoenvio,
					enviosunat.fecha AS fechahora,
					enviosunat.hash_cpe,
					enviosunat.hash_cdr,
					enviosunat.msj_sunat,
					enviosunat.archivo,
					IF(enviosunat.cod_sunat='',enviosunat.respuesta,enviosunat.cod_sunat) AS cod_sunat,
					enviosunat.respuesta
					FROM
					venta
					LEFT JOIN cliente ON venta.idcliente = cliente.idcliente
					LEFT JOIN usuario ON venta.idusuario = usuario.idusuario AND ''= ''
					LEFT JOIN tipocomprobante ON venta.idtipocomprobante = tipocomprobante.idtipocomprobante
					LEFT JOIN serienumero ON serienumero.idtipocomprobante = tipocomprobante.idtipocomprobante AND venta.idserienumero = serienumero.idserienumero
					LEFT JOIN enviosunat ON venta.idventa = enviosunat.idventa
					WHERE DATE(venta.fecha)>='$fecha_inicio' AND DATE(venta.fecha)<='$fecha_fin' AND venta.idserienumero IN (11,12)
					ORDER BY
					venta.idventa DESC
                    ";
		return ejecutarConsulta($sql);
	}
	
	public function listar_otrasalida($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT
					venta.fecha,
					venta.idventa,
					cliente.nombre AS cliente,
					IF(cliente.dniruc='00000000','-',cliente.dniruc) AS dniruc,
					usuario.nombre AS usuario,
					tipocomprobante.idtipocomprobante,
					tipocomprobante.descripcion AS tipocomprobante,
					serienumero.serie,
					venta.numero,
					venta.comprobante,
					venta.total as total,
					
					venta.estado,
					venta.comprobanteref,
					venta.nc,
					enviosunat.estadoenvio,
					enviosunat.fecha AS fechahora,
					enviosunat.hash_cpe,
					enviosunat.hash_cdr,
					enviosunat.msj_sunat,
					enviosunat.archivo,
					IF(enviosunat.cod_sunat='',enviosunat.respuesta,enviosunat.cod_sunat) AS cod_sunat,
					enviosunat.respuesta
					FROM
					venta
					LEFT JOIN cliente ON venta.idcliente = cliente.idcliente
					LEFT JOIN usuario ON venta.idusuario = usuario.idusuario AND ''= ''
					LEFT JOIN tipocomprobante ON venta.idtipocomprobante = tipocomprobante.idtipocomprobante
					LEFT JOIN serienumero ON serienumero.idtipocomprobante = tipocomprobante.idtipocomprobante AND venta.idserienumero = serienumero.idserienumero
					LEFT JOIN enviosunat ON venta.idventa = enviosunat.idventa
					WHERE DATE(venta.fecha)>='$fecha_inicio' AND DATE(venta.fecha)<='$fecha_fin' AND venta.idserienumero IN (13,14,15,16,17,18,19,20)
					ORDER BY
					venta.idventa DESC
                    ";
		return ejecutarConsulta($sql);
	}


	public function mostrar_venta_cabecera($idventa)
	{
		$sql="SELECT
		v.idventa,
		e.descripcion as especialidad,
		ci.descripcion as ciclo,
		v.tipoventa,
		d.idcliente,
		c.dniruc,
		c.nombre,
		d.nombredireccion AS direcc,
		d.nombredireccion as direc,
		c.celular,
		credito.monto_credito,
		c.email,
		v.idusuario,
		date(v.fecha) AS fecha,
		(v.fecha) AS fecha_hora,
		v.idtipocomprobante,
		v.idserienumero,
		v.numero,
		v.estado,
		usuario.nombre AS usuario,
		v.total AS total_venta,
		v.igv AS impuesto,
		tipocomprobante.descripcion AS tipocomprobante,
		v.comprobante,
		c.tipodocumento,
		d.localidad AS procedenciaa,
		d.localidad AS procedencia,
		serienumero.serie,
		serienumero.idtipocomprobante AS idtipocomprobantemodifica,
		serienumero.valor,
		IF(serienumero.valor='B','BOLETA ELECTRÓNICA','FACTURA ELECTRÓNICA') AS nombrecomprobante,
		v.idmotivo,
		v.serieidmodif,
		v.comprobanteref,
		v.descripcionmotivo,
		CONCAT(serienumero.valor,(SUBSTRING((CONCAT('000',serienumero.serie)),-3))) AS serie_generada,
		SUBSTRING((CONCAT('00000000',v.numero)),-8) AS numero_generado,
		enviosunat.hash_cpe,
		enviosunat.hash_cdr,
		enviosunat.archivo,
		credito.fecha_vencimiento
		FROM
		venta as v
		LEFT JOIN direcciones as d ON v.iddireccioncliente = d.iddireccion
		LEFT JOIN clientes as c ON d.idcliente=c.idcliente
		INNER JOIN usuario ON usuario.idusuario = v.idusuario
		INNER JOIN tipocomprobante ON tipocomprobante.idtipocomprobante = v.idtipocomprobante
		INNER JOIN serienumero ON serienumero.idserienumero = v.idserienumero
		LEFT JOIN enviosunat ON v.idventa = enviosunat.idventa	
		LEFT JOIN credito ON v.idventa = credito.idventa 
		LEFT JOIN especialidades as e ON v.idespecialidad = e.idespecialidad
		LEFT JOIN ciclos as ci ON v.idciclo = ci.idciclo			
		WHERE v.idventa= '$idventa'";
		return ejecutarConsulta($sql);
	}
	

	public function listarDetalle($idventa)
	{
		$sql="SELECT
		dc.idventa,
		p.idproducto,
		IF(venta.servicio='0',CONCAT(p.descripcion,'-',uni.descripcion),dc.servicio) as descripcion,
		sum(dc.cantidad) as cantidad,
		dc.precio,
		((dc.precio) * sum(dc.cantidad)) AS subtotales,
		venta.servicio
		FROM
		detalleventa AS dc
		INNER JOIN detalle_producto_divisionarias as dt ON dc.iddetalleproductodivisionaria = dt.iddetalleproductodivisionaria
		INNER JOIN productos AS p ON dt.idproducto = p.idproducto
		INNER JOIN venta ON dc.idventa = venta.idventa AND dc.idventa = venta.idventa
		INNER JOIN unidadmedidas as uni ON p.idunidadmedida = uni.idunidadmedida 
		WHERE dc.idventa = '$idventa' GROUP BY p.idproducto";
		return ejecutarConsulta($sql);
	}

	public function listar1($fecha_inicio, $fecha_fin)
	{
		$sql = "SELECT
		v.fecha,
		v.idventa,
		c.nombre AS cliente,
		IF(c.dniruc='00000000','-',c.dniruc) AS dniruc,
		usuario.nombre AS usuario,
		tipocomprobante.idtipocomprobante,
		tipocomprobante.descripcion AS tipocomprobante,
		serienumero.serie,
		v.numero,
		v.comprobante,
		v.total as total,					
		v.estado,
		v.comprobanteref,
		v.nc,
		fp.descripcion as formapago,
		enviosunat.estadoenvio,
		enviosunat.fecha AS fechahora,
		enviosunat.hash_cpe,
		enviosunat.hash_cdr,
		enviosunat.msj_sunat,
		enviosunat.archivo,
		IF(enviosunat.cod_sunat='',enviosunat.respuesta,enviosunat.cod_sunat) AS cod_sunat,
		enviosunat.respuesta
		FROM
		venta as v
		LEFT JOIN direcciones as d ON v.iddireccioncliente = d.iddireccion
		LEFT JOIN clientes as c ON d.idcliente=c.idcliente
		LEFT JOIN usuario ON v.idusuario = usuario.idusuario
		LEFT JOIN tipocomprobante ON v.idtipocomprobante = tipocomprobante.idtipocomprobante
		LEFT JOIN serienumero ON serienumero.idtipocomprobante = tipocomprobante.idtipocomprobante AND v.idserienumero = serienumero.idserienumero
		LEFT JOIN enviosunat ON v.idventa = enviosunat.idventa
		LEFT JOIN formapago as fp ON v.idformapago = fp.idformapago
		WHERE DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' AND v.idserienumero NOT IN (11,12,13,14,15,16,17,18,19,20)
		ORDER BY	v.idventa DESC";
		return ejecutarConsulta($sql);
	}

}

?>
