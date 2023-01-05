<?php
if (strlen(session_id()) < 1) {
    session_start();
}

require_once "../modelos/Ciclos.php";
$ciclo = new Ciclos();



switch ($_GET["op"]) {
	case "select_combo_ciclos":
		$rspta = $ciclo->select_combo_ciclos();
		echo "<option value='-'>SELECCIONE UN CICLO</option>";
		while ($reg = $rspta->fetch_object()) {
			echo '<option value=' . $reg->idciclo . '>' . $reg->descripcion . '</option>';
		}

		echo "<option value='0'>NO APLICA</option>";


		break;
}
