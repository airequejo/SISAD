
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
              <li><a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="cargar_modal();">
                  <b><i class="fas fa-user-plus"></i> Nuevo proveedor</b></a></li>
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
          <h3 class="card-title">Listado de proveedores</h3>

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

             
          <table id="proveedorListado" class="table table-bordered table-striped">
            <thead>
            <tr>
            <th >Estado</th>
            <th >Nombre o Razón</th>
            <th >Dni Ruc</th>
            <th >Dirección</th>
            <th >Celular</th>
            <th >Opciones</th>
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
  <div class="modal fade" id="myModal" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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

                <div class="col-lg-12 col-xs-12">
                  <div class="form-group">
                    <label for="descripcio">DNI / RUC</label>
                    <input type="text"  class="form-control" id="dniruc" name="dniruc" maxlength="11"  required placeholder="DNI / RUC">                   
                  </div>               
                </div>

                <div class="col-lg-12 col-md-12">      
                  <div class="form-group">
                  <label for="cod">NOMBRE / RAZON</label>
                  <input type="hidden" class="form-control" id="idproveedor" name="idproveedor">
                  <input type="text"  class="form-control" id="nombrerazon" name="nombrerazon" required placeholder="Nombre o Razón Social" onkeyup = "this.value=this.value.toUpperCase()">
                  </div>  
                </div>

                <div class="col-xl-12 col-md-12">      
                  <div class="form-group">
                  <label for="descripcio">DIRECCIÓN</label>
                  <input type="text"  class="form-control" id="direccion" name="direccion" required placeholder="Dirección" onkeyup = "this.value=this.value.toUpperCase()">
                  </div>  
                </div>

                <div id=""  class="col-lg-6 col-md-12">
                  <div class="form-group">
                  <label for="descripcio">TELEFONO</label>
                  <input type="text"  class="form-control" id="telefono" name="telefono" maxlength="9" placeholder="Telefono">
                  </div>
                </div>

                <div id=""  class="col-lg-6 col-md-12">
                  <div class="form-group">
                  <label for="descripcio">CELULAR</label>
                  <input type="text"  class="form-control" id="celular" name="celular" maxlength="9"  placeholder="Celular">
                  </div>
                </div>

                <div id="" class="col-lg-6 col-md-12">
                  <div class="form-group">
                  <label for="descripcio">EMAIL</label>
                  <input type="text"  class="form-control" id="email" name="email" placeholder="email">
                  </div>
                </div>
              
       

                <div class="col-lg-6 col-md-12">
                  <div class="form-group">
                  <label for="descripcio">PAGINA WEB</label>
                  <input type="text"  class="form-control" id="paginaweb" name="paginaweb" placeholder="Pagina Web">
                  </div>
                </div>


              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="submit" id="btnGuardar" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->


<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/proveedor.js"></script>
<?php
}
ob_end_flush();
?>

