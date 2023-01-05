<?php
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Cliente
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	
/*Implementamos un método para insertar registros*/
	public function insertar($idcliente,$nombre,$tipodocumento,$dniruc,$direccion,$referencia,$celular,$email,$ubigeo)
	{
		$sql="CALL sp_insertar_cliente('$idcliente','$nombre','$tipodocumento','$dniruc','$direccion','$referencia','$celular','$email','$ubigeo')";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idcliente,$nombre,$tipodocumento,$dniruc,$celular,$email)
	{
		$sql="CALL sp_actualizar_cliente('$idcliente','$nombre','$tipodocumento','$dniruc','$celular','$email')";
		return ejecutarConsulta($sql);
	}


	/*Implementamos un método para desactivar categorías*/
	public function desactivar($idcliente)
	{
		$sql="UPDATE clientes SET estado='0' WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para activar categorías*/
	public function activar($idcliente)
	{
		$sql="UPDATE clientes SET estado='1' WHERE idcliente='$idcliente'";
		return ejecutarConsulta($sql);
	}

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idcliente)
	{
		$sql="SELECT * FROM clientes WHERE idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}
	/*Implementar un método para buscar los datos de un cliente*/
	public function buscar($idcliente)
	{
		$sql="SELECT * FROM clientes WHERE dniruc='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}
	/*Implementar un método para listar los registros*/
    public function listar()
	{
		$sql="SELECT
					clientes.idcliente,
					clientes.nombre,
					clientes.dniruc,
					direcciones.nombredireccion as direccion,
					clientes.celular,
					clientes.estado
					FROM
					clientes left JOIN direcciones ON clientes.idcliente=direcciones.idcliente
					where direcciones.tipo='0'";
		return ejecutarConsulta($sql);
	}

	public function select_combo_cliente()
	{
		$sql="SELECT * FROM clientes WHERE estado='1'";
		return ejecutarConsulta($sql);
	}


	public function mostrar_cliente($idcliente)
	{
		$sql="SELECT * FROM clientes WHERE idcliente='$idcliente'";
		return ejecutarConsultaSimpleFila($sql);
	}
	
	public function llenar_cliente__()
		{
			$sql = "SELECT * FROM clientes
			WHERE nombre LIKE '%".$_GET['q']."%' OR dniruc LIKE '%".$_GET['q']."%'
			"; 
			return ejecutarConsulta($sql);
		}

}

?>
