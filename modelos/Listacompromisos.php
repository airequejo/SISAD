<?php 
/*Incluímos inicialmente la conexión a la base de datos
*/require "../config/Conexion.php";

Class Listacompromiso
{
/*	Implementamos nuestro constructor
*/	public function __construct()
	{

	}

/*	Implementar un método para listar los registros
*/	public function listar()
	{
		$sql="CALL sp_listar_compromisospago();";
		return ejecutarConsulta($sql);		
	}

	
}

?>