<?php
//session_start();
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


Class Enviar
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


  public function nota_credito($id,$idusuario,$fecha,$idcomprobantenc,$idmotivo,$descripcionmotivo)
  {

    $sql = "CALL sp_procesar_nota_credito('$id','$idusuario','$fecha','$idcomprobantenc','$idmotivo','$descripcionmotivo');";
    return ejecutarConsulta($sql);


  }

      
  
   
}

	//Implementamos un método para insertar registros


?>
