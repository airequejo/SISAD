<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Divisionaria
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($codigodivisionaria,$descripcion,$idsubcuenta)
	{
		$sql="CALL sp_insertar_divisionarias('$codigodivisionaria','$descripcion','$idsubcuenta');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($iddivisionaria,$codigodivisionaria,$descripcion,$idsubcuenta)
	{
		$sql="CALL sp_actualizar_divisionarias('$iddivisionaria','$codigodivisionaria','$descripcion','$idsubcuenta');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($iddivisionaria)
	{
		$sql="UPDATE divisionarias SET estado='0' WHERE iddivisionaria='$iddivisionaria'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($iddivisionaria)
	{
		$sql="UPDATE divisionarias SET estado='1' WHERE iddivisionaria='$iddivisionaria'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT d.*,CONCAT_WS('-',s.codigosubcuenta,s.descripcion) as subcuenta,CONCAT_WS('-',c.codigocuenta,c.descripcion) as cuenta FROM divisionarias as d
		INNER JOIN subcuentas as s ON d.idsubcuenta=s.idsubcuenta 
		INNER JOIN cuentas AS c ON s.idcuenta=c.idcuenta
		order by d.idsubcuenta asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($iddivisionaria)
	{
		$sql="SELECT * FROM divisionarias WHERE iddivisionaria='$iddivisionaria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_divisionarias()
	{
		$sql="SELECT * FROM divisionarias WHERE estado='1'";
		return ejecutarConsulta($sql);		
	}

}

