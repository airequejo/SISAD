<?php

require "../config/Conexion.php";

Class Tipocomprobante
{
	/*Implementamos nuestro constructor*/
	public function __construct()
	{

	}

	
/*	Implementar un método para listar los registros
*/	public function select_combo_tipocomprobante()
{
	$sql="SELECT * FROM tipocomprobante WHERE estado='0' AND fun IN(2,3) and tipo not in('S')";
	return ejecutarConsulta($sql);
}

/*	Implementar un método para listar los registros
*/	public function select_combo_tipocomprobante_salidas()
{
	$sql="SELECT * FROM tipocomprobante WHERE estado='0' AND tipo='S'";
	return ejecutarConsulta($sql);
}


	public function select_combo_tipocomprobante_compra()
{
	$sql="SELECT * FROM tipocomprobante WHERE estado='0' AND fun IN(1,3)";
	return ejecutarConsulta($sql);
}

public function select_series($iddocumento)
{
	$sql="SELECT * FROM serienumero WHERE idtipocomprobante='$iddocumento' AND estado='1'";
	return ejecutarConsulta($sql);
}



}