<?php

if (strlen(session_id()) < 1)
  session_start();

date_default_timezone_set('America/Lima');

$fecha_c = date('Y-m-d H:i:s');

require_once '../modelos/Caja.php';
$caja = new Caja();

$idusuario = $_SESSION['idusuario'];
$fecha_apertura = date('Y-m-d H:i:s');
$turno = isset($_POST['turno']) ? limpiarCadena($_POST['turno']) : '';
$monto_inicial = isset($_POST['monto_inicial'])
    ? limpiarCadena($_POST['monto_inicial'])
    : '';
$idcaja = isset($_POST['idcaja']) ? limpiarCadena($_POST['idcaja']) : '';

switch ($_GET['op']) {
    case 'insertar_caja':
        if (empty($_SESSION['idusuario'])) {
            header('Location: ../index.php');
        } else {
            $rspta = $caja->insertar_caja(
                $idusuario,
                $turno,
                $fecha_apertura,
                $monto_inicial
            );

            $rows = mysqli_num_rows($rspta);
            $data = mysqli_fetch_assoc($rspta);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        break;

    case 'cerrar_caja':
        if (empty($_SESSION['idusuario'])) {
            header('Location: ../index.php');
        } else {
            $rspta = $caja->cerrar_caja($idcaja, $fecha_c);

            $rows = mysqli_num_rows($rspta);

            $data = mysqli_fetch_assoc($rspta);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        break;

    case 'eliminar':
        $rspta = $caja->eliminar($idcaja);
        echo $rspta ? 'Gasto eliminado' : 'Gasto no se puede eliminar';
        break;

    case 'mostrar':
        $rspta = $caja->mostrar($idcaja);
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspta = $caja->listar($idusuario);
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            if ($reg->turno == 1) {
                $op_caja = 'Mañana';
            } elseif ($reg->turno == 2) {
                $op_caja = 'Tarde';
            } else {
                $op_caja = 'Noche';
            }

            $data[] = [
                '10' => $reg->estado
                    ? '<button data-toggle="modal" href="#mostrar_modal_caja" class="btn btn-info btn-xs" title="Cerrar Caja" onclick="mostrar(' .
                        $reg->idcaja .
                        ')"><i class="fas fa-pencil-alt"></i></button>'
                    : '',

                '1' => $op_caja,
                '2' => date('d-m-Y H:i:s', strtotime($reg->fecha_apertura)),
                '3' => $reg->monto_inicial,
                '4' => $reg->monto_venta_efectivo,
                '5' => $reg->monto_venta_tarjeta,
                //  "6"=>$reg->monto_venta_credito,
                '6' => $reg->monto_gasto,
                '7' =>
                    '<strong class="text-red">' .
                    $reg->total_efectivo .
                    '</strong>',
                '8' =>
                    $reg->fecha_cierre == ''
                        ? ''
                        : date('d-m-Y H:i:s', strtotime($reg->fecha_cierre)),
                '9' => $reg->estado
                    ? '<span class="badge bg-green">ABIERTA</span>'
                    : '<span class="badge bg-red">CERRADA</span>',
                '0' => $reg->idcaja,
            ];
        }
        $results = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];
        echo json_encode($results);
        break;
}
