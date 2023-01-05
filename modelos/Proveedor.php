<?php 
/*Incluímos inicialmente la conexión a la base de datos*/
require "../config/Conexion.php";

Class Proveedor
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	/*Implementamos un método para insertar registros*/
	public function insertar($dniruc,$nombrerazon,$direccion,$telefono,$celular,$email,$paginaweb)
	{
		$sql="INSERT INTO proveedor (dniruc,nombrerazon,direccion,telefono,celular,email,paginaweb)
		VALUES ('$dniruc','$nombrerazon','$direccion','$telefono','$celular','$email','$paginaweb')";
		return ejecutarConsulta($sql);
	}

	/*Implementamos un método para editar registros*/
	public function editar($idproveedor,$dniruc,$nombrerazon,$direccion,$telefono,$celular,$email,$paginaweb)
	{
		$sql="UPDATE proveedor SET dniruc='$dniruc',nombrerazon='$nombrerazon',direccion='$direccion',telefono='$telefono', celular='$celular',email='$email',paginaweb='$paginaweb' WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}

	public function desactivar($idproveedor)
	{
		$sql="UPDATE proveedor SET estado =  0 WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}


	public function activar($idproveedor)
	{
		$sql="UPDATE proveedor SET estado =  1 WHERE idproveedor='$idproveedor'";
		return ejecutarConsulta($sql);
	}
		

	/*Implementar un método para mostrar los datos de un registro a modificar*/
	public function mostrar($idproveedor)
	{
		$sql="SELECT * FROM proveedor WHERE idproveedor='$idproveedor'";
		return ejecutarConsultaSimpleFila($sql);
	}

	/*Implementar un método para listar los registros*/
	public function listar()
	{
		$sql="SELECT
					proveedor.idproveedor,
					proveedor.dniruc,
					proveedor.nombrerazon,
					proveedor.direccion,
					proveedor.celular,
					proveedor.estado
					FROM
					proveedor";
		return ejecutarConsulta($sql);		
	}

	public function select_combo_proveedor()
	{
		$sql="SELECT * FROM proveedor";
		return ejecutarConsulta($sql);		
	}

	
}

?>