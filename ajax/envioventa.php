<?php

if (strlen(session_id()) < 1)
  session_start();
  
require_once "../modelos/Envioventa.php";
$enviar = new Enviar;



switch ($_GET["op"])
{
    case 'enviar_sunat':
		$rspta=$enviar->enviar_sunat($_POST["idventasunat"]);
 		echo $rspta ? "Envio Aceptado" : "Envio no se pudo procesar";
	break;

}


