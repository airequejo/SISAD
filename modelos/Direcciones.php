<?php

require "../config/Conexion.php";

Class Direcciones
{
    public function __construct()
    {
        
    }

    	/*Implementamos un método para insertar registros*/
	public function insertar($iddireccion,$idcliente,$ubigeo,$tipo,$direccion,$referencia)
	{
		$sql="CALL insertar_direcciones('$iddireccion','$idcliente','$ubigeo','$tipo','$direccion','$referencia');";
		return ejecutarConsulta($sql);
	}

  	/*Implementamos un método para editar registros*/
	public function editar($iddireccion,$idcliente,$ubigeo,$tipo,$direccion,$referencia)
	{
		$sql="CALL insertar_direcciones('$iddireccion','$idcliente','$ubigeo','$tipo','$direccion','$referencia');";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para desactivar categorías*/
	public function desactivar($iddireccion)
	{
		$sql="UPDATE direcciones SET estado ='1' WHERE iddireccion = '$iddireccion'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($iddireccion)
	{
		$sql="UPDATE direcciones SET estado ='0' WHERE iddireccion = '$iddireccion'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($iddireccion)
	{
		$sql="SELECT * FROM direcciones WHERE iddireccion='$iddireccion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	
	public function listar()
	{
		$sql="CALL listar_direcciones();";

		return ejecutarConsulta($sql);		
	}

	

	####################################################

	public function select_combo_ubigeo()
	{
		$sql="SELECT * FROM ubigeos";
		return ejecutarConsulta($sql);
	}
	
		public function select_combo_direccion_cliente($idcliente)
	{
		$sql="SELECT * FROM direcciones WHERE idcliente = '$idcliente'";
		return ejecutarConsulta($sql);
	}







}