<?php

require "../config/Conexion.php";

Class Ubigeo
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	public function select_combo_ubigeo()
	{

		$sql = "SELECT * FROM ubigeos";
		return ejecutarConsulta($sql);
	}




}