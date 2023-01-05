<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Productos
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion,$idunidadmedida,$aplicamovimineto,$tipo)
	{
		$sql="CALL sp_insertar_productos('$descripcion','$idunidadmedida','$aplicamovimineto','$tipo');";
		return ejecutarConsulta($sql);
	}

	/* IMplemeta metodo insertar detalle producto divisionaria */

	public function insertar_detalle_producto($idproducto_detalle,$iddivisionaria)
	{
		$sql="CALL sp_insertar_detalle_producto_divisionarias('$idproducto_detalle','$iddivisionaria');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idproducto,$descripcion,$idunidadmedida,$aplicamovimineto,$tipo)
	{
		$sql="CALL sp_actualizar_productos('$idproducto','$descripcion','$idunidadmedida','$aplicamovimineto','$tipo');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idproducto)
	{
		$sql="UPDATE productos SET estado='0' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idproducto)
	{
		$sql="UPDATE productos SET estado='1' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT p.*,u.descripcion as unidadmedida ,pr.precioventa as preventa,pr.preciocompra as precompra
		FROM productos as p 
		LEFT JOIN precio pr on p.idproducto=pr.idproducto
		left JOIN unidadmedidas as u ON p.idunidadmedida = u.idunidadmedida";
		return ejecutarConsulta($sql);		
	}

	public function listar_productos_precios()
	{
		$sql="SELECT p.*,c.tipo as tipocuenta,u.descripcion as unidadmedida FROM productos as p 
		INNER JOIN unidadmedidas as u ON p.idunidadmedida = u.idunidadmedida
		INNER JOIN detalle_producto_divisionarias as dt ON p.idproducto=dt.idproducto
		INNER JOIN divisionarias as d on dt.iddivisionaria=d.iddivisionaria
		INNER JOIN subcuentas as s on d.idsubcuenta=s.idsubcuenta
		INNER JOIN cuentas as c on s.idcuenta=c.idcuenta
		WHERE (p.aplicamovimiento=1 OR p.tipo=1)  and c.tipo=1 AND p.estado=1";
		return ejecutarConsulta($sql);		
	}

	public function listar_detalle_producto($id)
	{
		$sql="SELECT dt.*,p.descripcion as producto,p.tipo,
		CONCAT(cu.codigocuenta,'-',cu.descripcion) as cuenta,
		CONCAT(c.codigosubcuenta,'-',c.descripcion) as subcuenta,
		CONCAT(d.codigodivisionaria,'-',d.descripcion) as divisionaria
		FROM detalle_producto_divisionarias as dt
		INNER JOIN productos as p ON dt.idproducto=p.idproducto
		INNER JOIN divisionarias as d ON dt.iddivisionaria=d.iddivisionaria
		INNER JOIN subcuentas as c ON d.idsubcuenta=c.idsubcuenta
		INNER JOIN cuentas as cu ON c.idcuenta=cu.idcuenta
		WHERE dt.idproducto = '$id'";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idproducto)
	{
		$sql="SELECT * FROM productos WHERE idproducto='$idproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_productos()
	{
		$sql="SELECT dt.iddetalleproductodivisionaria,dt.idproducto as codigobarra,p.*,d.descripcion as divisionaria FROM productos as p 
		INNER JOIN detalle_producto_divisionarias as dt ON p.idproducto=dt.idproducto
		INNER JOIN divisionarias as d ON dt.iddivisionaria = d.iddivisionaria
		INNER JOIN subcuentas as s ON d.idsubcuenta = s.idsubcuenta
		INNER JOIN cuentas as c ON c.idcuenta = s.idcuenta
		WHERE c.tipo = 1 AND p.estado = 1 AND dt.estado = 1
		GROUP BY dt.iddetalleproductodivisionaria";
		return ejecutarConsulta($sql);		
	}

	/* mostrar detalle producto para compra */

	public function mostrar_detalle_producto($idproducto)
	{
		$sql="CALL sp_mostrar_detalle_producto('$idproducto');";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function select_combo_unidadmedidas()
	{
		$sql="SELECT * FROM unidadmedidas WHERE estado='1'";
		return ejecutarConsulta($sql);		
	}

	public function listar_stock_lotes($fechaproceso)
	{
		$sql="CALL sp_listar_stock_lotes('$fechaproceso');";
		return ejecutarConsulta($sql);		
	}

	public function mostrar_stock_lotes($codigobarra)
	{
		$sql="CALL sp_mostrar_stock_lotes('$codigobarra');";
		return ejecutarConsultaSimpleFila($sql);		
	}

	public function listar_productos_compra()
	{
		$sql = "CALL sp_listar_productos_compra();";
		return ejecutarConsulta($sql);

	}


}

