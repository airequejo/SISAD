<?php

require "../config/Conexion.php";

Class Ciclos
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	public function select_combo_ciclos()
	{

		$sql = "SELECT * FROM ciclos WHERE estado = 1";
		return ejecutarConsulta($sql);
	}




}