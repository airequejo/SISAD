<?php
date_default_timezone_set('America/Lima');
$dia = date("d");
$mes = date("m");
$anio = date("Y");
$diasmes = date("t");
$fechaactual = $anio . "/" . $mes . "/" . $dia;
ob_start();
session_start();

if(!isset($_SESSION["nombre"]))
{
  header("Location: login.html");
}
else
{

require 'header.php';

if($_SESSION['escritorio']==1)
{
 require_once "../modelos/Consultas.php";
 require_once "../modelos/Venta.php";
 $venta=new Venta;
  $consulta = new Consultas();
  $rsptac = $consulta->totalcomprahoy();
  $regc=$rsptac->fetch_object();
  $totalc=$regc->total;

  $rsptav = $consulta->totalventahoy();
  $regv=$rsptav->fetch_object();
  $totalv=$regv->total;

  $rsptag = $consulta->reporteGastos();
  $regG=$rsptag->fetch_object();
  $totalg=$regG->total;

//// Tabla de datos

$rsptavc = $consulta->totalventacontado();
$regvc=$rsptavc->fetch_object();
$totalcontado=$regvc->total;

$rsptavt = $consulta->totalventatarjeta();
$regvt=$rsptavt->fetch_object();
$totaltarjeta=$regvt->total;

$rsptavm = $consulta->totalventamixto();
$regvm = $rsptavm->fetch_object();
$totalefectivom = $regvm->totalefectivo;
$totaltarjetam = $regvm->totaltarjeta;

$rsptavd = $consulta->totalventadeposito();
$regvd=$rsptavd->fetch_object();
$totaldeposito=$regvd->total;

$rsptacaja = $consulta->buscarcaja();
$regcaja=$rsptacaja->fetch_object();
$idcaja=$regcaja->idcaja;
$fechacaja=$regcaja->fecha_apertura;
$cajainicial=$regcaja->monto_inicial;
$cajafinal=$regcaja->total_efectivo;
$estado=$regcaja->estado;
$haycaja=$regcaja->haycaja;


  //Datos para mostrar el gráfico de barras de las compras
  $compras10 = $consulta->ventasultimos_12meses();
  $fechasc='';
  $totalesc='';
  while ($regfechac= $compras10->fetch_object()) {
    $fechasc=$fechasc.'"'.$regfechac->fecha .'",';
    $totalesc=$totalesc.$regfechac->totalv .',';
  }

  //Quitamos la última coma
  $fechasc=substr($fechasc, 0, -1);
  $totalesc=substr($totalesc, 0, -1);

   //Datos para mostrar el gráfico de barras de las ventas
   $ventas12 = $consulta->ventaultimomes();
   $fechasv='';
   $totalesv='';
   $fechasv1='';
   $totalesde='';
   $colores='';
   while ($regfechav= $ventas12->fetch_object()) {
     $nombredia=$regfechav->nombredia.'-'.$regfechav->fecha;
     $fechasv=$fechasv.'"'.$nombredia.'",';
     $totalesv=$totalesv.$regfechav->totalv.',';
    // $totalesde=$totalesde.$regfechav->delivery.','; 
     $colores=$colores."'".$regfechav->dias_semana."'".',';
   }
 
   //Quitamos la última coma
   $fechasv=substr($fechasv, 0, -1);
   $totalesv=substr($totalesv, 0, -1);
   $colores=substr($colores, 0, -1);
  
   //ventas por producto
   $rsptaa=$consulta->ventasxproducto();
$promociones='';
$cantidades='';
while($rega=$rsptaa->fetch_object()){
  $promociones=$promociones.'"'.$rega->descripcion.'( '.$rega->cantidadp.' )",';
  $cantidades=$cantidades.$rega->cantidadp.',';
};
$promociones=substr($promociones,0,-1);
$cantidades=substr($cantidades, 0,-1);



?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>

        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="escritorio.php"><i class="fa fa-dashboard"></i> <strong>ESCRITORIO</strong></a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Dashboard</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" ><i class="fa fa-remove"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            
            

<div class="row">

  <div class="col-lg-3 col-6">
      <div class="small-box bg-white">
        <div class="inner">
          <strong>S/ <?php echo $totalc; ?></strong>
          <p>Compras del día</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <a href="compra.php" class="small-box-footer">Compras <i class="fa fa-arrow-circle-right"></i></a>
      </div>
  </div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-green">
    <div class="inner">
      <strong>S/ <?php echo number_format($totalcontado+$totalefectivom+$totaltarjeta+$totaltarjetam, 2); ?></strong>
      <p>Ventas del día</p>
    </div>
    <div class="icon">
      <i class="ion ion-stats-bars"></i>
    </div>
    <a href="venta.php" class="small-box-footer">Ventas <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">
  <div class="small-box bg-warning">
    <div class="inner">
      <strong>S/ <?php echo number_format($totalg, 2, '.', ''); ?></strong>
      <p>Gastos del Día</p>
    </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="registrogastos.php" class="small-box-footer">Gastos <i class="fas fa-arrow-circle-right"></i></a>
  </div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">
  <div class="inner">
    <strong>S/ <?php if($cajainicial==0){
      echo '0.00 <a href="#" onclick="registrar_caja();"><font color="white" size="2px"> -( Registrar Caja )-</font></a>'; 
    }else{
      echo number_format($cajainicial, 2, '.', '') . " " . '<a href="#" onclick="cerrar_caja(' . $idcaja . ');"><font color="white" size="2px"> -( Cerrar Caja )-</font></a>';
    }?>
    </strong>
    <p>Caja del Día <?php echo date("d/m/Y", strtotime($fechacaja));?></p>
</div>
<div class="icon">
<i class="ion ion-pie-graph"></i>
</div>
<a href="#" class="small-box-footer">Cajas <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"  id="productosdeldia" name="productosdeldia">
                          <div class="box box-primary">
                          
                              <div class="box-header with-border">
                                Productos o Servicios vendidos en el día <?php echo $dia . "-" . $mes . "-" . $anio; ?> <input type="button" onclick="imprimirreporte('productosdeldia');" value="Imprimir Reporte">
                              </div>
                         
                         
                              <div class="box-body col-lg-6">
                              <table border="1" width="90%">
                              <tr><td colspan="3"><b>&nbsp;Lista de Productos o Servicios</b></td></tr>
                              <tr><td align="center">Producto</td><td align="center">Cantidad</td><td align="center">Precio</td></tr>
                                <?php 
                               $productosdia = $consulta->comidasvendidashoy();
                                while ($reg = $productosdia->fetch_object())
                                {
                                
                                   echo '<tr><td>&nbsp;<small>'.$reg->nombreconteo.'</small></td><td align="right"><small>'.$reg->cantidad_dia.'</small>&nbsp;</td><td align="right"><small>'.number_format($reg->promedio, 2, '.', '').'</small>&nbsp;</td></tr>';
                                }                              
                                ?>
                                </table>
                                
                              </div>
                                <div class="box-body col-lg-6">
                              
                                
                              </div>
                            
                          </div>
                         
                        </div>
                        <br>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"  id="detalledeldia" name="detalledeldia">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Resumen del Día <?php echo $dia . "-" . $mes . "-" . $anio; ?>&nbsp;<input type="button" onclick="imprimirreporte('detalledeldia');" value="Imprimir Reporte">
                              </div>
                              
                              <div class="box-body">
                              Resumen de comprobantes
                              <table border="1" width="90%">
                              <tr><td colspan="4"><b>&nbsp;Lista de Comprobantes</b></td></tr>
                              
                                <?php 
                                $comprobantes = $venta->listar1($fechaactual,$fechaactual);
                                while ($reg = $comprobantes->fetch_object())
                                {
                                
                                   echo '<tr><td><small>'.substr($reg->tipocomprobante,0,3).$reg->serie."-".$reg->numero."-".$reg->cliente.'</small></td><td><small>'.substr($reg->formapago,0,3).'</small></td><td align="right"><small>'.number_format($reg->total, 2, '.', '').'</small>&nbsp;</td><td><small>'.$reg->usuario.'</small></td></tr>';
                                }                              
                                ?>
                                </table>
                              
                              <br>
                              Resumen de Ingresos y Egresos                                
                                <table width="99%">
                                        <tr><td width="33%">&nbsp;</td><td align="center" style="border: steelblue 1px solid;" class="bg-success" width="33%"><b>Ingresos</b></td><td align="center" style="border: steelblue 1px solid;" class="bg-danger" width="33%"><b>Egresos</b></td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right" class="bg-info" width="33%">Efectivo S/ &nbsp;</td><td align="right" style="border: steelblue 1px solid;" width="33%"><?php echo number_format($totalcontado+$totalefectivom, 2, '.', ''); ?> &nbsp;</td><td align="right" width="33%"><?php echo number_format($totalg, 2, '.', ''); ?> &nbsp;</td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right" class="bg-info" width="33%">Tarjeta S/ &nbsp;</td><td align="right" style="border: steelblue 1px solid;" width="33%"><?php echo number_format($totaltarjeta+$totaltarjetam, 2, '.', ''); ?> &nbsp; </td><td align="right" width="33%"></td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right" class="bg-info" width="33%">Depósito S/ &nbsp;</td><td align="right" style="border: steelblue 1px solid;" width="33%"><?php echo number_format($totaldeposito, 2, '.', ''); ?> &nbsp;</td><td align="right" width="33%">&nbsp;</td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right" class="bg-info" width="33%">Caja S/ &nbsp;</td><td align="right" style="border: steelblue 1px solid;" width="33%"><?php echo number_format($cajainicial, 2, '.', ''); ?> &nbsp;</td><td align="right" width="33%">&nbsp;</td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right"  class="bg-info" width="33%"><b>Total S/ &nbsp;</b></td><td align="right" style="border: steelblue 1px solid;" class="bg-info" width="33%"><?php echo number_format($totalv, 2, '.', ''); ?> &nbsp;</td><td align="right" class="bg-info" width="33%"><?php echo number_format($totalg, 2, '.', ''); ?> &nbsp;</td></tr>
                                        <tr style="border: steelblue 1px solid;"><td align="right" style="border: steelblue 1px solid;" width="33%" class="bg-info">(Ingresos - Egresos) &nbsp;<br><b>Saldo Caja S/ &nbsp;</b></td><td align="center" colspan="2" class="bg-warning"><?php echo "<h2>".number_format(($totalcontado+$totalefectivom+$cajainicial-$totalg), 2, '.', '')."</h2>";?>&nbsp;</td></tr>
                                    </table>
                                   
                              </div>
                          </div>
                        </div>
</div>
<div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Ventas últimos 12 meses S/
                              </div>
                              <div class="box-body">
                                <canvas id="meses" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                Ventas último mes por día S/
                              </div>
                              <div class="box-body">
                                <canvas id="semanas" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                    </div>
</div>           
                    <div class="panel-body">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                10 productos o Servicios más vendidos
                              </div>
                              <div class="box-body">
                                <canvas id="productosxventas" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                          <div class="box box-primary">
                              <div class="box-header with-border">
                                .
                              </div>
                              <div class="box-body">
                                <canvas id="vacio" width="400" height="300"></canvas>
                              </div>
                          </div>
                        </div>
                    </div>
          </div>


          </div>

      </div>



    </section>
    <!-- /.content -->
  </div>

  <!-- /.content-wrapper -->
  <script src="../public/bower_components/datatables.net-bs/tables.js"></script>
<!-- <script src="../../public/bower_components/bootstrap-datepicker/pickers.js"></script> -->
<?php
 }
else
{

  require 'noacceso.php';

}

  require 'footer.php';
?>
<script type="text/javascript" src="scripts/categoria.js"></script>

<script src="../public/js/Chart.min.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript">
var ctx = document.getElementById("meses").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'S/ ',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("semanas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Delivery S/ ',
            data: [<?php echo $totalesde; ?>],
            backgroundColor: ['rgba(253,254,254,0.6)'],
            borderWidth: 1

        },{
          label: 'Totales S/ ',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [<?php echo $colores; ?>],
            borderWidth: 2
        }

      ]
    },
    options: {
      tooltips: {
						mode: 'index',
						intersect: false
					},
      responsive:true,
        scales: {
          xAxes: [{
							stacked: true,
						}],
						yAxes: [{
							stacked: true
						}]
        }
    }
});
</script>

<script>
var ctx = document.getElementById("productosxventas").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: [<?php echo  $promociones;?>],
        datasets: [{
            label:'#',
            data: [<?php echo $cantidades;?>],
            backgroundColor: [
              'rgba(106, 90, 205, 0.2)',
                'rgba(205, 133, 63, 0.2)',
                'rgba(154, 205, 50, 0.2)',
                'rgba(244, 164, 96, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [],
                borderWidth: 1
        }]
    },
    options: {
      title: {
            display: true,
            text: 'Cantidad de Productos'
        }
    }
});
</script>


    <script type="text/javascript">
    function imprimirreporte(nombreDiv)
    {
        var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
    }
	function registrar_caja(){
		//alert("Se hará el registro de caja");
		bootbox.prompt({
		title: "Ingrese el monto inicial de su caja",
		inputType: 'text',
		callback: function (result) {
			if(result){
				$.post("../ajax/venta.php?op=registrarcaja", {monto : result}, function(e){
                    bootbox.alert(e);
                    location.reload(true);
				});
			}
			
		}
	});
	}
	function cerrar_caja(idcaja){
		bootbox.confirm({
        message: "¿Esta seguro de cerrar la caja?",
        size: 'small',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
        	if (result) {
                $.post("../ajax/venta.php?op=cerrarcaja", {idcaja : idcaja}, function(e){
                    bootbox.alert(e);
                    location.reload(true);
				});
        	}else{

        	}
        }
    });
    }

function registrar_vuelto(){
		//alert("Se hará el registro de caja");
		bootbox.prompt({
		title: "Ingrese el monto del vuelto",
		inputType: 'text',
		callback: function (result) {
			if(result){
				$.post("../ajax/venta.php?op=registrarvuelto", {monto : result}, function(e){
                    bootbox.alert(e);
                    location.reload(true);
				});
			}
			
		}
	});
	}
	function cerrar_vuelto(idvuelto){
		bootbox.confirm({
        message: "¿Esta seguro de cerrar la vuelto?",
        size: 'small',
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {
        	if (result) {
                $.post("../ajax/venta.php?op=cerrarvuelto", {idvuelto : idvuelto}, function(e){
                    bootbox.alert(e);
                    location.reload(true);
				});
        	}else{

        	}
        }
    });
	}

    </script>



<!--
<script type="text/javascript">

var ctx = document.getElementById("compras").getContext('2d');
var compras = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasc; ?>],
        datasets: [{
            label: 'Compras en S/ de los últimos 10 días',
            data: [<?php echo $totalesc; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

var ctx = document.getElementById("ventas").getContext('2d');
var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $fechasv; ?>],
        datasets: [{
            label: 'Ventas en S/ de los últimos 12 Meses',
            data: [<?php echo $totalesv; ?>],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>
-->
<script type="text/javascript">
          // Defino un plugin para proveer las etiquetas de datos
        Chart.plugins.register({
            afterDatasetsDraw: function(chart, easing) {
                // To only draw at the end of animation, check for easing === 1
                var ctx = chart.ctx;

                chart.data.datasets.forEach(function (dataset, i) {
                    var meta = chart.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function(element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(0, 0, 0)';

                            var fontSize = 12;
                            var fontStyle = 'Normal';
                            var fontFamily = 'Arial';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var dataString = dataset.data[index].toString();

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'top';

                            var padding = 0;
                            var position = element.tooltipPosition();
                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                        });
                    }
                });
            }
        });
</script>

<?php

 }

  ob_end_flush();

?>
