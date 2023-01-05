<?php

date_default_timezone_set('America/Lima');
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function totalventahoy()
	{
		$sql = "SELECT IFNULL(SUM(total),0) as total FROM venta WHERE DATE(fecha)=curdate() AND estado='0' AND idtipocomprobante<>'7'";
		return ejecutarConsulta($sql);
	}


	public function comprasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT DATE(c.fecha) as fechac,u.nombre as usuario, p.nombrerazon as proveedor,c.tipocomprobante,c.serie,c.numero,c.total,c.igv,c.estado FROM compra c INNER JOIN proveedor p ON c.idproveedor=p.idproveedor INNER JOIN usuario u ON c.idusuario=u.idusuario WHERE DATE(c.fecha)>='$fecha_inicio' AND DATE(c.fecha)<='$fecha_fin'";
		return ejecutarConsulta($sql);
	}

	public function ventasfecha($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT v.idventa, DATE(v.fecha) as fechav,(v.fecha) as fecha_hora,u.nombre as usuario, c.nombre as cliente, t.descripcion as tipocomprobante, v.comprobante,v.total,v.igv,v.estado FROM venta v INNER JOIN cliente c ON v.idcliente=c.idcliente INNER JOIN usuario u ON v.idusuario=u.idusuario INNER JOIN tipocomprobante t ON v.idtipocomprobante=t.idtipocomprobante WHERE DATE(v.fecha)>='$fecha_inicio' AND DATE(v.fecha)<='$fecha_fin' ORDER BY v.idventa DESC";
		return ejecutarConsulta($sql);
	}

	public function totalcomprahoy()
	{
		$sql="SELECT IFNULL(SUM(total),0) as total FROM compra WHERE DATE(fecha)=curdate() AND estado='0'" ;
		return ejecutarConsulta($sql);
	}

	public function totalventacontado()
	{
		$sql = "SELECT IFNULL(SUM(total),0) as total FROM venta WHERE DATE(fecha)=CURDATE() AND estado='0' AND idformapago='1' AND idtipocomprobante<>'7'";
		return ejecutarConsulta($sql);
	}

	public function totalventatarjeta()
	{
		$sql = "SELECT IFNULL(SUM(total),0) as total FROM venta WHERE DATE(fecha)=CURDATE() AND estado='0' AND idformapago='2' AND idtipocomprobante<>'7'";
		return ejecutarConsulta($sql);
	}

	public function totalventamixto()
	{
		$sql = "SELECT IFNULL(SUM(montoabonado),0) as totalefectivo,IFNULL(SUM(montotarjeta),0) as totaltarjeta FROM venta WHERE DATE(fecha)=CURDATE() AND estado='0' AND idformapago='3' AND idtipocomprobante<>'7'";
		return ejecutarConsulta($sql);
	}

	public function totalventadeposito()
	{
		$sql = "SELECT IFNULL(SUM(total),0) as total FROM venta WHERE DATE(fecha)=CURDATE() AND estado='0' AND (idformapago='4' OR idformapago='6' OR idformapago='7') AND idtipocomprobante<>'7'";
		return ejecutarConsulta($sql);
	}

	public function comidasvendidashoy()
	{
		$sql = "SELECT v.fecha, p.descripcion as nombreconteo,SUM(dv.cantidad) AS cantidad_dia, avg(dv.precio) as promedio FROM `detalleventa` dv INNER JOIN productos p ON p.idproducto=dv.iddetalleproductodivisionaria INNER JOIN venta v ON v.idventa=dv.idventa WHERE v.fecha>=CURDATE() and v.fecha<=CURDATE()  GROUP BY p.idproducto ORDER BY p.descripcion ASC";
		return ejecutarConsulta($sql);
	}

public function totalventahoy2($fecha)
	{
		$sql="SELECT IFNULL(SUM(total),0) as total FROM venta WHERE DATE(fecha)='$fecha' AND estado='0' and idtipocomprobante in (1,3,5)";
		return ejecutarConsulta($sql);
	}

	public function comprasultimos_10dias()
	{
	     $s = "SET lc_time_names = 'es_ES'";
	    
	    ejecutarConsulta($s);
	    
		$sql="SELECT CONCAT_WS('-',SUBSTR(DATE_FORMAT(fecha,'%M'),1,3),YEAR(fecha)) as fechac,SUM(total) as totalc FROM compra 
WHERE estado= 0   GROUP by MONTH(fecha) ORDER BY YEAR(fecha), MONTH(fecha) ASC limit 0,12";
		return ejecutarConsulta($sql);
	}

	public function ventasultimos_12meses()
	{
	     $s = "SET lc_time_names = 'es_ES'";
		 $y = "DROP TABLE IF EXISTS hist_venta";
		 $x = "CREATE TEMPORARY TABLE hist_venta(SELECT CONCAT_WS('-',SUBSTR(DATE_FORMAT(fecha,'%M'),1,3),YEAR(fecha)) as fecha,SUM(total) as totalv,YEAR(fecha) as anio,MONTH(fecha) as mes FROM venta WHERE estado= 0  AND idtipocomprobante in (1,3,5) GROUP by YEAR(fecha), MONTH(fecha) ORDER BY YEAR(fecha) DESC,MONTH(fecha)  desc limit 0,12)";
	    
	    ejecutarConsulta($s);
		ejecutarConsulta($y);
		ejecutarConsulta($x);

		$sql="SELECT * FROM hist_venta ORDER By anio asc,mes asc";
		return ejecutarConsulta($sql);
	}

	public function comprobante_compra($idcompra)
	{
		$sql="SELECT c.idcompra,DATE(c.fecha) as fecha,c.idproveedor,p.nombrerazon as proveedor, p.direccion as direccion ,u.idusuario,u.nombre as usuario,tc.descripcion,c.serie,c.numero,c.total,c.igv,c.estado FROM compra c INNER JOIN proveedor p ON c.idproveedor=p.idproveedor INNER JOIN usuario u ON c.idusuario=u.idusuario CROSS JOIN tipocomprobante tc ON tc.idtipocomprobante=c.tipocomprobante WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	public function detalle_compra($idcompra)
	{
		$sql="SELECT dc.idcompra,dc.idproducto,p.descripcion,dc.cantidad,dc.precio FROM detallecompra dc inner join producto p on dc.idproducto=p.idproducto where dc.idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	public function config_empresa()
	{
		$sql="SELECT * FROM empresa";
		return ejecutarConsulta($sql);
	}


	public function reporteGastos()
	{
		$sql="SELECT IFNULL(SUM(total),0) as total FROM otros_gastos WHERE DATE(fecha)=curdate()";
		return ejecutarConsulta($sql);
	}
	
	public function productosvendidoshoy($fecha)
	{
		$sql = "SELECT v.fecha, p.descripcion as nombreconteo,SUM(dv.cantidad) AS cantidad_dia FROM `detalleventa` dv 
		INNER JOIN producto p ON p.idproducto=dv.idproducto 
		INNER JOIN venta v ON v.idventa=dv.idventa 
		WHERE date(v.fecha) ='$fecha' and v.estado='0' AND v.idtipocomprobante in (1,3,5)   GROUP BY p.idproducto";
		return ejecutarConsulta($sql);
	}
	public function buscarcaja()
	{
		$sql = "SELECT idcaja,fecha_apertura,monto_inicial,total_efectivo,estado,COUNT(idusuario) AS haycaja FROM cajas WHERE estado='0'";
		return ejecutarConsulta($sql);
	}
	
	public function ventaultimomes()
	{
		$anioActual = date("Y");
		$mesActual = date("n");
		$cantidadDias = cal_days_in_month(CAL_GREGORIAN, $mesActual, $anioActual);
		$sql = "SELECT CONCAT(DAY(fecha),'-',MONTH(fecha)) as fecha,(SUM(total)) as totalv,(ELT(WEEKDAY(fecha) + 1, 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 100, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(81, 46, 95 , 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)')) AS dias_semana,(ELT(WEEKDAY(fecha) + 1, 'lun', 'mar', 'mie', 'jue', 'vie', 'sáb', 'dom')) AS nombredia FROM venta where MONTH(fecha)='$mesActual' GROUP by day(fecha) ORDER BY day(fecha) ASC limit 0,$cantidadDias";
		
		//$sql = "SELECT CONCAT(DAY(v.fecha),'-',MONTH(v.fecha)) as fecha,if(dv.llevar=1,SUM(dv.precio*dv.cantidad),0) as totalv,(ELT(WEEKDAY(v.fecha) + 1, 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 100, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(153, 102, 255, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 99, 132, 0.2)')) AS dias_semana,(ELT(WEEKDAY(v.fecha) + 1, 'lun', 'mar', 'mie', 'jue', 'vie', 'sáb', 'dom')) AS nombredia FROM detalleventa dv INNER JOIN venta v on v.idventa=dv.idventa where MONTH(v.fecha)='$mesActual' GROUP by day(v.fecha) ORDER BY day(v.fecha) ASC limit 0,$cantidadDias";
		return ejecutarConsulta($sql);
	}
	public function ventasxproducto(){
		$sql="SELECT count(dv.iddetalleproductodivisionaria) as cantidadp,p.descripcion,p.idproducto FROM `detalleventa` dv INNER JOIN productos p ON dv.iddetalleproductodivisionaria=p.idproducto GROUP by p.idproducto order by count(dv.iddetalleproductodivisionaria) DESC";
		return ejecutarConsulta($sql);
	}
	
	public function reporteperiodogastos($idperiodo){
		$sql="SELECT p.idproducto,dtv.iddetalleproductodivisionaria,d.descripcion AS divisionaria,s.descripcion AS subcuenta,c.descripcion AS cuenta, p.descripcion, dtv.idperiodo, dtv.precio * dtv.cantidad AS total, c.idcuenta, s.idsubcuenta, 
					d.iddivisionaria, c.codigocuenta, s.codigosubcuenta, d.codigodivisionaria, venta.fecha, venta.idventa, venta.total, venta.montoabonado FROM	detalleventa AS dtv	INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria
					INNER JOIN productos AS p ON dtp.idproducto = p.idproducto	INNER JOIN
					divisionarias AS d	ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN
					subcuentas AS s	ON d.idsubcuenta = s.idsubcuenta INNER JOIN	cuentas AS c
					ON s.idcuenta = c.idcuenta INNER JOIN venta	ON 	dtv.idventa = venta.idventa
					WHERE dtv.idperiodo = '$idperiodo'";
		return ejecutarConsulta($sql);
	}
	
	public function reporteperiodogastosfechas($inicio,$final){
		$sql="SELECT p.idproducto,dtv.iddetalleproductodivisionaria,d.descripcion AS divisionaria,s.descripcion AS subcuenta,c.descripcion AS cuenta, p.descripcion, dtv.idperiodo, dtv.precio * dtv.cantidad AS total, c.idcuenta, s.idsubcuenta, 
					d.iddivisionaria, c.codigocuenta, s.codigosubcuenta, d.codigodivisionaria, venta.fecha, venta.idventa, venta.total, venta.montoabonado FROM	detalleventa AS dtv	INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria
					INNER JOIN productos AS p ON dtp.idproducto = p.idproducto	INNER JOIN
					divisionarias AS d	ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN
					subcuentas AS s	ON d.idsubcuenta = s.idsubcuenta INNER JOIN	cuentas AS c
					ON s.idcuenta = c.idcuenta INNER JOIN venta	ON 	dtv.idventa = venta.idventa
					WHERE";
		return ejecutarConsulta($sql);
	}
	
	public function cuentasingresos($idperiodo){
		$sql="SELECT dtv.idperiodo,dtv.iddetalleproductodivisionaria,c.idcuenta,c.codigocuenta,c.descripcion AS cuenta,
		s.idsubcuenta,s.codigosubcuenta,s.descripcion AS subcuenta,d.iddivisionaria,d.codigodivisionaria,d.descripcion AS divisionaria,
		p.idproducto,p.descripcion,SUM(dtv.precio * dtv.cantidad) AS total,venta.fecha,venta.idventa,venta.montoabonado 
		FROM
		detalleventa AS dtv
		INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria INNER JOIN productos AS p ON dtp.idproducto = p.idproducto
		INNER JOIN divisionarias AS d ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN subcuentas AS s ON d.idsubcuenta = s.idsubcuenta
		INNER JOIN cuentas AS c ON s.idcuenta = c.idcuenta INNER JOIN venta ON dtv.idventa = venta.idventa 
		WHERE
		dtv.idperiodo = '$idperiodo'
		GROUP BY
		c.idcuenta
		ORDER BY
		c.codigocuenta ASC";
	return ejecutarConsulta($sql);
	}
	
	public function subcuentasingresos($idperiodo,$idcuenta){
	$sql="SELECT dtv.idperiodo,dtv.iddetalleproductodivisionaria,c.idcuenta,c.codigocuenta,c.descripcion AS cuenta,
		s.idsubcuenta,s.codigosubcuenta,s.descripcion AS subcuenta,d.iddivisionaria,d.codigodivisionaria,d.descripcion AS divisionaria,
		p.idproducto,p.descripcion,SUM(dtv.precio * dtv.cantidad) AS total,venta.fecha,venta.idventa,venta.montoabonado 
		FROM
		detalleventa AS dtv
		INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria INNER JOIN productos AS p ON dtp.idproducto = p.idproducto
		INNER JOIN divisionarias AS d ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN subcuentas AS s ON d.idsubcuenta = s.idsubcuenta
		INNER JOIN cuentas AS c ON s.idcuenta = c.idcuenta INNER JOIN venta ON dtv.idventa = venta.idventa 
		WHERE
		dtv.idperiodo = '$idperiodo' AND c.idcuenta='$idcuenta'
		GROUP BY
		s.idsubcuenta
		ORDER BY
		s.codigosubcuenta ASC";
	return ejecutarConsulta($sql);
	}
	
	public function divisionariaingresos($idperiodo,$idcuenta,$idsubcuenta){
		$sql="SELECT dtv.idperiodo,dtv.iddetalleproductodivisionaria,c.idcuenta,c.codigocuenta,c.descripcion AS cuenta,
			s.idsubcuenta,s.codigosubcuenta,s.descripcion AS subcuenta,d.iddivisionaria,d.codigodivisionaria,d.descripcion AS divisionaria,
			p.idproducto,p.descripcion,SUM(dtv.precio * dtv.cantidad) AS total,venta.fecha,venta.idventa,venta.montoabonado 
			FROM
			detalleventa AS dtv
			INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria INNER JOIN productos AS p ON dtp.idproducto = p.idproducto
			INNER JOIN divisionarias AS d ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN subcuentas AS s ON d.idsubcuenta = s.idsubcuenta
			INNER JOIN cuentas AS c ON s.idcuenta = c.idcuenta INNER JOIN venta ON dtv.idventa = venta.idventa 
			WHERE
			dtv.idperiodo = '$idperiodo' AND c.idcuenta='$idcuenta'  AND s.idsubcuenta='$idsubcuenta'
			GROUP BY
			d.iddivisionaria
			ORDER BY
			d.codigodivisionaria ASC";
		return ejecutarConsulta($sql);
		}
	
	// GESTION DE CONSULTAS DE GASTOS O EGRESOS
	public function reporteperiodoingresosfechas($inicio,$final){
		$sql="SELECT p.idproducto,dtv.iddetalleproductodivisionaria,d.descripcion AS divisionaria,s.descripcion AS subcuenta,c.descripcion AS cuenta, p.descripcion, dtv.idperiodo, dtv.precio * dtv.cantidad AS total, c.idcuenta, s.idsubcuenta, 
					d.iddivisionaria, c.codigocuenta, s.codigosubcuenta, d.codigodivisionaria, venta.fecha, venta.idventa, venta.total, venta.montoabonado FROM	detalleventa AS dtv	INNER JOIN detalle_producto_divisionarias AS dtp ON dtv.iddetalleproductodivisionaria = dtp.iddetalleproductodivisionaria
					INNER JOIN productos AS p ON dtp.idproducto = p.idproducto	INNER JOIN
					divisionarias AS d	ON dtp.iddivisionaria = d.iddivisionaria INNER JOIN
					subcuentas AS s	ON d.idsubcuenta = s.idsubcuenta INNER JOIN	cuentas AS c
					ON s.idcuenta = c.idcuenta INNER JOIN venta	ON 	dtv.idventa = venta.idventa
					WHERE venta.fecha >= '$inicio' AND venta.fecha <= '$final' ORDER BY c.codigocuenta ASC";
		return ejecutarConsulta($sql);
	}
	
	public function cuentasgastos($idperiodo){
		$sql="SELECT actividades.idperiodo, detallecompra.iddetalleproductodivisionaria, cuentas.idcuenta, 
		cuentas.codigocuenta, cuentas.descripcion AS cuenta, subcuentas.idsubcuenta, subcuentas.codigosubcuenta, 
		subcuentas.descripcion AS subcuenta, divisionarias.iddivisionaria, divisionarias.codigodivisionaria, 
		divisionarias.descripcion AS divisionaria, detalle_producto_divisionarias.idproducto, productos.descripcion,
		SUM(detallecompra.cantidad*detallecompra.precio) as total, compra.fecha, compra.idcompra, compra.montoabonado
		FROM
		detalle_producto_divisionarias
		INNER JOIN	detallecompra ON detalle_producto_divisionarias.iddetalleproductodivisionaria = detallecompra.iddetalleproductodivisionaria
		INNER JOIN	divisionarias ON detalle_producto_divisionarias.iddivisionaria = divisionarias.iddivisionaria
		INNER JOIN	subcuentas	ON divisionarias.idsubcuenta = subcuentas.idsubcuenta
		INNER JOIN	cuentas	ON subcuentas.idcuenta = cuentas.idcuenta
		INNER JOIN	compra	ON detallecompra.idcompra = compra.idcompra
		INNER JOIN	actividades	ON detallecompra.idactividad = actividades.idactividad
		INNER JOIN	productos	ON detalle_producto_divisionarias.idproducto = productos.idproducto
		WHERE
		actividades.idperiodo = '$idperiodo'
		GROUP BY
		cuentas.idcuenta
		ORDER BY
		cuentas.codigocuenta ASC";
	return ejecutarConsulta($sql);
	}
	
	public function subcuentasgastos($idperiodo,$idcuenta){
		$sql="SELECT actividades.idperiodo, detallecompra.iddetalleproductodivisionaria, cuentas.idcuenta, 
		cuentas.codigocuenta, cuentas.descripcion AS cuenta, subcuentas.idsubcuenta, subcuentas.codigosubcuenta, 
		subcuentas.descripcion AS subcuenta, divisionarias.iddivisionaria, divisionarias.codigodivisionaria, 
		divisionarias.descripcion AS divisionaria, detalle_producto_divisionarias.idproducto, productos.descripcion,
		SUM(detallecompra.cantidad*detallecompra.precio) as total, compra.fecha, compra.idcompra, compra.montoabonado
		FROM
		detalle_producto_divisionarias
		INNER JOIN	detallecompra ON detalle_producto_divisionarias.iddetalleproductodivisionaria = detallecompra.iddetalleproductodivisionaria
		INNER JOIN	divisionarias ON detalle_producto_divisionarias.iddivisionaria = divisionarias.iddivisionaria
		INNER JOIN	subcuentas	ON divisionarias.idsubcuenta = subcuentas.idsubcuenta
		INNER JOIN	cuentas	ON subcuentas.idcuenta = cuentas.idcuenta
		INNER JOIN	compra	ON detallecompra.idcompra = compra.idcompra
		INNER JOIN	actividades	ON detallecompra.idactividad = actividades.idactividad
		INNER JOIN	productos	ON detalle_producto_divisionarias.idproducto = productos.idproducto
		WHERE
		actividades.idperiodo = '$idperiodo'  AND cuentas.idcuenta='$idcuenta'
		GROUP BY
		subcuentas.idsubcuenta
		ORDER BY
		subcuentas.codigosubcuenta ASC";
	return ejecutarConsulta($sql);
	}
	
	public function divisionariagastos($idperiodo,$idcuenta,$idsubcuenta){
		$sql="SELECT actividades.idperiodo, detallecompra.iddetalleproductodivisionaria, cuentas.idcuenta, 
		cuentas.codigocuenta, cuentas.descripcion AS cuenta, subcuentas.idsubcuenta, subcuentas.codigosubcuenta, 
		subcuentas.descripcion AS subcuenta, divisionarias.iddivisionaria, divisionarias.codigodivisionaria, 
		divisionarias.descripcion AS divisionaria, detalle_producto_divisionarias.idproducto, productos.descripcion,
		SUM(detallecompra.cantidad*detallecompra.precio) as total, compra.fecha, compra.idcompra, compra.montoabonado
		FROM
		detalle_producto_divisionarias
		INNER JOIN	detallecompra ON detalle_producto_divisionarias.iddetalleproductodivisionaria = detallecompra.iddetalleproductodivisionaria
		INNER JOIN	divisionarias ON detalle_producto_divisionarias.iddivisionaria = divisionarias.iddivisionaria
		INNER JOIN	subcuentas	ON divisionarias.idsubcuenta = subcuentas.idsubcuenta
		INNER JOIN	cuentas	ON subcuentas.idcuenta = cuentas.idcuenta
		INNER JOIN	compra	ON detallecompra.idcompra = compra.idcompra
		INNER JOIN	actividades	ON detallecompra.idactividad = actividades.idactividad
		INNER JOIN	productos	ON detalle_producto_divisionarias.idproducto = productos.idproducto
		WHERE
		actividades.idperiodo = '$idperiodo'  AND cuentas.idcuenta='$idcuenta' AND subcuentas.idsubcuenta='$idsubcuenta'
		GROUP BY
		divisionarias.iddivisionaria
		ORDER BY
		divisionarias.codigodivisionaria ASC";
	return ejecutarConsulta($sql);
	
	}
	
	public function periodoproducto($idperiodo,$idproducto){
		$sql="SELECT
		dv.iddetalleproductodivisionaria, 
		p.descripcion, 
		p.idproducto, 
		clientes.nombre, 
		venta.idventa, 
		clientes.dniruc, 
		clientes.celular
	FROM
		detalleventa AS dv
		INNER JOIN
		productos AS p
		ON 
			dv.iddetalleproductodivisionaria = p.idproducto
		INNER JOIN
		venta
		ON 
			dv.idventa = venta.idventa
		INNER JOIN
		direcciones
		ON 
			venta.iddireccioncliente = direcciones.iddireccion
		INNER JOIN
		clientes
		ON 
			direcciones.idcliente = clientes.idcliente
			WHERE dv.idperiodo='$idperiodo' AND idproducto='$idproducto'
	ORDER BY
		dv.iddetalleproductodivisionaria DESC";
		return ejecutarConsulta($sql);
		}
	
	
}

