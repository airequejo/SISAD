<?php
if (strlen(session_id()) < 1) {
    session_start();
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SISAD</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../public/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css' rel='stylesheet' type='text/css'>
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="../public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../public/plugins/toastr/toastr.min.css">

  <link rel="stylesheet" href="../public/plugins/jquery-ui/jquery-ui.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/adminlte.min.css">
  <link rel="apple-touch-icon" href="../public/img/logo.png">
  <link rel="shortcut icon" href="../public/img/logo.png">

</head>
<body class="hold-transition sidebar-mini sidebar-collapse text-sm">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      
   
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
       
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
      <li class="nav-item">
      <a href="../ajax/usuario.php?op=salir" class="nav-link"  role="button">
            <i class="fas fa-power-off "></i>
            </a>
       
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="../files/usuarios/<?php echo $_SESSION[
            'imagen'
        ]; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php echo $_SESSION[
                'login'
            ]; ?><br><i class="fa fa-circle text-success"></i> Online
          </a>
        
        </div>
      </div>


      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <?php if ($_SESSION['escritorio'] == 1) {
            echo '<li class="nav-item">
        <a href="escritorio" class="nav-link">
        <i class="fas fa-tachometer-alt"></i>
          <p>
              TABLERO
           
          </p>
        </a>
      </li>';
        } ?>
       
       <?php if ($_SESSION['caja'] == 1) {
           echo ' <li class="nav-item">
            <a href="caja" class="nav-link">
            <i class="far fa-credit-card"></i>
              <p>
                  CAJA                
              </p>
            </a>           
          </li>';
       } ?>

      <?php if ($_SESSION['ingresos'] == 1) {
          echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-cart-plus"></i>
              <p>
                 INGRESOS
                <i class="fas fa-angle-left right"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
              <li class="nav-item">
                <a href="venta" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="listaventa" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Lista de ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="cliente" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Clientes</p>
                </a>
              </li>
              
            </ul>
          </li>';
      } ?>

<?php if ($_SESSION['ctscobrar'] == 1) {
          echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-cart-plus"></i>
              <p>
                 CTS POR COBRAR
                <i class="fas fa-angle-left right"></i>
               
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
              <li class="nav-item">
                <a href="listacompromisos" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Compromisos de pago</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="gestionarcompromisos" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Gestionar compromisos</p>
                </a>
              </li>
                            
            </ul>
          </li>';
      } ?>

<?php if ($_SESSION['egresos'] == 1) {
    echo '
          <li class="nav-item">
            <a href="#" class="nav-link">
            <i class="far fa-handshake"></i>
              <p>
                 EGRESOS
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
            <li class="nav-item">
                <a href="compra" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Compras</p>
                </a>
              </li>
      
              <li class="nav-item">
                <a href="proveedores" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Proveedores</p>
                </a>
              </li>
            </ul>
          </li>';
} ?>

         <!-- 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
               Abastecimiento
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="../UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              
            </ul>
          </li> -->

          <?php if ($_SESSION['productos'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link" >
            <i class="fab fa-product-hunt"></i>
              <p >
                 PRODUCTOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
              <li class="nav-item">
                <a href="producto" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Producto</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="detalleproducto" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Lista Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="precios" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Precios</p>
                </a>
              </li>
              
            </ul>
          </li>';
          } ?>



<?php if ($_SESSION['cuentas'] == 1) {
    echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-copyright"></i>
            
              <p>
                 CUENTAS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
              <li class="nav-item">
                <a href="cuenta" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Cuenta</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="subcuenta" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Subcuenta</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="divisionaria" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Divisionaria</p>
                </a>
              </li>              
            </ul>
          </li>';
} ?>
          

          <?php if ($_SESSION['actividades'] == 1) {
              echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-sitemap"></i>

              <p>
                 ACTIVIDADES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">
             
              <li class="nav-item">
                <a href="gasto" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Gasto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="subgasto" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>SubGasto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="actividad" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Actividades</p>
                </a>
              </li>

              
            </ul>
          </li>';
          } ?>

<?php if ($_SESSION['configuracion'] == 1) {
    echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-cog"></i>
              <p>
                 CONFIGURACIÓN
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 15px;">             
              <li class="nav-item">
                <a href="especialidad" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Especialidades</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="periodo" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Peridos</p>
                </a>
              </li>
              
            </ul>
          </li>';
} ?>

<?php if ($_SESSION['reportes'] == 1) {
            echo '<li class="nav-item">
        <a href="reporte" class="nav-link">
        <i class="fas fa-chart-bar"></i>
          <p>
              REPORTES
           
          </p>
        </a>
      </li>';
        } ?>

<?php if ($_SESSION['accesos'] == 1) {
    echo '<li class="nav-item">
            <a href="#" class="nav-link">
            <i class="fas fa-user-lock"></i>
              <p>
                ACCESOS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview"  style="padding-left: 15px;">
            <li class="nav-item">
                <a href="usuario" class="nav-link">
                  <i class="far fa-circle nav-icon text-green"></i>
                  <p>Usuarios</p>
                </a>
              </li>
              
            </ul>
          </li>';
} ?>
<li class="nav-item">
            <a href="../ajax/usuario.php?op=salir" class="nav-link">
            <i class="fas fa-power-off "></i>
              <p >
                  Cerrar sesion                
              </p>
            </a>           
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>