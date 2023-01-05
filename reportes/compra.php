<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>siqay.com</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons 
  <link rel="stylesheet" href="../public/plugins/Ionicons/css/ionicons.min.css">-->
  <!-- Theme style -->
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. 
  <link rel="stylesheet" href="../public/css/skins/_all-skins.min.css">-->

  <!-- <link rel="apple-touch-icon" href="../public/img/caja.png">
  <link rel="shortcut icon" href="../public/img/caja.png"> -->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <?php
  date_default_timezone_set('America/Lima');
  //Activamos el almacenamiento en el buffer
  /*
  ob_start();
  if (strlen(session_id()) < 1) 
    session_start();
  
  if (!isset($_SESSION["nombre"]))
  {
    echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
  }
  else
  {
  if ($_SESSION['compras']==1)
  {*/
  //Incluímos el archivo Factura.php
  require('configCompra.php');
  
  require_once "../modelos/Consultas.php";
        $consultas = new Consultas;
        $rspta = $consultas->config_empresa();
        $reg = $rspta->fetch_object();
  
  //Obtenemos los datos de la cabecera de la venta actual
  require_once "../modelos/Compra.php";
  $compra= new Compra();
  $rsptac = $compra->mostrar_compra_cabecera($_GET["id"]);
  //Recorremos todos los valores obtenidos
  $regv = $rsptac->fetch_object();
  
  ?> 
      
      
        <section class="invoice">         <!-- title row -->

    <div class="mt-2 ml-2 mr-2">
          
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> COMPROBANTE DE INGRESO:
                
              </h2>
            </div>
            <!-- /.col -->
          </div>
          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              Proveedor
              <address>
                <strong> <?php echo utf8_decode($regv->nombrerazon); ?></strong><br>
                Dirección: <?php echo utf8_decode($regv->direccion); ?> <br>
                Ruc: <?php echo $regv->dniruc;  ?>
              </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
             
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
              <b>Comprobante: <?php echo $regv->tipocomprobante; ?></b>
              <br>
              <b>Serie: </b> <?php echo $regv->serie; ?><br>
              <b>Número: </b> <?php echo $regv->numero; ?><br>
              <b>Fecha:</b> <?php echo $regv->fecha; ?>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Descripción</th>
                  <th>Gasto - Actividad</th>
                  <th >Cantidad</th>
                  <th >Precio Unit</th>
                  <th >Subtotal</th>
                </tr>
                </thead>
                <tbody>
              <?php
                $rsptad = $compra->listarDetalle($_GET["id"]);
                $n=1;
                $sbs = 0;
                while ($regd = $rsptad->fetch_object()) {  ?>
                  
                <tr>
                  <td> <?php echo $n; ?></td>
                  <td><?php echo htmlspecialchars_decode("$regd->descripcion"); ?></td>
                  <td><?php echo htmlspecialchars_decode("$regd->actividad"); ?></td>
                  <td ><?php echo number_format($regd->cantidad, 1, '.', ' '); ?></td>
                  <td > <?php echo number_format($regd->precio, 4, '.', ' '); ?></td>
                  <td > <?php echo number_format($regd->subtotales, 2, '.', ' '); ?></td>
                  </tr>
                
                  <?php
                  $sbs = $sbs + ($regd->precio * $regd->cantidad);
                  $n++;

                  } 
                  
                  require_once "Letras.php";
                  $V=new EnLetras(); 
                  $total_mostrar = ($regv->total_compra*(1+($regv->impuesto/100))) - $regv->descuento_general;
                  $total_igv =  $total_mostrar - $sbs;
                  $con_letra=strtoupper($V->ValorEnLetras($total_mostrar," SOLES CON "));

                  ?>
                
                </tbody>
              </table>
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
         
            <!-- accepted payments column -->
            <div class="col-xs-6">
              
            </div>
            </div>

          <div class="d-flex justify-content-end ml-8 mr-4">
            <!-- /.col -->
            <div class="col-xs-6">
              <p class="lead"><b>Detalle Totales</b></p>
    
             
                <table class="table">
                  <tr>
                    <th style="width:50%">Subtotal S/:</th>
                    <td><?php echo  number_format($sbs, 2, '.', ' '); ?></td>
                  </tr>
                  <tr>
                    <th>IGV ( <?php echo $regv->impuesto; ?>) Total S/</th>
                    <td><?php echo  number_format($total_igv, 2, '.', ' '); ?></td>
                  </tr>
                  <tr>
                  <th >Desc. general S/:</th>
                    <td><?php echo  number_format($regv->descuento_general, 2, '.', ' '); ?></td>
                  </tr>
                  
                  
                  <tr>
                    <th>Total S/:</th>
                    <td><?php echo number_format($total_mostrar, 2, '.', ' '); ?></td>
                  </tr>
                </table>
 
            </div>
    </div>
    <div class="ml-4">
    <b><td colspan='1'>SON: <?php echo $con_letra; ?></td></b>

    </div>
            <!-- /.col -->
            
          
          <!-- /.row -->
          
          <!-- this row will not appear when printing -->
   
        </section>
        <!-- /.content -->
        
        <?php
   
      /*}
      else
      {
        echo 'No tiene permiso para visualizar el reporte';
      }
      
      }
      ob_end_flush();*/
      ?> 

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick 
<script src="../public/plugins/fastclick/lib/fastclick.js"></script>-->
<!-- AdminLTE App -->
<script src="../public/js/adminlte.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../public/js/demo.js"></script>
</body>
</html>
