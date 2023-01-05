
<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['productos'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">
              <a type="button" class="breadcrumb-item btn  btn-info btn-xs" onclick="nuevo();" >
                  <b><i class="fas fa-user-plus"></i> Nuevo producto</b></a>
                
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
          <h3 class="card-title">Listado de productos</h3>

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

             
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>ESTADO</th>
              <th>#</th>
              <th>TIPO</th>
              <th>DESCRIPCION PRODUCTO</th>
              <th>UNIDAD MEDIDA</th>
              <th>PRECIO COMPRA</th>
              <th>PRECIO VENTAS</th>
              <th>STOCK</th>
              <th>APLICA_MOV</th>
              <th>OPCIONES</th>
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
 
  <div class="modal fade" id="mymodal" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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

              <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label>TIPO BIEN / SERVICIO</label>
                    <select class="form-control" style="width: 100%;" id="tipo" name="tipo" required>
                      <option value="">SELECCIONE</option>
                      <option value="1">SERVICIO</option>
                      <option value="0">BIEN</option>
                    </select>
                  </div>
                </div>

                <div class="col-xl-6 col-md-12">      
                  <div class="form-group">
                    <label>DESCRIPCIÓN DEL PRODUCTO</label>
                    <input type="hidden" name="idproducto" id="idproducto">
                    <input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ingrese descripción del producto" required >
                  </div>  
                </div>

                <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label>UNIDAD DE MEDIDA</label>
                    <select class="form-control" style="width: 100%;" id="idunidadmedida" name="idunidadmedida" >
                                        
                    </select>
                  </div>
                </div>

                <div class="col-xl-6 col-md-12">
                  <div class="form-group">
                    <label>APLICA MOVIMIENTO</label>
                    <select class="form-control" style="width: 100%;" id="aplicamovimiento" name="aplicamovimiento" readonly="readonly">
                      <option value="">SELECCIONE</option>
                      <option value="1">1. APLICA</option>   
                      <option value="0">2. NO APLICA</option>                         
                    </select>
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



<!---  INICIO MODAL   --->
 
<div class="modal fade" id="mymodaldetalle" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xs" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="staticBackdropLabel">Asignar divisionaria</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="formulario_detalle" id="formulario_detalle" method="POST">   

            <div class="row">

                <div class="col-xl-12 col-md-12">      
                  <div class="form-group">
                  <label>NOMBRE PRODUCTO</label> 
                  <input type="hidden" class="form-control" name="idproducto_detalle" id="idproducto_detalle">
                  <h4 class="text-green" id="nombreproducto"><b>Nombre del producto</b></h4>                    
                    <!--<input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Ingrese descripción del producto" required > -->
                  </div>  
                </div>

                <div class="col-xl-12 col-md-12">
                  <div class="form-group">
                    <label>DIVISIONARIA</label>
                    <select class="form-control" style="width: 100%;" id="iddivisionaria" name="iddivisionaria" >
                                        
                    </select>
                  </div>
                </div>

            </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
              <button type="submit" id="btnGuardar_detalle" class="btn btn-info"><i class="fas fa-save"></i> Guardar</button>
            </div>

          </form> 
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->

<!---  INICIO MODAL   --->
 
<div class="modal fade" id="mymodaldetalle_producto" data-backdrop="static"  role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header bg-info"> 
          <h5 class="modal-title" id="iddetalle">Detalle producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form name="formulario_detalle_producto" id="formulario_detalle_producto" method="POST">   
  
              
                <table id="example1_detalle_producto" class="table table-bordered ">
                    <thead>
                    <tr>
                      <th>CUENTA</th>
                      <th>SUBCUENTA</th>
                      <th>DIVISIONARIA</th>
                      <th>PRODUCTO</th>
                      <th>ESTADO</th>
                    </tr>
                    </thead>

                    <tbody>
                    
                    </tbody>
                </table>                                   

          </form> 
        </div>
      </div>
    </div>
  </div>

<!--- FIN MODAL  -->


<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  <script type="text/javascript" src="scripts/productos.js"></script>
<?php
}
ob_end_flush();
?>


