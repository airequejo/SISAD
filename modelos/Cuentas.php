<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Cuentas
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($codigocuenta,$descripcion,$tipo)
	{
		$sql="CALL sp_insertar_cuentas('$codigocuenta','$descripcion','$tipo');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idcuenta,$codigocuenta,$descripcion,$tipo)
	{
		$sql="CALL sp_actualizar_cuentas('$idcuenta','$codigocuenta','$descripcion','$tipo');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idcuenta)
	{
		$sql="UPDATE cuentas SET estado='0' WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idcuenta)
	{
		$sql="UPDATE cuentas SET estado='1' WHERE idcuenta='$idcuenta'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT * FROM cuentas order by tipo asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idcuenta)
	{
		$sql="SELECT * FROM cuentas WHERE idcuenta='$idcuenta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_cuentas()
	{
		$sql="SELECT * FROM cuentas WHERE estado='1'";
		return ejecutarConsulta($sql);		
	}

}

