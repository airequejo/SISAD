
<?php
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
    header('Location: login');
} else {

    require 'header.php';
    if ($_SESSION['reportes'] == 1) { ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">M&oacute;dulo de Reportes</h3>

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
        <div class="row">
        <div class="col-lg-3 col-6">
      <div class="small-box bg-white">
      <div class="inner">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#periodogg" role="tab" aria-controls="home" aria-selected="true"><font color="black">Periodos</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#fechasgg" role="tab" aria-controls="profile" aria-selected="false"><font color="black">Por fechas</font></a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="periodogg" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <label> Periodo</label>
            
              <select name="idperiodogg" id="idperiodogg" class="form-control">
                <option value="">Seleccione</option>
                <option value="1">2023-I</option>
                
              </select>
              <button class="btn btn-primary" onclick="mostrarperiodogasto();">Ver</button>
            </div>
            <div class="tab-pane fade" id="fechasgg" role="tabpanel" aria-labelledby="profile-tab">
            <br>
                <label> Inicio</label>
                <input type="date" class="form-control" name="fechaigg" id="fechaigg" required=""> 
                <label> Fin</label>
                <input type="date" class="form-control" name="fechafgg" id="fechaigg" required=""> 
            
            
            </div>
  
        </div>
      </div>
       <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="compra.php" class="small-box-footer">Gen&eacute;rica de Gastos <i class="fa fa-arrow-circle-right"></i></a>
      </div>
      
  </div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-success">
  <div class="inner">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#periodogi" role="tab" aria-controls="home" aria-selected="true"><font color="black">Periodos</font> </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#fechasgi" role="tab" aria-controls="profile" aria-selected="false"><font color="black">Por fechas</font></a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="periodogi" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <label> Periodo</label>
            
              <select name="idperiodogi" id="idperiodogi" class="form-control">
                <option value="">Seleccione</option>
                <option value="1">2023-I</option>
                
              </select>
              <button class="btn btn-primary" onclick="mostrarperiodoingreso();">Cuentas</button>
              <button class="btn btn-primary" onclick="mostrarperiodoingresoanalitico();">Analítico</button>
            </div>
            <div class="tab-pane fade" id="fechasgi" role="tabpanel" aria-labelledby="profile-tab">
            <br>
                <label> Inicio</label>
                <input type="date" class="form-control" name="fechaigi" id="fechaigi" required=""> 
                <label> Fin</label>
                <input type="date" class="form-control" name="fechafgi" id="fechafgi" required=""> 
            
            
            </div>
  
        </div>
      </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="venta.php" class="small-box-footer">Gen&eacute;rica de Ingresos <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-warning">
  <div class="inner">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#periodoa" role="tab" aria-controls="home" aria-selected="true"><font color="black">Periodos</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#fechasa" role="tab" aria-controls="profile" aria-selected="false"><font color="black">Por fechas</font></a>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="periodoa" role="tabpanel" aria-labelledby="home-tab">
            <br>
            <label> Periodo</label>
            
              <select name="idinformeperiodo" id="idinformeperiodo" class="form-control">
                <option value="">Seleccione</option>
                <option value="1">2023-I</option>
                
              </select>
              <button class="btn btn-primary" onclick="mostrarinforme();">Ver</button>
            </div>
            <div class="tab-pane fade" id="fechasa" role="tabpanel" aria-labelledby="profile-tab">
            <br>
                <label> Inicio</label>
                <input type="date" class="form-control" name="fechaia" id="fechaia" required=""> 
                <label> Fin</label>
                <input type="date" class="form-control" name="fechafa" id="fechafa" required=""> 
            
            
            </div>
  
        </div>
      </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="registrogastos.php" class="small-box-footer">Informe Econ&oacute;mico <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-danger">
    <div class="inner">
      <br>
        <label> Lista de Productos</label>
        <select name="idperiodoprod" id="idperiodoprod" class="form-control">
                <option value="">Seleccione</option>
                <option value="1">2023-I</option>
                
              </select>
          <select name="idproducto" id="idproducto" class="form-control">
            <option value="">Seleccione</option>
            <option value="11">PROGRAMA DE FORMACIÓN CONTINUA DE CAPACITACIÓN EN IDIOMA INGLÉS - VIRTUAL</option>
            <option value="12">PREPARATORIA ACADÉMICA</option>
            <option value="92">TALLER DE REFORZAMIENTO EN INGLÉS</option>
            <option value="93">TALLER DE REFORZAMIENTO EN COMUNICACIÓN, MATEMÁTICA Y CULTURA</option>
          </select>
          <button class="btn btn-primary" onclick="periodoproducto();">Ver participantes</button>
    </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="registrogastos.php" class="small-box-footer">Actividades <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-blue">
    <div class="inner">
      <br>
        <label> Lista de Proyectos</label>
        <select name="idperiodoprod" id="idperiodoprod" class="form-control">
                <option value="">Seleccione</option>
                <option value="1">2023-I</option>
                
              </select>
          <select name="idactividades" id="idactividades" class="form-control">
            <option value="">Seleccione</option>
            <option value="1">PROGRAMA DE FORMACIÓN CONTINUA DE CAPACITACIÓN EN IDIOMA INGLÉS - VIRTUAL</option>
            <option value="16">DERECHO DE PAGO POR INGLÉS NIVEL A2 PARA OBTENCIÓN DE GRADO</option>
            <option value="18">TALLER DE REFORZAMIENTO EN INGLÉS</option>
            <option value="19">TALLER DE REFORZAMIENTO EN COMUNICACIÓN, MATEMÁTICA Y CULTURA</option>
            <option value="20">PROGRAMA DE PROFESIONALIZACIÓN DOCENTE</option>
          </select>
          <button class="btn btn-primary" onclick="ingresosegresosactividades();">Ver</button>
    </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="registrogastos.php" class="small-box-footer">Actividades <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>


        </div>         
          
        <!-- FIN AREA DE TRABAJO  -->


        </div>
       
      </div>

     </section>
  
  </div>
 





<?php } else {require 'noacceso.php';}

    require 'footer.php';
    ?>
  
  <script>
  
  
  function cargarperiodos() {
  $.post(
    "../ajax/periodos.php?op=select_combo_periodos",
    { },
    function (r) {
      $("#idperiodogi").html(r);
      $("#idperiodogg").html(r);
      $("#idinformeperiodo").html(r);
    }
  );

  //mostrar_precio_periodo();
}
  
  
  function ingresosegresosactividades(){
    var id = $("#idactividades").val();
    window.open('../reportes/informeactividades.php?id='+id,'_blank');
  }
  
  
    function mostrarperiodoingreso() {
      var id = $("#idperiodogi").val();
    window.open('../reportes/reporteingresosperiodos.php?id='+id,'_blank');
    }
    function mostrarperiodoingresoanalitico() {
      var id = $("#idperiodogi").val();
    window.open('../reportes/reporteingresosperiodosanalitico.php?id='+id,'_blank');
    }
    function mostrarperiodogasto() {
      var id = $("#idperiodogg").val();
    window.open('../reportes/reportegastosperiodos.php?id='+id,'_blank');
    }
    
    function mostrarinforme() {
      var id = $("#idinformeperiodo").val();
    window.open('../reportes/reporteinformeeconomico.php?id='+id,'_blank');
    }
    
    function periodoproducto() {
      var id = $("#idperiodoprod").val();
      var idp = $("#idproducto").val();
    window.open('../reportes/reporteusuariosproductos.php?id='+id+'&idp='+idp,'_blank');
    }
  </script>
<?php
}
ob_end_flush();
?>


