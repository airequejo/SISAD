
<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';

    if ($_SESSION['egresos'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li><a type="button" class="breadcrumb-item btn  btn-secondary btn-xs" onclick="mostrarform(false)"><b><i class="fas fa-list-ol"></i> Lista egresos  </b></a></li>  
              <li><a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="mostrarform(true)">
                  <b><i class="fas fa-cart-plus"></i> Nuevo egreso </b></a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

    <div class="card" id="formularioregistros">
      <div class="card-header">
      
      <div class="row">    
        <div class="col-lg-10 col-md-12">
          <div class="form-group">
            <a data-toggle="modal" href="#productos_compra_lita"><button type="button" class="btn btn-info"><i class="fa fa-search-plus" aria-hidden="true"></i> Seleccione un producto o servicio</button></a>                            
          </div>
        </div>

        <div class="col-lg-2 col-md-12">
          <div class="form-group">      
            <select name="idlista_index" id="idlista_index" style="width:100%;"></select>
          </div>
        </div>
        

        <div class="card-body table-responsive p-0" style="height: 350px;">
            <table id="detalles" class="table table-bordered  table-head-fixed text-nowrap table-sm">   
              <thead >
                <th class="bg-secondary">#</th>
                <th class="bg-secondary">IDproducto</th>
                <th class="bg-secondary">Producto</th>
                <th class="bg-secondary">Actividad</th>
                <th class="bg-secondary">Lote</th>
                <th class="bg-secondary">Vencimiento</th>
                <th class="bg-secondary">Cantidad</th>
                <th class="bg-secondary">Precio Compra</th>
                <th class="bg-secondary">Precio Venta</th>    
                <th class="bg-secondary">Sub Total</th>
                <th class="bg-secondary">Opcion</th>
              </thead>
              <tbody>                            
              </tbody>        
            </table>
        </div>

        

      </div>
      <div class="row">
                <div class="col-lg-4 md-12 p-0 ">
                    <div class="form-group">  
                      <label> </label> <br>
                      <button class="btn btn-info btn-block btn-flat btn-lg" data-toggle="modal" href="#modal_facturar_compra"  type="button"><h3> (F8) = Facturar</h3></button>
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

      <!-- Default box -->
      <div class="card" id="listadoregistros">
        <div class="card-header">
          <h3 class="card-title">Listado de egresos</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body">

          
        <!-- INICIO AREA DE TRABAJO  --> 

             
        <table id="tblistado_egresos" class="table table-bordered table-striped">
              <thead>
              <th>#</th>
              <th>Opciones</th>
              <th>Fecha</th>
              <th>Proveedor</th>
              <th>Registró</th>
              <th>Documento</th>
              <th>Número</th>
              <th>Total</th>
              <th>Estado</th>
              </thead>

            <tbody>
            
            </tbody>
            
          </table>             

        <!-- FIN AREA DE TRABAJO  -->


        </div>
       
      </div>


     </section>
  
  </div>


<!---  INICIO MODAL   --->
<div class="modal fade" id="productos_compra_insertar" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Agregar producto o servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="formulario" id="formulario" method="POST">   

            <div class="row">

                              <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                    <label>COD</label>
                                          <input type="hidden" class="form-control"  id="idindex" name="idindex" readonly>
                                          <input type="text" class="form-control" id="idproducto" name="idproducto" readonly>  
                                          <input type="hidden" id="protipo">  
                                          <input type="hidden" id="proexpira">   
                                          <input type="hidden" id="promovi">    
                                      </div>
                                  </div>

                                  <div class="col-lg-8 col-xs-12">
                                    <div class="form-group">
                                      <label>PRODUCTO</label>
                                      <br>
                                     <span class="text-red" id="desproducto" ><p>Descripción del Producto<p></span>
                                   </div>
                                  </div>

                                  <div class="col-lg-12 col-xs-12">
                                    <div class="form-group">
                                      <label>GASTO - ACTIVIDAD</label>
                                      <select name="idactividad" id="idactividad" class="form-control" required>
                                                             
                                      </select>
                                   </div>
                                  </div>

                                            
                          

                                      <div id="iganancia" class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label id="prec" >UTILIDAD%</label>
                                            <input type="text" class="form-control" name="ganancia" id="ganancia"  value="35">
                                        </div>
                                      </div>

                                      <div id="ilote"class="col-lg-3 col-xs-12">
                                        <div class="form-group">
                                            <label>LOTE</label>
                                            <input type="text" class="form-control" name="lote" id="lote" >
                                        </div>
                                      </div>

                                      <div id="iregistro" class="col-lg-3 col-xs-12">
                                        <div class="form-group">
                                            <label>REG SANT.</label>
                                            <input type="text" class="form-control" name="registrosanitario" id="registrosanitario" >
                                        </div>
                                      </div>

                                      <div id="ivencimiento" class="col-lg-6 col-xs-12">
                                        <div class="form-group">
                                            <label>VENCIMIENTO</label>
                                            <input type="date" class="form-control" name="vencimiento" id="vencimiento"  data-format="dd/MM/yyyy" min="<?php echo date("Y-m-d",strtotime($fecha_vence.' +1 days'));?>">
                                        </div>
                                      </div>


                                   <div class="col-lg-6 col-xs-12">
                                      <div class="form-group">
                                        <label id="canti">CANTIDAD</label>
                                        <input type="text" class="form-control" name="cantidad" id="cantidad" >
                                      </div>
                                   </div>
                                  

                                   <div class="col-lg-6 col-xs-12">
                                      <div class="form-group">
                                      <label id="prec" >PRECIO.U</label>
                                      <input type="text" class="form-control" name="precio" id="precio" >
                                  </div>
                                   </div>

                                  

                                      <div id="ivalor" class="col-lg-6 col-xs-12">
                                          <div class="form-group">
                                              <label id="canti">VALOR TOTAL</label>
                                              <input type="text" class="form-control" name="valor" id="valor" >
                                          </div>  
                                      </div>                             

                                      <div id="idescuento" class="col-lg-6 col-xs-12">
                                          <div class="form-group">
                                              <label>PRECIO.V</label>
                                              <input type="hidden" class="form-control" name="descuento" id="descuento"   value="0.00"><br>
                                            
                                              <input type="text" class="form-control" name="precioventa" id="precioventa" >
                                          </div>
                                      </div>

                                  

                        </div>

                        </div>

                    <div class="modal-footer">
                      <button  type="button" id="valida" onclick="salir_modal();" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                      <button type="button" id="valida" onclick="yala();" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
                    </div>

          </form> 
      </div>
    </div>
</div>
<!--- FIN MODAL  -->


<!---  INICIO MODAL   --->
<div class="modal fade" id="productos_compra_lita" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Lista de Productos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="productos_lista" id="productos_lista" method="POST">   
            <div class="row">
              <table id="tblarticulos_compra" class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Divisionaria</th>
                    <th>#</th>
                </thead>
                <tbody>

                </tbody>

              </table>    

            </div>

          </form> 
        </div>
      </div>
    </div>
</div>

<!--- FIN MODAL  -->

<!---  INICIO MODAL   ---> 
<div class="modal fade" id="modal_facturar_compra" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="">Facturación</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="procesar_compra_modal" id="procesar_compra_modal"  method="POST">  
        <div class="modal-body">
       
            <div class="row">
                        <div class="form-group  col-lg-6 col-md-6 col-sm-12 col-xs-12">
                              <label>PROVEEDOR</label>

                              <input type="hidden" name="idcompra" id="idcompra" >

                                <input type="hidden" class="form-control"  id="idindex_p" name="idindex_p" readonly>
                              <select id="idproveedor" name="idproveedor" class="form-control"  style="width:100%;" required>
                                
                              </select>
                        </div>

                          <div class="form-group  col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <?php 
                          date_default_timezone_set("America/Lima");    

                          $fecha=date('Y-m-d'); 

                          $fecha_vence=date('Y-m-d'); 

                           ?>


                            <label>FECHA</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" style="border-radius: 5px;" required data-format="dd/MM/yyyy";?>" max="<?php echo $fecha; ?>" value="<?php echo date('Y-m-d'); ?>">
                          </div>


                          <div class="form-group  col-lg-3 col-md-3 col-sm-3 col-xs-12">
                            <label>COMPROBANTE</label>
                            <select name="tipocomprobante" id="tipocomprobante" class="form-control"  style="border-radius: 5px;" required>
                            
                            </select>
                          </div>

                          <div class="form-group  col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>SERIE COMPROB</label>
                            <input type="text" class="form-control" name="serie" id="serie" maxlength="7" placeholder="Serie" style="border-radius: 5px;" required>
                          </div>

                          <div class="form-group  col-lg-2 col-sm-12 col-xs-12">
                            <label>N° COMPROB</label>
                            <input type="text" class="form-control" name="numero" id="numero" maxlength="10" placeholder="Número" style="border-radius: 5px;" required>
                          </div>

                        

                          <div id="tipo_compra"  class="form-group  col-lg-2  col-sm-2 col-xs-12">
                             <label>TIPO COMPRA (NO VA)</label>
                            <select type="hidden" name="tipocompra" id="tipocompra" class="form-control" style="border-radius: 5px;" required>
                              <option value="1" selected="selected">CONTADO</option>
                              <option value="2">CREDITO</option>                       
                            </select>
                          </div>

                         
                          <div id="forma_p" class="form-group  col-lg-2  col-sm-12 col-xs-12">
                            <label>FORMA DE PAGO</label> 
                            <select name="idformapago" id="idformapago" class="form-control" style="border-radius: 5px;" required>
                            <option value="">CHEQUE</option>
                            </select>
                          </div>

                          <div id="" class="form-group  col-lg-2  col-sm-12 col-xs-12">
                            <label>N° CHEQUE</label> 
                            <input type="text" id="numerocheque" name="numerocheque" class="form-control" placeholder="N° de cheque" required>
                          </div>

                          <div id="" class="form-group  col-lg-4 col-sm-12 col-xs-12">
                            <label>CONCEPTO</label> <!--  (CONCEPTOS TB) -->
                            <select name="idconceptocp" id="idconceptocp" class="form-control" style="border-radius: 5px;" required>
                            <option value="2"> PAGO A PROVEDORES </option>
                            </select>
                          </div>

                          <div id="forma_p" class="form-group  col-lg-3 col-sm-12 col-xs-12">
                            <label>NUMERO CP</label> 
                            <input type="text" id="numerocp" name="numerocp" class="form-control" required placeholder="NÚMERO CP">
                          </div>

                          <div class="form-group  col-lg-3 col-sm-12 col-xs-12">
                              <?php 
                                date_default_timezone_set("America/Lima");    

                                $fecha=date('Y-m-d'); 

                                $fecha_vence=date('Y-m-d'); 

                              ?>
                            <label>FECHA CP</label>
                            <input type="date" class="form-control" name="fechacp" id="fechacp" style="border-radius: 5px;" required data-format="dd/MM/yyyy" min="<?php echo date("Y-m-d",strtotime($fecha.'- 5 days'));?>" max="<?php echo $fecha; ?>" value="<?php echo date('Y-m-d'); ?>">
                          </div>

                          <div id="forma_p" class="form-group  col-lg-4 col-sm-12 col-xs-12">
                            <label>DOC. AUTORIZA</label> 
                            <input type="text" id="documentoautoriza" name="documentoautoriza" class="form-control" required placeholder="">
                          </div>


                         

                          
                          <div id="monto_a"  class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                           <label> Monto abonado</label>
                            <input type="decimal" class="form-control" name="montoabonado" id="montoabonado"  placeholder="Monto Abonado" value="0.00">
                          </div>

                          <div id="monto_op"  class="form-group col-lg-2 col-md-2 col-sm-12 col-xs-12">
                           <label> Operación</label>
                            <input type="text" class="form-control" name="operacion" id="operacion"  placeholder="Número de operación">
                          </div>

                          
                         

                          <div id="vencecredito" class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <?php 
                              date_default_timezone_set("America/Lima");    

                              $fechac=date('Y-m-d');  
                                                
                               ?>
                            <label>Fecha vencimiento credito</label>
                              <input type="date" class="form-control"  name="fecha_vencimiento" id="fecha_vencimiento" data-format="dd/MM/yyyy" min="<?php echo date("Y-m-d",strtotime($fechac.' 1 days'));?>"  value="<?php echo date("Y-m-d",strtotime($fechac.' 1 days'));?>"> 

                          </div>


          
                           <!-- <div class="form-group   col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>DESC. GENERAL</label required>
                            
                          </div> -->
                          
                        <div id="moneda" class="form-group   col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>MONEDA</label>
                            <input type="hidden" class="form-control" name="montodscto" id="montodscto" value="0.00" style="border-radius: 5px;">
                            <select class="form-control" name="tipomoneda" id="tipomoneda" style="border-radius: 5px;" required>
                                <option>NACIONAL</option>
                                <option>EXTRANJERA</option>
                                </select>
                          </div>
                          <div id="cambio" class="form-group   col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <label>CAMBIO</label>
                            <input type="text" class="form-control" name="tipocambio" id="tipocambio" value="0" style="border-radius: 5px;" required>
                          </div>

                          <div class="form-group   col-lg-2 col-sm-12 col-xs-12">
                            <label>IGV</label>
                            <input type="text" class="form-control" name="igv" id="igv" value="0" style="border-radius: 5px;" required>
                          </div> 

                          <div class="form-group   col-lg-12 col-sm-12 col-xs-12">
                          <label>Observación</label><br>
                              <textarea name="observacion" class="form-control" id="observacion" cols="30" rows="2"></textarea>
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
            <button type="button" id="btnsalir" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-check" aria-hidden="true"></i>
                      | Cancelar</button>
            <button type="button" id="btnGuardar" onclick="guardaryeditar();"	 class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>
                      | Procesar </button>
                
              </div>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->





<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/compra.js"></script>
  
<?php
}
ob_end_flush();
?>


