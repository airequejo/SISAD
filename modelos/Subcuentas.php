<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Subcuentas
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($codigosubcuenta,$descripcion,$idcuenta)
	{
		$sql="CALL sp_insertar_subcuentas('$codigosubcuenta','$descripcion','$idcuenta');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idsubcuenta,$codigosubcuenta,$descripcion,$idcuenta)
	{
		$sql="CALL sp_actualizar_subcuentas('$idsubcuenta','$codigosubcuenta','$descripcion','$idcuenta');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idsubcuenta)
	{
		$sql="UPDATE subcuentas SET estado='0' WHERE idsubcuenta='$idsubcuenta'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idsubcuenta)
	{
		$sql="UPDATE subcuentas SET estado='1' WHERE idsubcuenta='$idsubcuenta'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT s.*,CONCAT_WS('-',c.codigocuenta,c.descripcion) as cuenta FROM subcuentas as s
		INNER JOIN cuentas as c ON s.idcuenta=c.idcuenta order by s.idsubcuenta asc";
		return ejecutarConsulta($sql);		
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idsubcuenta)
	{
		$sql="SELECT * FROM subcuentas WHERE idsubcuenta='$idsubcuenta'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function select_combo_subcuentas()
	{
		$sql="SELECT s.*,CONCAT_WS('-',c.codigocuenta,c.descripcion) AS cuenta,CONCAT_WS('-',s.codigosubcuenta,s.descripcion) as subcuenta FROM subcuentas as s 
		INNER JOIN cuentas as c ON s.idcuenta=c.idcuenta
		WHERE s.estado='1'";
		return ejecutarConsulta($sql);		
	}

	

}

