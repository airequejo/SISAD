<?php 
/*Incluímos inicialmente la conexión a la base de datos
*/require "../config/Conexion.php";

Class Gestionarcompromiso
{
/*	Implementamos nuestro constructor
*/	public function __construct()
	{

	}

/*	Implementar un método para listar los registros
*/	public function listar($idcliente)
	{
		$sql="CALL sp_listar_compromisos_cliente('$idcliente');";
		return ejecutarConsulta($sql);		
	}

	public function listar_detalle_pagos($idcredito)
	{
		$sql="CALL sp_mostrar_detalle_pagos('$idcredito');";
		return ejecutarConsulta($sql);		
	}

	public function combo_cliente_credito()
	{
		$sql="CALL sp_combo_cliente_compromiso();";
		return ejecutarConsulta($sql);		
	}

	public function anular_pago_credito($id,$idusuario)
		{
			$sql="CALL sp_anular_pago_credito('$id','$idusuario');";
			return ejecutarConsulta($sql);		
		}

	public function insert_credito($idcredito,$fechapago,$monto,$idformapago,$operacion,$fechaoperacion,$idusuario)
	{
		$sql = "CALL sp_insertar_pago_ingreso('$idcredito','$fechapago','$monto','$idformapago','$operacion','$fechaoperacion','$idusuario');";
		return ejecutarConsulta($sql);
	}

	public function mostrar_detalle_credito($idcredito)
	{
		$sql="CALL sp_mostrar_detalles_credito_ingreso('$idcredito')";
		return ejecutarConsultaSimpleFila($sql);
	}
	
	public function mostrar_detalle_pagos($idcredito)
	{
		$sql="SELECT
        c.monto_credito,
        cli.dniruc,
        direcciones.nombredireccion as direccion,
        fp.descripcion,
        c.idcredito,
        cli.nombre,
        dc.iddetallecredito,
        dc.fechapago,
        dc.monto,
        dc.idformapago,
        c.idventa,
        dc.estado,
        c.fecha_credito,
        c.monto_venta,
        c.montoabonado,
        c.deuda_actual,
        dc.idusuariocobro,
        (SELECT login FROM usuario WHERE idusuario = dc.idusuariocobro) as u_cobro,
        dc.idusuarioanula,
        (SELECT login FROM usuario WHERE idusuario = dc.idusuarioanula) as u_anula
        FROM
        credito AS c
        LEFT JOIN detallepagoingreso AS dc ON c.idcredito = dc.idcredito
        LEFT JOIN venta AS v ON c.idventa = v.idventa
        LEFT JOIN direcciones ON  v.iddireccioncliente = direcciones.iddireccion
        LEFT JOIN clientes as cli ON direcciones.idcliente=cli.idcliente
        LEFT JOIN formapago AS fp ON dc.idformapago = fp.idformapago
        WHERE	c.idcredito = '$idcredito' AND dc.estado=1";
		return ejecutarConsulta($sql);
	}
	
}

?>