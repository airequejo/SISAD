<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Subgastos
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($descripcion,$idgasto)
	{
		$sql="CALL sp_insertar_subgastos('$descripcion','$idgasto');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idsubgasto,$descripcion,$idgasto)
	{
		$sql="CALL sp_actualizar_subgastos('$idsubgasto','$descripcion','$idgasto');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idsubgasto)
	{
		$sql="UPDATE subgastos SET estado='0' WHERE idsubgasto='$idsubgasto'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idsubgasto)
	{
		$sql="UPDATE subgastos SET estado='1' WHERE idsubgasto='$idsubgasto'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT s.*,c.descripcion as gasto FROM subgastos as s
		INNER JOIN gastos as c ON s.idgasto=c.idgasto order by s.idsubgasto asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idsubgasto)
	{
		$sql="SELECT * FROM subgastos WHERE idsubgasto='$idsubgasto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_subgastos()
	{
		$sql="SELECT s.*,c.descripcion AS gasto,s.descripcion as subgasto FROM subgastos as s 
		INNER JOIN gastos as c ON s.idgasto=c.idgasto
		WHERE s.estado='1'";
		return ejecutarConsulta($sql);		
	}

	

}

