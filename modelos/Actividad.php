<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Actividad
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion,$idsubgasto,$fecha,$idperiodo)
	{
	$sql="CALL sp_insertar_actividades('$descripcion','$idsubgasto','$fecha','$idperiodo');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idactividad,$descripcion,$idsubgasto,$fecha,$idperiodo)
	{
		$sql="CALL sp_actualizar_actividades('$idactividad','$descripcion','$idsubgasto','$fecha','$idperiodo');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idactividad)
	{
		$sql="UPDATE actividades SET estado='0' WHERE idactividad='$idactividad'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idactividad)
	{
		$sql="UPDATE actividades SET estado='1' WHERE idactividad='$idactividad'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT d.*,s.descripcion as subgasto,c.descripcion as gasto FROM actividades as d
		INNER JOIN subgastos as s ON d.idsubgasto=s.idsubgasto
		INNER JOIN gastos AS c ON s.idgasto=c.idgasto
		order by d.idsubgasto asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idactividad)
	{
		$sql="SELECT * FROM actividades WHERE idactividad='$idactividad'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_actividad()
	{
		$sql="SELECT a.*,g.descripcion as gasto,s.descripcion as subgasto FROM actividades as a 
		INNER JOIN subgastos as s ON a.idsubgasto=s.idsubgasto
		INNER JOIN gastos as g ON s.idgasto=g.idgasto
		WHERE a.estado='1'";
		return ejecutarConsulta($sql);		
	}

}

