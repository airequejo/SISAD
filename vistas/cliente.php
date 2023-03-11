
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
            <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="valida_tipo_modal();" >
                  <b><i class="fas fa-user-plus"></i> Nuevo cliente </b></a>
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
          <h3 class="card-title">Listado de clientes xxxxxx</h3>

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

             
          <table id="clienteListado" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Estado</th>
              <th>#</th>
              <th>Nombre</th>
              <th>Dni Ruc</th>
              <th>Dirección</th>
              <th>Celular</th>
              <th>Opciones</th>
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
<!-- Modal secondary -->
  <div class="modal fade" id="mymodal" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="titulo_modal">Titulo Modal</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <form name="formulario" id="formulario" method="POST">  

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
                    <input type="hidden" class="form-control" id="idcliente" name="idcliente">
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

                <div id="divreferencia"  class="col-lg-6 col-md-12">
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

                <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">CELULAR</label>
                    <input type="text"  class="form-control" id="celular" name="celular" maxlength="9" onkeypress="return soloNumeros(event);" placeholder="Celular">
                  </div>
                </div>

                <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                    <label for="cod">CORREO</label>
                    <input type="text"  class="form-control" id="email" name="email" placeholder="email">
                  </div>
                </div>


              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="button"  onclick="guardaryeditar();" id="btnGuardar" id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->


<?php } else {require 'noacceso.php';}

    require 'footer.php';
?>
  <script type="text/javascript" src="scripts/clientes.js"></script>

<?php
}
ob_end_flush();
?>


