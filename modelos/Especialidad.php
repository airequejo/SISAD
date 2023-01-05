<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Especialidad
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion)
	{
		$sql="CALL sp_insertar_especialidad('$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idespecialidad,$descripcion)
	{
		$sql="CALL sp_actualizar_especialidad('$idespecialidad','$descripcion');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idespecialidad)
	{
		$sql="UPDATE especialidades SET estado='0' WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idespecialidad)
	{
		$sql="UPDATE especialidades SET estado='1' WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT * FROM especialidades order by idespecialidad asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idespecialidad)
	{
		$sql="SELECT * FROM especialidades WHERE idespecialidad='$idespecialidad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_especialidad()
	{
		$sql="SELECT * FROM especialidades WHERE estado='1'";
		return ejecutarConsulta($sql);		
	}

}

