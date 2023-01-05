<?php 
	//header('Location: login.html');
if (isset($_GET["pagina"])) {

	if ($_GET["pagina"]=="login") 
	{
		include "login.html";
		
	}

	// MOD CUENTAS
	if ($_GET["pagina"]=="cuenta") { include "cuentas.php"; }
	if ($_GET["pagina"]=="subcuenta") { include "subcuentas.php"; }
	if ($_GET["pagina"]=="divisionaria") { include "divisionarias.php"; }

	// MOD ACTIVIDADES
	if ($_GET["pagina"]=="gasto") { include "gastos.php"; }
	if ($_GET["pagina"]=="subgasto") { include "subgasto.php"; }
	if ($_GET["pagina"]=="actividad") { include "actividades.php"; }

	// MOD CONFIGURACION
	if ($_GET["pagina"]=="especialidad") { include "especialidad.php"; }
	if ($_GET["pagina"]=="periodo") { include "periodos.php"; }
	if ($_GET["pagina"]=="caja") { include "caja.php"; }

	// MOD PRODUCTOS
	if ($_GET["pagina"]=="producto") { include "productos.php"; }
	if ($_GET["pagina"]=="detalleproducto") { include "detalleproductos.php"; }
	if ($_GET["pagina"]=="precios") { include "precios.php"; }


	// MOD INGRESOS
	if ($_GET["pagina"]=="venta") { include "ventas.php"; }	
	if ($_GET["pagina"]=="listaventa") { include "listaventas.php"; }
	if ($_GET["pagina"]=="cliente") { include "cliente.php"; }

	// MOD EGRESOS
	if ($_GET["pagina"]=="compra") { include "compra.php"; }	
	if ($_GET["pagina"]=="proveedores") { include "proveedores.php"; }

	// MOD ACCESOS
	if ($_GET["pagina"]=="usuario") { include "usuarios.php"; }
	
	
	// CTA POR COBRAR
	if ($_GET["pagina"]=="listacompromisos") { include "listacompromisos.php"; }	
	if ($_GET["pagina"]=="gestionarcompromisos") { include "gestionarcompromisos.php"; }	

	// REPORTES
	if ($_GET["pagina"]=="escritorio") { include "escritorio.php"; }
	if ($_GET["pagina"]=="reporte") { include "reportes.php"; }

	



	
		
		

}

else

{

	include "login.html";

}

?>