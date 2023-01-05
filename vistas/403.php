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
        No tiene Permiso
      </h1>

    </section>

    <!-- Main content -->
    <section class="content">

      <div class="error-page">
        <h2 class="headline text-red">500</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-red"></i> Ups! acceso prohibido a esta Página..</h3>

          <p>
           
            Ud. No tiene permiso para acceder a esta pagina. Mientras tanto, puede <a href="escritorios">volver al panel </a> Gracias..
          </p>

          <form class="search-form">
            <div class="input-group">
              <input type="text" name="search" class="form-control" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                </button>
              </div>
            </div>
            <!-- /.input-group -->
          </form>
        </div>
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