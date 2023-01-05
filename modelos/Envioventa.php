<?php
    //require_once "../reportes/Letras.php";
    require_once "Venta.php";
        

    Class Enviar
    {
        //Implementamos nuestro constructor
        public function __construct()
        {

        }

        public function enviar_sunat($id)

        {

           

            /*=============================================
            =   INSTANCIAMOS A LA CLASE CONSULTA      =
            =============================================*/  
            $consultas = new Consultas;


            /*=============================================
            =            OBTENER DATOS DE LA EMPRESA      =
            =============================================*/  

            $rspta = $consultas->config_empresa();

            $reg = $rspta->fetch_object();

                $ruc=$reg->ruc;
                $nombrerazonsocial=$reg->nombre;
                $razon=$reg->razon;
                $direccion=$reg->direccion;
                $ubigeo=$reg->ubigeo;
                $departamento=$reg->departamento;
                $provincia=$reg->provincia;
                $distrito=$reg->distrito;
                $tipo_proceso=$reg->tipoproceso;
                $usuariosol=$reg->usuariosol;
                $clavesol=$reg->clavesol;
                $cod_tipo_operacion=$reg->tipo_operacion;
                $igv_dice=$reg->igv_dice;
                $igv_aplica=$reg->igv_aplica; // error en menor de 8
                $ruta_factura=$reg->ruta_factura; // error en menor de 8
                $ruta_boleta=$reg->ruta_boleta; // error en menor de 8
                $ruta_notacredito=$reg->ruta_notacredito; // error en menor de 8
                $ruta_notadebito=$reg->ruta_notadebito; // error en menor de 8
                $ruta_cdr_base=$reg->ruta_cdr; // error en menor de 8
                //$igv_aplica=18;
                
                $pass_firma_d = $reg->pass_certificado;

                $anexo = $reg->anexo;               

                $emisorArray=array(
                    "ruc"                        => $ruc,
                    "tipo_doc"                  => "6",
                    "nom_comercial"             => $razon, /* caracter & no acepta */
                    "razon_social"              => $nombrerazonsocial,
                    "codigo_ubigeo"             => $ubigeo,
                    "direccion"                 => $direccion,
                    "direccion_departamento"    => $departamento,
                    "direccion_provincia"       => $provincia,
                    "direccion_distrito"        => $distrito,
                    "direccion_codigopais"      => "PE",
                    "usuariosol"                => $usuariosol,
                    "clavesol"                  => $clavesol,
                    "tipo_proceso"              => $tipo_proceso,
                    "pass_firma_d"              => $pass_firma_d,
                    "anexo"                     => $anexo


                                );

            /*=============================================
            =            INSTANCIAMOS A LA CLASE VENTA       =
            =============================================*/  

             $venta = new Venta();


            /*=============================================
            =       OBTENER DATOS DE LA VENTA DETALLE     =
            =============================================*/  

            $rsptad = $venta->listarDetalle($id);

                //$sw=true;
                $detalle=array();
                $campos=array();
                $x=0;
                

                while ($regd = $rsptad->fetch_object())
                {
                    $x++;

                    $subtotal_detalle=($regd->precio*$regd->cantidad)/(1+($igv_aplica/100));
                    $igv=($subtotal_detalle)*($igv_aplica/100);

                    $campos['txtITEM']=$x;
                    $campos['txtUNIDAD_MEDIDA_DET']='NIU';
                    $campos['txtCANTIDAD_DET']=$regd->cantidad;
                    $campos['txtPRECIO_DET']=$regd->precio;
                    $campos['txtSUB_TOTAL_DET']=round($subtotal_detalle,2);            
                    $campos['txtPRECIO_TIPO_CODIGO']='01'; // TIPO MONEDA
                    $campos['txtIGV']=round($igv,2); //Traer de la venta en caso se aplique
                    $campos['txtISC']='0';
                    $campos['txtIMPORTE_DET']=round($subtotal_detalle,2);
                    $campos['txtCOD_TIPO_OPERACION']=$cod_tipo_operacion;  //20 exonerado igv
                    $campos['txtCODIGO_DET']=$regd->idproducto;
                    $campos['txtDESCRIPCION_DET']=$regd->descripcion; //MOdificar por valores de la caja de texto
                    $campos['txtPRECIO_SIN_IGV_DET']=round($subtotal_detalle,2);
                    
                    $detalle[]=$campos;
                }


            /*=============================================
            =            OBTENER DATOS DE LA VENTA  CABEZERA    =
            =============================================*/  

            $rsptav = $venta->mostrar_venta_cabecera($id);
            $regv = $rsptav->fetch_object();

            /*  OJO CAMBIAR EN EL MODELO VENTA VENTA_CAABEZERA total_venta  A total  */

            /*=================================================================================
            =            CALCULO TOTAL GRABADAS Y EXONERADS SEN COD_TIPO_OPERACION            =
            =================================================================================*/
            
            if ($cod_tipo_operacion==20)
                {

                    $total_gravada=0;
                    $total_exonerado=$regv->total_venta;
                }

            if ($cod_tipo_operacion==10) 
                {

                    $total_gravada=round(($regv->total_venta)/(1+($igv_aplica/100)),2);
                    $total_exonerado=0;
                }
            
                            
            /*=====  End of CALCULO TOTAL GRABADAS Y EXONERADS SEN COD_TIPO_OPERACION  ======*/

             /* actualizacion nota credito */


            IF($regv->idserienumero==='9'){
                $tipodocumentoafectado="01";
            }

            IF($regv->idserienumero==='10'){
                $tipodocumentoafectado="03";
            }


            /* PARA LASSER 


            IF($regv->idserienumero==='8'){
                $tipodocumentoafectado="01";
            }

            IF($regv->idserienumero==='9'){
                $tipodocumentoafectado="03";
            }*/

            /* fin actualizacion nota credito */


            /*=============================================
            =            INSTANCIAMOS A LA CLASE LETRAS    =
            =============================================*/  

            $letras_numero = new EnLetras(); 


             /*=============================================
            =       OBTENER DATOS DE LA NUMERO A LETRAS     =
            =============================================*/ 

            $con_letra=strtoupper($letras_numero->ValorEnLetras(round($regv->total_venta,2)," CON "));
                
                 


           $tipo_comprobante_venta=$regv->idtipocomprobante;


            /*=============================================
            =      PROCESAR FACTURA   =
            =============================================*/ 

           

            if ($tipo_comprobante_venta=='1')

                {
                    $ruta = $ruta_factura;

                        $data = array(
                            //Cabecera del documento
                            "tipo_operacion"                => "0101",
                            "total_gravadas"                => round($total_gravada,2),
                            "total_inafecta"                => "0",
                            "total_exoneradas"              => round($total_exonerado,2),
                            "total_gratuitas"               => "0",
                            "total_exportacion"             => "0",
                            "total_descuento"               => "0",
                            "sub_total"                     => round(($regv->total_venta)/(1+($igv_aplica/100)),2),
                            "porcentaje_igv"                => $igv_dice,
                            "total_igv"                     => round($regv->total_venta-(($regv->total_venta)/(1+($igv_aplica/100))),2),
                            "total_isc"                     => "0",
                            "total_otr_imp"                 => "0",
                            "total"                         => round($regv->total_venta,2),
                            "total_letras"                  => $con_letra,
                            "nro_guia_remision"             => "",
                            "cod_guia_remision"             => "",
                            "nro_otr_comprobante"           => "",
                            "serie_comprobante"             => $regv->serie_generada, //Para Facturas la serie debe comenzar por la letra F, seguido de tres dígitos
                            "numero_comprobante"            => $regv->numero_generado,
                            "fecha_comprobante"             => $regv->fecha,
                            "fecha_vto_comprobante"         => $regv->fecha,
                            "cod_tipo_documento"            => '0'.$regv->idtipocomprobante, /* 01 factura */
                            "cod_moneda"                    => "PEN",
                            
                            // condicion de pago
                            "tipo_venta"                     => $regv->tipoventa,
                            "fecha_vencimiento"              => $regv->fecha_vencimiento,

                            //Datos del cliente
                            "cliente_numerodocumento"       => $regv->dniruc,
                            "cliente_nombre"                => $regv->nombre,
                            "cliente_tipodocumento"         => $regv->tipodocumento, //6: RUC
                            "cliente_direccion"             => $regv->direc,
                            "cliente_pais"                  => "PE",
                            "cliente_ciudad"                => $regv->procedencia,
                            "cliente_codigoubigeo"          => "",
                            "cliente_departamento"          => "",
                            "cliente_provincia"             => "",
                            "cliente_distrito"              => "",
                            
                            //data de la empresa emisora o contribuyente que entrega el documento electrónico.
                            "emisor" => ($emisorArray),

                            //items del documento
                            "detalle" => ($detalle)
                        );

                }


            /*=============================================
            =      PROCESAR BOLETA   =
            =============================================*/ 

            if ($tipo_comprobante_venta=='3')

                {
                    $ruta = $ruta_boleta;

                             $data = array(
                            //Cabecera del documento
                            "tipo_operacion"                => "0101",
                            "total_gravadas"                => round($total_gravada,2),
                            "total_inafecta"                => "0",
                            "total_exoneradas"              => round($total_exonerado,2),
                            "total_gratuitas"               => "0",
                            "total_exportacion"             => "0",
                            "total_descuento"               => "0",
                            "sub_total"                     => round(($regv->total_venta)/(1+($igv_aplica/100)),2),
                            "porcentaje_igv"                => $igv_dice,
                            "total_igv"                     => round($regv->total_venta-(($regv->total_venta)/(1+($igv_aplica/100))),2),
                            "total_isc"                     => "0",
                            "total_otr_imp"                 => "0",
                            "total"                         => round($regv->total_venta,2),
                            "total_letras"                  => $con_letra,
                            "nro_guia_remision"             => "",
                            "cod_guia_remision"             => "",
                            "nro_otr_comprobante"           => "",
                            "serie_comprobante"             => $regv->serie_generada, //Para Facturas la serie debe comenzar por la letra F, seguido de tres dígitos
                            "numero_comprobante"            => $regv->numero_generado,
                            "fecha_comprobante"             => $regv->fecha,
                            "fecha_vto_comprobante"         => $regv->fecha,
                            "cod_tipo_documento"            => '0'.$regv->idtipocomprobante, /* 03 BOLETA */
                            "cod_moneda"                    => "PEN",
                            
                            // condicion de pago
                            "tipo_venta"                     => $regv->tipoventa,
                            "fecha_vencimiento"              => $regv->fecha_vencimiento,

                            //Datos del cliente
                            "cliente_numerodocumento"       => $regv->dniruc,
                            "cliente_nombre"                => $regv->nombre,
                            "cliente_tipodocumento"         => $regv->tipodocumento, //1: DNI
                            "cliente_direccion"             => $regv->direc,
                            "cliente_pais"                  => "PE",
                            "cliente_ciudad"                => $regv->procedencia,
                            "cliente_codigoubigeo"          => "",
                            "cliente_departamento"          => "",
                            "cliente_provincia"             => "",
                            "cliente_distrito"              => "",


                            //data de la empresa emisora o contribuyente que entrega el documento electrónico.
                            "emisor" => ($emisorArray),

                            //items del documento
                            "detalle" => ($detalle)
                            );

                }

               

                  if ($tipo_comprobante_venta=='7')

                {
                      $ruta = $ruta_notacredito;

                    $data = array(
                        
                        //Cabecera del documento
                        "total_gravadas"                => round($total_gravada,2),
                        "porcentaje_igv"                => $igv_dice,
                        "total_igv"                     => round($regv->total_venta-(($regv->total_venta)/(1+($igv_aplica/100))),2),
                        "total"                         => round($regv->total_venta,2),
                        "total_letras"                  => $con_letra, /// SE AGREGO PARA PRUEBA
                        "serie_comprobante"             => $regv->serie_generada,
                        "numero_comprobante"            => $regv->numero_generado,
                        "fecha_comprobante"             => $regv->fecha,
                        "cod_tipo_documento"            => '0'.$regv->idtipocomprobante, 
                        "cod_moneda"                    => "PEN",

                        "tipo_comprobante_modifica"     => $tipodocumentoafectado, 
                        "nro_documento_modifica"        => $regv->comprobanteref,
                        "cod_tipo_motivo"               => $regv->idmotivo,
                        "descripcion_motivo"            => $regv->descripcionmotivo,

                        //Datos del cliente
                        "cliente_numerodocumento"       => $regv->dniruc,
                        "cliente_nombre"                => $regv->nombre,
                        "cliente_tipodocumento"         => $regv->tipodocumento, //1: DNI 6= RUC
                        //data de la empresa emisora o contribuyente que entrega el documento electrónico.
                                "emisor" => ($emisorArray),

                                //items del documento
                                "detalle" => ($detalle)

                    );
                }


                //$verificaenvio = "SELECT estadoenvio from enviosunat where idventa=(SELECT idventareferencia from venta where idventa='$id')"; 

                //$tipocompro = "SELECT idtipocomprobante from venta where idventa='$id'";
    
               //
            //Invocamos el servicio
            $token = ''; //en caso quieras utilizar algún token generado desde tu sistema

            //codificamos la data
            $data_json = json_encode($data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $ruta);
            curl_setopt(
                $ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Token token="'.$token.'"',
                'Content-Type: application/json',
                )
            );
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $respuesta  = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($respuesta, true);


            /*===========================================================
            =            ACTUALIZAR ENVIO SUNAR SI RESP = OK            =
            ===========================================================*/


          //  $dd=(json_decode($resultado, true));

            $respuesta=$response["respuesta"];
            $cod_sunat=$response["cod_sunat"]; 
            $hash_cdr=$response["hash_cdr"];

            if ($respuesta=='ok')
                {

                    $msj_sunat=$response["msj_sunat"];
                    $hash_cpe=$response["hash_cpe"];
                        
                }

             else
                {

                    $msj_sunat="No se envio comprobante electrónico";
                    $hash_cpe="";
                    $msj_sunat2=$response["msj_sunat"];
                        
                }

            



            $archivo=$ruc.'-0'.$regv->idtipocomprobante.'-'.$regv->comprobante;

            if ($response["cod_sunat"]==="0" || $response["cod_sunat"]==="Warning: DOMDocument::load(): I/O warning : failed to load external entity" || $response["cod_sunat"]=='soap-env:Client.1033') {
              //actualizar el valor del campo recepcion a 1 --> no aceptado
              $sql="UPDATE enviosunat SET estadoenvio='0',respuesta='$respuesta',cod_sunat='$cod_sunat',hash_cpe='$hash_cpe',hash_cdr='$hash_cdr',msj_sunat='$msj_sunat',archivo='$archivo' WHERE idventa='$id'";
              ejecutarConsulta($sql);
            }
             
            else
            {
              $sql="UPDATE enviosunat SET estadoenvio='1',respuesta='$respuesta',cod_sunat='0000',hash_cpe='$hash_cpe',hash_cdr='$hash_cdr',msj_sunat='$cod_sunat',archivo='$archivo' WHERE idventa='$id'";
              ejecutarConsulta($sql);
            }

            //var_dump($data);
           // var_dump($resultado);
            
            
            
            /*=====  End of ACTUALIZAR ENVIO SUNAR SI RESP = OK  ======*/
            
/*

            echo "=========== DATA RETORNO =============== ";
            echo "<br /><br />respuesta : ".$response['respuesta'];
            echo "<br /><br />url_xml   : ".$response['ruta_xml'];
            echo "<br /><br />hash_cpe  : ".$response['hash_cpe'];
            echo "<br /><br />hash_cdr  : ".$response['hash_cdr'];
            echo "<br /><br />msj_sunat : ".$response['msj_sunat'];
            echo "<br /><br />ruta_cdr  : ".$response['ruta_cdr'];
            echo "<br /><br />ruta_pdf  : $ruta_cdr_base".$response['ruta_pdf'];
        */
         $respta=true;
         
         if($respuesta=='ok')
         {
             
             $respta=true;
             
         }
         else
         {
             $respta=false;
         }
         
         
          
          
            
           var_dump($msj_sunat." - ".$cod_sunat);
          // var_dump($data);

           return $respta;
                     
            

        }


    }
    








