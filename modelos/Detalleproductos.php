<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Detalleproducto
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	
	/*Implementamos un método para editar registros*/
	public function editar($iddetalleproductodivisionaria,$idproducto,$iddivisionaria)
	{
		$sql="CALL sp_actualizar_detalle_producto_divisionarias('$iddetalleproductodivisionaria','$idproducto','$iddivisionaria');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($iddetalleproductodivisionaria)
	{
		$sql="UPDATE detalle_producto_divisionarias SET estado='0' WHERE iddetalleproductodivisionaria='$iddetalleproductodivisionaria'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($iddetalleproductodivisionaria)
	{
		$sql="UPDATE detalle_producto_divisionarias SET estado='1' WHERE iddetalleproductodivisionaria='$iddetalleproductodivisionaria'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT dt.*,p.descripcion as producto,p.idunidadmedida,
		CONCAT(cu.codigocuenta,'-',cu.descripcion) as cuenta,
		CONCAT(c.codigosubcuenta,'-',c.descripcion) as subcuenta,
		CONCAT(d.codigodivisionaria,'-',d.descripcion) as divisionaria
		FROM detalle_producto_divisionarias as dt
		INNER JOIN productos as p ON dt.idproducto=p.idproducto
		INNER JOIN divisionarias as d ON dt.iddivisionaria=d.iddivisionaria
		INNER JOIN subcuentas as c ON d.idsubcuenta=c.idsubcuenta
		INNER JOIN cuentas as cu ON c.idcuenta=cu.idcuenta ORDER BY dt.idproducto asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($iddetalleproductodivisionaria)
	{
		$sql="SELECT dt.iddetalleproductodivisionaria,dt.idproducto,dt.iddivisionaria,p.descripcion as producto,p.idunidadmedida,
		CONCAT(d.codigodivisionaria,'-',d.descripcion) as divisionaria
		FROM detalle_producto_divisionarias as dt
		INNER JOIN productos as p ON dt.idproducto=p.idproducto
		INNER JOIN divisionarias as d ON dt.iddivisionaria=d.iddivisionaria
		WHERE dt.iddetalleproductodivisionaria='$iddetalleproductodivisionaria'";
		return ejecutarConsultaSimpleFila($sql);
	}


}

