<?php
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Caja
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar_caja($idusuario,$turno,$fecha_apertura,$monto_inicial)
	{
		$sql="CALL sp_insertar_caja('$idusuario','$turno','$fecha_apertura','$monto_inicial');";
		return ejecutarConsulta($sql);
	}


	public function eliminar($idcaja)
	{
		$sql="DELETE FROM cajas WHERE idcaja='$idcaja'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idcaja)
	{
		$sql="CALL sp_calcular_monto_caja('$idcaja')";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function cerrar_caja($idcaja,$fecha_c)
	{
		$sql="CALL sp_cerrar_caja('$idcaja','$fecha_c')";
		return ejecutarConsulta($sql);
	}


	/*Implementar un método para listar los registros*/
	public function listar($idusuario)
	{
		$sql="CALL sp_listar_caja_por_usuario('$idusuario')";
		return ejecutarConsulta($sql);
	}
}


