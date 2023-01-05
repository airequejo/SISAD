
<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['ctscobrar'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
              <!-- <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="nuevo();" >
                  <b><i class="fas fa-user-plus"></i> Nuevo producto</b></a> -->
                
              </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Gestionar compromisos de pago</h3>

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

        <div class="col-xl-6 col-md-12">      
                  <div class="form-group">
                    <!-- <label>BUSCAR POR NOMBRES O DNI DEL ALUMNO(A)</label> -->
                    <select name="idcliente" id="idcliente" class="form-control">
                            
                    </select>
                  </div>  
                </div>

             
          <table id="example" class="table table-bordered table-striped">
            <thead>
            <tr>
            <th>#</th>
            <th>COMPROBANTE</th>
            <th>FECHA COMPROMISO PAGO</th>
            <th>TOTAL COMPROBANTE</th>
            <th>ABONO</th>
            <th>DEUDA INICIAL</th>
            <th>DEUDA ACTUAL</th>
            <th>F.VENCIMIENTO</th>
            <th>CONDICIÓN</th>
            <th>ESTADO</th>
            <th>OP</th>
            </tr>
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
 
  <div class="modal fade" id="modal_pagar_credito_ingreso" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Registro de pagos de compromisos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="procesar_credito_modal" id="procesar_credito_modal" method="POST">   

            <div class="row">

            <div class="col-lg-8 col-md-12">      
                <div class="form-group">
                    <label>CLIENTE :</label>
                    <h4 class="text-blue" id="nombres"></h4 class="text-blue">
                </div>  
            </div>

            <div class="col-lg-4 col-md-12">      
                <div class="form-group">
                    <?php 
                        date_default_timezone_set("America/Lima");
                        $fecha=date('Y-m-d H:i:s');                    
                    ?>
                        <label>Fecha de pago</label>
                        <input type="datetime" class="form-control" readonly name="fechapago" id="fechapago" required=""  min="<?php echo date("Y-m-d H:i:s",strtotime($fecha.'- 5 days'));?>" max="<?php echo $fecha; ?>" value="<?php echo $fecha; ?>"> 
                </div>  
            </div>

            
            

            <div class="col-lg-3 col-md-12">      
                <div class="form-group">
                    <label>Total Comprobante:</label>
                    <h4 class="text-blue" id="totalventa"></h4 class="text-blue">
                </div>  
            </div>

            <div class="col-lg-3 col-md-12">      
                <div class="form-group">
                    <label>Pago Adelantado: </label>
                    <h4 class="text-blue" id="montoabonado"></h4 class="text-blue">
                </div>  
            </div>

            <div class="col-lg-3 col-md-12">      
                <div class="form-group">
                    <label>Monto Credito: </label>
                    <h4 class="text-blue" id="monto_credito"></h4 class="text-blue">
                </div>  
            </div>

            <div class="col-lg-3 col-md-12">      
                <div class="form-group">
                    <label>Deuda actual: </label>
                    <h3 class="text-orange" id="deuda_actual"></h3 class="text-blue">
                    <input type="hidden" id="deuda_a" name="deuda_a">
                </div>  
            </div>

             <div class="col-lg-6 col-md-12">
                <div class="form-group">
                    <label>Forma de pago</label>
                    <input type="hidden" id="idcredito" name="idcredito">
                    <select name="idformapago" id="idformapago" class="form-control"required="required">
                        <option value="2" selected>DEPOSITO CUENTA INSTITUCIONAL</option> 
                    </select>
                </div>
            </div> 

            <div id="" class="col-lg-3 col-xs-12">      
                  <div class="form-group">
                  <?php 
                      date_default_timezone_set("America/Lima");    
                      $fechao=date('Y-m-d');                                              
                    ?>
                  <label class="text-green"> FECHA OPERACIÓN</label>
                  <input type="date" class="form-control" name="fechaoperacion" id="fechaoperacion" data-format="dd/MM/yyyy hh:mm:ss" max="<?php echo $fechao; ?>" value="<?php echo $fechao; ?>">
                  </div>  
                </div> 

            <div id="" class="col-lg-3 col-xs-12">      
                  <div class="form-group">
                  <label class="text-green"> OPERACIÓN</label>
                  <input type="text" class="form-control" name="operacion" id="operacion"  placeholder="Número de operación">
                  </div>  
              </div>  
                
                

            <div class="col-lg-3 col-md-12">      
                <div class="form-group">
                    <label>Monto a Pagar S/</label>
                    <input type="decimal" class="form-control" id="monto" name="monto" placeholder="Ingrese monto">
                </div>  
            </div>

            </div>

            </div>

            <div class="modal-footer">
              <button type="button"  class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button" id="btnGuardar_modal" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->



<!---  INICIO MODAL   --->
 
<div class="modal fade" id="modal_detalle_pagos" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="staticBackdropLabel">Detalle de pagos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form name="detallepagos" id="detallepagos" method="POST"> 
            <div class="modal-body">            

                <div class="row table-responsive">

                    <table id="tb_detalle_pagos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Comprobante</th>
                                <th>Fecha Pago</th>
                                <th>Monto S/</th>
                                <th>OP</th>
                            </tr>
                        </thead>

                        <tbody>      
                        </tbody>            
                    </table>    

                </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->




<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/gestionarcompromisos.js"></script>
<?php
}
ob_end_flush();
?>


