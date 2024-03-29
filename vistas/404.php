  <?php
ob_start();
session_start();

if(!isset($_SESSION["nombre"]))
{
  header("Location: login");
}
else
{
  
require 'header.php'; 


?> 
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Página de error 404
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">404 error</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Ups! Página no encontrada.</h3>

          <p>
       

            No hemos podido encontrar la página que estabas buscando. Mientras tanto, puede <a href="escritorios">volver al panel </a> o intentar usar el formulario de búsqueda.

          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
    <!-- /.content -->
  </div>
<?php

  require 'footer.php'; 



 }

  ob_end_flush(); 

?>