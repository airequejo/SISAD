<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Precios
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($idproducto,$idperiodo,$preciocompra,$precioventa,$fecha)
	{
		$sql="CALL sp_insertar_precio('$idproducto','$idperiodo','$preciocompra','$precioventa','$fecha')";
		return ejecutarConsulta($sql);
	}

	public function editar($idprecio,$preciocompra,$precioventa,$fecha)
	{
		$sql="CALL sp_actualizar_precio('$idprecio','$preciocompra','$precioventa','$fecha')";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idprecio)
	{
		$sql="SELECT * FROM precio WHERE idprecio='$idprecio'";
		return ejecutarConsultaSimpleFila($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar($idproducto)
	{
		$sql="SELECT
        precio.idprecio,
		precio.idperiodo,
        precio.idproducto,
		periodos.descripcion as periodo,
        precio.preciocompra,
        precio.precioventa,
        precio.fecha,
		periodos.estado
        FROM
        precio
		INNER JOIN periodos on precio.idperiodo=periodos.idperiodo
        WHERE precio.idproducto='$idproducto'
        order by precio.fecha DESC";
		return ejecutarConsulta($sql);		
	}

	public function listar_historial($idproducto)
	{
		$sql="SELECT

		precio.idperiodo,
        precio.idproducto,
		periodos.descripcion as periodo,
        precio.preciocompra,
        precio.precioventa,
        precio.fecha,
		periodos.estado
        FROM
        precio_periodos precio
		INNER JOIN periodos on precio.idperiodo=periodos.idperiodo
        WHERE precio.idproducto='$idproducto'
        order by precio.fecha DESC";
		return ejecutarConsulta($sql);		
	}

	

	public function select()
	{
		$sql="SELECT * FROM precio";
		return ejecutarConsulta($sql);		
	}

	public function mostrar_precio_periodo($idproducto,$idperiodo)
	{
		$sql = "SELECT	pe.idperiodo, pr.idproducto,	pr.preciocompra,	pr.precioventa FROM	precio AS pr
		INNER JOIN periodos AS pe ON pr.idperiodo = pe.idperiodo 
		INNER JOIN detalle_producto_divisionarias dt on pr.idproducto=dt.idproducto
		WHERE	dt.iddetalleproductodivisionaria = '$idproducto'AND pr.idperiodo = '$idperiodo'
		ORDER BY	pe.idperiodo DESC";
		return ejecutarConsultaSimpleFila($sql);
	}

	
}

?>