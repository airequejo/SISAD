<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Compra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}




public function insertar_compra($idusuario,$idproveedor,$idformapago,$idconceptocp,$numerocp,$fechacp,$numerocheque,$tipocompra,$fecha,$tipocomprobante,$serie,$numero,$igv,$idindex,$descuento_general,$montoabonado,$fecha_vencimiento,$operacion)

	{

		$sql="CALL sp_procesar_compra('$idusuario','$idproveedor','$idformapago','$idconceptocp','$numerocp','$fechacp','$numerocheque','$tipocompra','$fecha','$tipocomprobante','$serie','$numero','$igv','$idindex','$descuento_general','$montoabonado','$fecha_vencimiento','$operacion');";
		return ejecutarConsulta($sql);
	}

public function insertar_compra_temp($idproducto,$idactividad,$idusuario,$idindex,$lote,$registrosanitario,$vencimiento,$cantidad,$precio,$precioventa,$descuento)

	{

		$sql="CALL sp_insertar_detalle_compra_temp('$idproducto','$idactividad','$idusuario','$idindex','$lote','$registrosanitario','$vencimiento','$cantidad','$precio','$precioventa','$descuento');";
		return ejecutarConsulta($sql);
	}


	
	//Implementamos un método para anular categorías
	public function anular($idcompra)
	{
		$sql="CALL sp_anular_compra('$idcompra');";
		return ejecutarConsulta($sql);
	}


	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcompra)
	{
		$sql="SELECT c.idcompra,DATE(c.fecha) as fecha,c.idproveedor,p.nombrerazon as proveedor,u.idusuario,u.nombre as usuario,c.tipocomprobante,c.serie,c.numero,c.igv,c.total,c.estado FROM compra c INNER JOIN proveedor p ON c.idproveedor=p.idproveedor INNER JOIN usuario u ON c.idusuario=u.idusuario WHERE c.idcompra='$idcompra'";
		return ejecutarConsultaSimpleFila($sql);
	}

	

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT c.idcompra,
					DATE(c.fecha) as fecha,
					c.idproveedor,
					p.nombrerazon as proveedor,
					c.igv as impuesto,
					u.idusuario,
					u.nombre as usuario,
					tc.descripcion,
					c.serie,
					c.numero,
					c.total,
					c.igv,
					c.descuento,
					c.descuento_general,
					c.estado 
					FROM compra c INNER JOIN proveedor p ON c.idproveedor=p.idproveedor 
					INNER JOIN usuario u ON c.idusuario=u.idusuario 
					CROSS JOIN tipocomprobante tc ON tc.idtipocomprobante=c.tipocomprobante 
					ORDER BY c.idcompra desc";
		return ejecutarConsulta($sql);		
	}


	public function listar_detalle_compra_temp($idusuario,$idindex)
	{
		$sql="CALL sp_listar_detalle_compra_temp('$idusuario','$idindex');";
		return ejecutarConsulta($sql);		
	}


	//Implementamos un método para anular categorías
	public function eliminar_detalle_temp($iddetallecompra)
	{
		$sql="DELETE FROM temp_detalle_compra WHERE iddetallecompra='$iddetallecompra'";
		return ejecutarConsulta($sql);
	}


	public function listar_compra_proceso_temp($idusuario)
	{
		$sql="CALL sp_listar_compra_proceso_temp('$idusuario');";

		return ejecutarConsulta($sql);		
	}

	public function calcular_totales_compra($idindex)
	{
		$sql="CALL sp_calcular_totales_compra('$idindex');";

		return ejecutarConsultaSimpleFila($sql);		
	}

	public function mostrar_compra_cabecera($idcompra)
	{
		$sql="SELECT
				compra.idcompra,
				compra.idproveedor,
				proveedor.dniruc,
				proveedor.nombrerazon,
				proveedor.direccion,
				proveedor.celular,
				proveedor.email,
				compra.idusuario,
				date(compra.fecha) as fecha,
				compra.tipocomprobante,
				compra.serie,
				compra.numero,
				compra.estado,
				usuario.nombre AS usuario,
				compra.total as total_compra,
				compra.descuento_general,
				compra.igv as impuesto,
				tipocomprobante.descripcion as tipocomprobante
				FROM
				compra
				INNER JOIN proveedor ON compra.idproveedor = proveedor.idproveedor
				INNER JOIN usuario ON usuario.idusuario = compra.idusuario
				INNER JOIN tipocomprobante ON tipocomprobante.idtipocomprobante = compra.tipocomprobante
				WHERE
				compra.idcompra = '$idcompra'";
			return ejecutarConsulta($sql);
	}

	public function listarDetalle($idcompra)
	{
		$sql="SELECT
		dc.idcompra,
		p.idproducto,
		p.descripcion,
		dc.cantidad,
		dc.precio,
		((dc.precio) * (dc.cantidad)) as subtotales,
		CONCAT(a.descripcion,' -- ( ' ,g.descripcion,'    /    ',s.descripcion,' )') as actividad
		FROM detallecompra dc
		left JOIN detalle_producto_divisionarias as dt ON dc.iddetalleproductodivisionaria = dt.iddetalleproductodivisionaria
		left JOIN productos p ON dt.idproducto = p.idproducto 
		left JOIN actividades AS a ON dc.idactividad=a.idactividad
		left JOIN subgastos as s ON a.idsubgasto=s.idsubgasto
		left JOIN gastos as g ON s.idgasto=g.idgasto
		WHERE dc.idcompra = '$idcompra'";
		return ejecutarConsulta($sql);
	}
	
}

?>