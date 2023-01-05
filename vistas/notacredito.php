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
              <li class="breadcrumb-item active"><a type="button" href="venta" >Regresar</a></li>
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
          <h3 class="card-title">REGISTRO NOTA DE CREDITO</h3>

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
        <form name="formulario" id="formulario" method="POST">
          
        <div class="row">

          <div class="col-lg-6 col-md-12">
            <div class="form-group">
            <label for="cod">EMITIR</label>
                  <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $_GET["id"]; ?> ">
                 <!-- <input type="text" class="form-control" id="descripcionmotivo" name="descripcionmotivo">-->
                  <select name="idcomprobantenc" id="idcomprobantenc" class="form-control" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="7">Nota de Crédito</option>
                                          </select>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
            <div class="form-group">
                <label for="descripcio">MOTIVO</label>
                  <select name="idmotivo" id="idmotivo" class="form-control" required="required" onchange="llenar();">
                                            <option value="">Seleccione</option>
                                            <option value="01">ANULACION DE LA OPERACION</option>
                                           <!--  <option value="02">ANULACION POR ERROR EN EL RUC</option>
                                            <option value="03">CORRECCCION POR ERROR EN LA DESCRIPCION</option>
                                            <option value="04">DESCUENTO GLOBAL</option>
                                            <option value="05">DESCUENTO POR ITEM</option>
                                            <option value="06">DEVOLUCION TOTAL</option>
                                            <option value="07">DEVOLUCION POR ITEM</option>
                                            <option value="08">BONIFICACION</option>
                                            <option value="09">DISMINUCION EN EL VALOR</option> -->
                                          </select>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="form-group">
                  <label for="descripcionmotivo">DESCRIPCIÓN MOTIVO</label>
                  <input type="text" class="form-control" id="descripcionmotivo" name="descripcionmotivo" readonly>
              </div>
            </div>


          </div>

          <div class="box-footer">
                <div class="form-group  col-xs-12 col-sm-12 col-md-12">
                 <button type="button" id="btnGuardar_nota_credito" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i>
                      | GRABAR</button>
                  <button  type="button" onclick="cancelarform()" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i>
                      | CANCELAR</button>
                </div>
              </div>

        </div>
</form>



        </div>
       
      </div>

     </section>
  
  </div>
 




  <?php } else {require 'noacceso.php';}

require 'footer.php';
?>
<script type="text/javascript" src="scripts/notacredito.js"></script>
<?php
}
ob_end_flush();
?>







