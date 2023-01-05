<?php
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

class Periodos
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{
	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion)
	{
		$sql = "CALL sp_insertar_periodos('$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idperiodo, $descripcion)
	{
		$sql = "CALL sp_actualizar_periodos('$idperiodo','$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idperiodo)
	{
		$sql = "UPDATE periodos SET estado='0' WHERE idperiodo='$idperiodo'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idperiodo)
	{
		$sql = "UPDATE periodos SET estado='1' WHERE idperiodo='$idperiodo'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql = "SELECT * FROM periodos order by idperiodo asc";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idperiodo)
	{
		$sql = "SELECT * FROM periodos WHERE idperiodo='$idperiodo'";
		return ejecutarConsultaSimpleFila($sql);
	}


	public function select_combo_periodos()
	{
		$sql = "SELECT * FROM periodos WHERE estado='1'";
		return ejecutarConsulta($sql);
	}

	public function select_combo_periodo_precio_producto($idproducto)
	{
		$sql = "SELECT	pe.idperiodo,	pe.descripcion periodo,	pr.idproducto,	pr.preciocompra,	pr.precioventa FROM	precio AS pr
		INNER JOIN periodos AS pe ON pr.idperiodo = pe.idperiodo 
		INNER JOIN detalle_producto_divisionarias dt on pr.idproducto=dt.idproducto
		WHERE	dt.iddetalleproductodivisionaria = '$idproducto'
		ORDER BY	pe.idperiodo DESC";
		return ejecutarConsulta($sql);
	}

}
