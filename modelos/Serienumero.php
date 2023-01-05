<?php
/*Incluímos inicialmente la conexión a la base de datos
*/require "../config/Conexion.php";

Class Serienumero
{
/*	Implementamos nuestro constructor
*/
public function __construct()
	{

	}

/*	Implementar un método para listar los registros
*/
public function listar()
	{
		$sql="SELECT * FROM serienumero WHERE estado='1'";
		return ejecutarConsulta($sql);
	}


	public function mostrar_serie($idtipocomprobante)
	{
		$sql="SELECT * FROM serienumero WHERE idtipocomprobante='$idtipocomprobante' AND estado='1' AND tipo='0'";
		return ejecutarConsulta($sql);
	}


	public function serie_mostrar($idserienumero)
		{
			$sql="SELECT * FROM serienumero WHERE idserienumero='$idserienumero' AND tipo='0'";
			return ejecutarConsultaSimpleFila($sql);
		}


		public function mostrar_serie2($idtipocomprobante)
	{
		$sql="SELECT * FROM serienumero WHERE idtipocomprobante='$idtipocomprobante' AND estado='1' AND tipo='1'";
		return ejecutarConsulta($sql);
	}


	public function serie_mostrar2($idserienumero)
		{
			$sql="SELECT * FROM serienumero WHERE idserienumero='$idserienumero' AND tipo='1'";
			return ejecutarConsultaSimpleFila($sql);
		}

}

?>
