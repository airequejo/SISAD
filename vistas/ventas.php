<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['ingresos'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li><a type="button" class="breadcrumb-item btn  btn-secondary btn-xs" href="listaventa"><b><i class="fas fa-list-ol"></i> Lista ventas  </b></a></li>  
              <li><a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="location.reload();" >
                  <b><i class="fas fa-cart-plus"></i> Nueva venta </b></a></li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
  <section class="content">   
    <div class="container-fluid">
      <div class="row">  

        <div class="col-lg-12">
          <div class="card card-success">
            
            <div class="card-body">
            <form name="productos_insert" id="productos_insert" method="POST">
              <div class="row">              
              
                <div class="col-lg-5">
                  <label>Producto / servicio</label> <a data-toggle="modal" href="#productos" class="btn btn-info btn-xs">  (F4)</a>
                  <div class="form-group">
                  <!-- <input type="hidden" class="form-control" id="codigobarra" mane="codigobarra" onkeyup="" placeholder="Código"> -->
                          <input type="hidden" class="form-control" name="vencimiento" id="vencimiento" style="border: 1px solid orange; border-radius: 5px;" data-format="dd/MM/yyyy" min="<?php echo date("Y-m-d",strtotime($fecha_vence.' +1 days'));?>" readonly>
                    <select name="codigobarra" id="codigobarra" class="form-control" style="width: 100%;">

                    </select>
                          <!--  <span id="des_producto" class="text ">POLO DEPORTIVO </span> -->
                    <input type="hidden" id="idproducto" name="idproducto">
                    <input type="hidden" class="form-control" name="lote" id="lote" style="border: 1px solid orange; border-radius: 5px;" readonly="">
                    <input type="hidden" class="form-control"  id="idindex" name="idindex" readonly>
                    <input type="hidden" class="form-control"  id="precio_compra_promedio" name="precio_compra_promedio" readonly>              
                    
                    
                  </div>
                </div>

                <!-- <div class="col-lg-2">
                  <div class="form-group"> 
                  <input type="checkbox"  data-toggle="toggle" checked  data-size="sm" data-onstyle="secondary" data-offstyle="danger" data-on="Desc" data-off="Cod">
                  </div>
                </div> -->

                <div class="col-lg-2">
                  <div class="form-group">                   
                    <label id="canti">Periodo</label>
                    <select name="idperiodo" id="idperiodo" class="form-control">
                    
                    </select>
                  </div>
                </div>

                <div class="col-lg-1">
                  <div class="form-group">                   
                    <label id="canti">Cantidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad" min="1"  value="1">
                  </div>
                </div>

                <div class="col-lg-1">
                  <div class="form-group">   
                    <label id="prec" >Stock</label>                
                    <input type="text" class="form-control" name="stock" id="stock" readonly>
                    
                  </div>
                </div>

                <div class="col-lg-2">
                  <div class="form-group">                   
                    <label id="prec" >Precio</label>
                    <input type="text" class="form-control" name="precio" id="precio" readonly >
                    <input type="hidden" class="form-control" name="descuento" id="descuento"   value="0.00" readonly>
                  </div>
                </div>

                <div class="col-lg-1">
                  <div class="form-group">  
                    <label> </label> <br>
                    <button type="button" id="valida" onclick="insert_ventas_temp();" class="btn btn-secondary btn-block btn-flat">(F2)</button> 
                  </div>
                </div>

</form>

                
                  <div class="card-body table-responsive p-0" style="height: 300px;">
                    <table id="detalles_venta" class="table table-bordered  table-head-fixed text-nowrap table-sm">              
                      <thead >
                          <th class="bg-secondary">#</th>
                          <th class="bg-secondary">Producto</th>
                          <th class="bg-secondary">Periodo</th>
                          <th class="bg-secondary">Cantidad</th>
                          <th class="bg-secondary">Precio</th>
                          <th class="bg-secondary">Sub Total</th>
                          <th class="bg-secondary">Opcion</th>
                        </thead>

                        <tbody>  
                         <!--<tr>
                            <th scope="row">1</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>  
                            <tr>
                            <th scope="row">2</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr> 
                          <tr>
                            <th scope="row">3</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr> 
                          <tr>
                            <th scope="row">4</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>  
                          <tr>
                            <th scope="row">5</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr> 
                          <tr>
                            <th scope="row">6</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <th scope="row">7</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>  -->
                          
                                    
                        </tbody>              
                    </table>                    
                  </div>

                
                  <div class="col-lg-4 md-12 p-0 ">
                    <div class="form-group">  
                      <label> </label> <br>
                      <button class="btn btn-info  btn-block btn-flat btn-lg" onclick="validar_modal();"  type="button"><h3> (F8) = Facturar</h3></button>
                    </div>
                  </div>

                  <div class="col-lg-6 p-0">
                    <div class="form-group">  
                      <label> </label> <br>
                      <button type="button" class="btn btn-lg btn-outline-primary btn-block btn-flat"> <h3>Total</h3></button> 
                    </div>
                  </div>

                  <div class="col-lg-2 p-0">
                    <div class="form-group">  
                      <label> </label> <br>
                      <button type="button" class="btn btn-lg btn-secondary btn-block btn-flat"><h3 id="total_operacion"> 00.00</h3></button>
                    </div>
                  </div>
              
                

              </div>
            </div>
        </div>
          </div>  
        </div>

    </div>  
  </section>
  
</div>

<!--  modal  -->

<div class="modal fade" id="productos" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Ventas sin procesar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
        <div class="input-group col-lg-12">
              <select name="idlista_index" id="idlista_index" style="width: 85%;" class="form-control"></select>
                <div class="input-group-append">
                <button id="eliminatemporal" class="btn btn-danger btn-xs" onclick="eliminar_detalle_venta_temp();"> Eliminar</button>
                </div>
              </div>

          </div>

            

         
      </div>
    </div>
  </div>

<



<!---  INICIO MODAL   ---> 
<div class="modal fade" id="modal_facturar" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="">Facturación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="procesar_venta_modal" id="procesar_venta_modal"  method="POST">  


            <div class="row">

          
            <div class="col-lg-8 col-xs-12 ">      
                  <div class="form-group">
                       <label for="descripcio">CLIENTE </label>
                    <div class="input-group">
                    <select  id="idcliente" name="idcliente"  class="form-control" style="width: 85%; "></select>
                       <input type="hidden" class="form-control"  id="idindex_venta" name="idindex_venta" readonly>
                      <div class="input-group-append">
                          <a type="button" class="btn btn-info btn-xs " data-toggle="modal"  href="#myModal"><i class="fas fa-user-check"></i> Nuevo</a>
                      </div>
                    </div>
                  </div>
            </div>

            <div class="col-lg-4 col-xs-12">      
              <div class="form-group">
                  <?php 
                      date_default_timezone_set("America/Lima");    
                      $fecha=date('Y-m-d H:i:s');                                              
                    ?>
                    <label>FECHA VENTA</label>
                <input type="datetime" class="form-control" readonly name="fecha" id="fecha" required="" data-format="dd/MM/yyyy hh:mm:ss" min="<?php echo date("Y-m-d H:i:s",strtotime($fecha.'- 5 days'));?>" max="<?php echo $fecha; ?>" value="<?php echo $fecha; ?>"> 
              </div>  
            </div>

            <div class="col-lg-4 col-xs-12">      
              <div class="form-group">
                  <label>DIRECCION</label>
                  <select name="iddireccion" id="iddireccion" class="form-control"required="required">
                  </select>
              </div>
            </div>

            <div class="col-lg-4 col-xs-12">      
              <div class="form-group">
                  <label>ESPECIALIDAD</label>
                  <select name="idespecialidad" id="idespecialidad" class="form-control"required="required">
                  </select>
              </div>
            </div>

            <div class="col-lg-4 col-xs-12">      
              <div class="form-group">
                  <label>CICLO</label>
                  <select name="idciclo" id="idciclo" class="form-control"required="required">
                  </select>
              </div>
            </div>

                <div class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                    <label>COMPROBANTE</label>
                    <select name="idtipocomprobante" id="idtipocomprobante" class="form-control"required="required">

                    </select>
                  </div>  
                </div>

                <div class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                      <label>TIPO VENTA</label>
                      <select name="tipoventa" id="tipoventa" class="form-control" required>
                        <option value="-" selected="selected">SELECCIONE</option>
                        <option value="1">CONTADO</option>
                         <option value="2">CREDITO</option> 
                      </select>
                  </div>  
                </div>

                <div  id="forma_p" class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                    <label id="">FORMA DE PAGO</label>
                    <select name="idformapago" id="idformapago" class="form-control"  required>
                    </select>
                  </div>  
                </div>

                <div id="monto_a"  class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                    <label class="text-green"> MONTO ABONADO</label>
                    <input type="text" class="form-control" name="montoabonado" id="montoabonado" onkeypress="return soloNumeros(event);" >
                  </div>  
                </div>

                <div id="monto_op" class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                  <label class="text-green"> OPERACIÓN</label>
                  <input type="text" class="form-control" name="operacion" id="operacion"  placeholder="Número de operación">
                  </div>  
                </div>  
                
                <div id="fecha_op" class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                  <?php 
                      date_default_timezone_set("America/Lima");    
                      $fechao=date('Y-m-d');                                              
                    ?>
                  <label class="text-green"> FECHA OPERACIÓN</label>
                  <input type="date" class="form-control" name="fechaoperacion" id="fechaoperacion" data-format="dd/MM/yyyy hh:mm:ss" max="<?php echo $fechao; ?>" value="<?php echo $fechao; ?>">
                  </div>  
                </div>  
                
                <div id="vencecredito"  class="col-lg-4 col-xs-12">      
                  <div class="form-group">
                  <?php 
                        date_default_timezone_set("America/Lima");    
                        $fechac=date('Y-m-d');                                        
                      ?>
                  <label class="text-green"> FECHA VENCIMIENTO CRÉDITO</label>
                  <input type="date" class="form-control"  name="fecha_vencimiento" id="fecha_vencimiento" data-format="dd/MM/yyyy" min="<?php echo date("Y-m-d",strtotime($fechac.' 1 days'));?>"  value="<?php echo date("Y-m-d",strtotime($fechac.' 1 days'));?>">
                  </div>  
                </div> 

                <div id="igvdesc">

                  <div id="vencecredito"  class="col-lg-4 col-xs-12">      
                    <div class="form-group">
                      <label>DESC:</label>
                      <input type="text" class="form-control" name="descuentogeneral" id="descuentogeneral" required="" value="0.00" readonly>
                    </div>  
                  </div> 

                  <div id="vencecredito"  class="col-lg-4 col-xs-12">      
                    <div class="form-group">
                      <label>IGV:</label>
                      <input type="text" class="form-control" readonly="" name="igv" id="igv" required="">
                    </div>  
                  </div> 
                            
                </div>
            </div>

             <div class="row" id="vuelt"> 

                <div id="vencecredito"  class="col-lg-8 col-xs-12">      
                    <div class="form-group  text-orange">
                      <label>Monto Recibido S/</label>
                      <input type="text" class="form-control" name="efectivo" id="efectivo" required="">
                    </div>  
                </div>

                <div id="vencecredito"  class="col-lg-4 col-xs-12">      
                    <div class="form-group text-orange">
                      <label>Vuelto</label>
                      <input type="text" class="form-control" name="vuelto" id="vuelto" readonly>
                    </div>  
                </div>
                </div> 

                <div class="col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-money-bill-alt"></i></span>
                    <div class="info-box-content bg-info"> 
                    <span class="info-box-text">S/ </span>
                      <b><span class="info-box-text" style="font-size: 3em;" id="total_factura"> 0.00</span></b>
                    </div>
                  </div>
                </div>
                           
             

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardar_modal" class="btn btn-info"><i class="fas fa-check" aria-hidden="true"></i> Grabar Venta</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->



<!---  INICIO MODAL   ---> 
<!-- Modal secondary -->
<div class="modal fade" id="myModal" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Registrar Cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="formulario_modal" id="formulario_modal" method="POST">  

            <div class="row">

            <div class="col-lg-6 col-xs-12">
                  <div class="form-group">
                    <label>TIPO DE DOCUMENTO</label>
                    <select id="tipodocumento" name="tipodocumento" class="form-control" required>
                      <option value='0'>NO DOMICILIADO(OTROS)</option>
                      <option value='6'>RUC</option>
                      <option value='1' selected>DNI</option>
                      <option value='4'>CARNET EXTRANJERIA</option>
                      <option value='7'>PASAPORTE</option>
                      <option value='A'>CED. DIPLOMATICA DE IDENTIDAD</option>

                    </select>
                  </div>               
                </div>

                <div class="col-lg-6 col-md-12">      
                  <div class="form-group">
                  <label for="descripcio">NÚMERO <a class="text-red" href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank"> (SUNAT AQUI)</a></label>
                  <div class="input-group col-lg-12">                 
                    <input type="text"  class="form-control" id="dniruc" name="dniruc" maxlength="11" onkeypress="return soloNumeros(event);" required placeholder="N° Documento">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-primary search_document" name="buscar_cli"  id="buscar_cli" title="Buscar"><i class="fa fa-search" id="icon_search_document" aria-hidden="true"></i><i class="fa fa-spinner fa-spin fa-fw" spinner position-left style="display: none;" id="icon_searching_document"></i></button> 
                    </div>
                  </div>
                  </div>  
                </div>


                <div class="col-lg-12 col-md-12">      
                  <div class="form-group">
                    <label>NOMBRES</label>
                    <input type="hidden" class="form-control" id="idclientex" name="idclientex">
                  <input type="text"  class="form-control" id="nombre" name="nombre" required placeholder="Nombre..." onkeyup = "this.value=this.value.toUpperCase()">
                  </div>  
                </div>

                <div id="divdistrito"  class="col-lg-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">DITRITO</label>
                    <select id="ubigeo" name="ubigeo" class="form-control selectpicker" data-live-search="true">
                    </select>
                  </div>
                </div>

                <div id=""  class="col-lg-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">LOCALIDAD</label>
                    <input type="text"  class="form-control" id="referencia" name="referencia" placeholder="Localidad"  onkeyup = "this.value=this.value.toUpperCase()">
                  </div>
                </div>

                <div id="divdireccion" class="col-lg-12 col-md-12">
                  <div class="form-group">
                    <label for="cod">DIRECCIÓN</label>
                    <input type="text"  class="form-control" id="direccion" name="direccion"  placeholder="Dirección" onkeyup = "this.value=this.value.toUpperCase()">
                  </div>
                </div>

                <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">CELULAR</label>
                    <input type="text"  class="form-control" id="celular" name="celular" maxlength="9" onkeypress="return soloNumeros(event);" placeholder="Celular">
                  </div>
                </div>

                <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">CORREO</label>
                    <input type="text"  class="form-control" id="email" name="email" placeholder="email">
                  </div>
                </div>


              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button"  id="btnGuardar_modal_cliente" onclick="guardaryeditar_cliente();" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->


  


  <?php } else {require 'noacceso.php';}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/ventas.js"></script>
<script type="text/javascript" src="scripts/cliente_modalls.js"></script>

<?php
}
ob_end_flush();
?>


