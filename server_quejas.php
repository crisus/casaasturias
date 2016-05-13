<?php
	session_start();
	include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();

	//var mensaje="accion=reservar&nUsuario="+entrada.value+"&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo;
	if ($_POST) {
		//echo 'CONECTANDO';
		$enlace = enlazarBBDD();
		//echo 'CONECTADO';

		$accion = $_POST['accion'];
		if ($accion=="quejas") {
			$deporte = $_POST['objeto'];
			$pista = $_POST['elemento'];
			$observacion = $_POST['observacion'];
			$asunto = $_POST['asunto'];
			//echo '_'.$deporte.' '.$pista.' '.$observacion.' '.$asunto.'_';

			if ( setQueja($enlace, $deporte, $pista, $observacion, $asunto) ) {
				echo "_OK_1_";
			} else {
				echo "_ERROR_1_";
			}

		} else if ($accion=='verQuejas') {
			$realizadas = $_POST['re'];
			$archivadas = $_POST['ar'];
			$sinLeer = $_POST['nole'];
			$data = getQuejas($enlace, $realizadas, $archivadas, $sinLeer);
			if ($data !== '') {
				echo '_OK_2_'.$data;
			} else {
				echo '_ERROR_2_';
			}
		} else if ($accion=='archivar') {
			$id = $_POST['objeto'];
			$data = archivarQueja($enlace, $id);
			if ($data) {
				echo '_OK_3_';
			} else {
				echo '_ERROR_4_';
			}
		} else if ($accion=='agregar') {
			$id = $_POST['objeto'];
			$data = agregarQueja($enlace, $id);
			if ($data) {
				echo '_OK_4_';
			} else {
				echo '_ERROR_4_';
			}
		} else {
			echo "_ERROR_2_";
		}

		mysqli_close($enlace);
	}
?>
