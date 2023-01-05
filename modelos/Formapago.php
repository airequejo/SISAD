<?php 
/*Incluímos inicialmente la conexión a la base de datos
*/require "../config/Conexion.php";

Class Formapago
{
/*	Implementamos nuestro constructor
*/	public function __construct()
	{

	}

/*	Implementar un método para listar los registros
*/	public function select_combo_formapago()
	{
		$sql="SELECT * FROM formapago WHERE estado = 1 and valor= 1";
		return ejecutarConsulta($sql);		
	}

	public function select_combo_formapago_credito()
	{
		$sql="SELECT * FROM formapago WHERE estado = 1 and valor= 0";
		return ejecutarConsulta($sql);		
	}

	public function select_combo_formapago_compra()
	{
		$sql="SELECT * FROM formapago WHERE estado = 2";
		return ejecutarConsulta($sql);		
	}

	
}