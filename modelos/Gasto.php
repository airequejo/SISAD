<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Gastos
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion)
	{
		$sql="CALL sp_insertar_gastos('$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idgasto,$descripcion)
	{
		$sql="CALL sp_actualizar_gastos('$idgasto','$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idgasto)
	{
		$sql="UPDATE gastos SET estado='0' WHERE idgasto='$idgasto'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idgasto)
	{
		$sql="UPDATE gastos SET estado='1' WHERE idgasto='$idgasto'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT * FROM gastos order by idgasto asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idgasto)
	{
		$sql="SELECT * FROM gastos WHERE idgasto='$idgasto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_gastos()
	{
		$sql="SELECT * FROM gastos WHERE estado='1'";
		return ejecutarConsulta($sql);		
	}

}

