<?php
	//session_start();
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
			if ( ($realizadas) || ($archivadas) || ($sinLeer) ) {
				$datas = getQuejas($enlace, $realizadas, $archivadas, $sinLeer);
				$resultado = '';
				if ($datas) {
					for ($i=0; $i < $datas->num_rows; $i++) {
					$data = $datas->fetch_row();
						$resultado = $resultado.$data[0].'_'.$data[1].'_'.$data[2].'_'.$data[3].'_'.$data[4].'_'.$data[7].'_'.$data[8].'_';
					}
					echo '_OK_2_'.$resultado.'_';
				} else {
					echo '_ERROR_2_';
				}
			} else {
				echo '_OK_2__';
			}
		} else if ($accion=='archivar') {
			//echo('archivar');
			$id = $_POST['objeto'];
			$data = archivarQueja($enlace, $id);
			if ($data) {
				echo '_OK_3_';
			} else {
				echo '_ERROR_3_';
			}
		} else if ($accion=='agregar') {
			//echo('agregar');
			$id = $_POST['objeto'];
			$data = agregarQueja($enlace, $id);
			if ($data) {
				echo '_OK_4_';
			} else {
				echo '_ERROR_4_';
			}
		} else {
			echo "_ERROR_6_";
		}

		mysqli_close($enlace);
	}
?>
