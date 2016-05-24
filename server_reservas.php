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
		if ($accion =='reservar') {
			$usuario = $_POST['nUsuario'];
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$bloque = $_POST['nbTiempo'];
			$bloqueActual = $_POST['nbtActual'];
			$fecha = $_POST['fecha'];
			//echo $accion." ".$usuario." ".$deporte." ".$pista." ".$bloque." ".$fecha;
			$response = reservar ($enlace, $usuario ,$deporte, $pista, $bloque, $bloqueActual ,$fecha );
			// respuestas: _OK_4_nombre_ o _ERROR_1_ o _ERROR_2_ o _ERROR_3_
			echo $response;
		} else if ($accion == 'firmar') {
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$fecha = $_POST['fecha'];
			$bloque = $_POST['nbTiempo'];
			$response = firmar ($enlace, $deporte, $pista, $fecha, $bloque);
			// respuestas: _OK_1_ o _ERROR_5_
			echo $response;
		} else if ($accion =='eliminarReserva') {
			//var mensaje="accion=eliminarReserva&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$nbt = $_POST['nbTiempo'];
			$fecha = $_POST['fecha'];
			$response = eliminarReserva ($enlace, $deporte, $pista, $fecha, $nbt );
			if ($response) {
				echo '_OK_2_';
			} else {
				echo '_ERROR_4_';
			}
		} else if ($accion =='tarea') {
			$tarea = $_POST['tarea'];
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$nbt = $_POST['nbTiempo'];
			$fecha = $_POST['fecha'];
			$response = reservarTarea ($enlace,$tarea,$deporte, $pista, $fecha, $nbt );
			if ($response) {
				echo '_OK_3_';
			} else {
				echo '_ERROR_5_';
			}
		} else if ($accion == 'continuidad') {
			//
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$id_tarea = $_POST['tarea'];
			$fechaI = $_POST['fechaI'];
			$fechaF = $_POST['fechaF'];
			$reservaSemana = $_POST['reserva_semana'];
			$nbt = $_POST['nbTiempo'];
			$response = reservarTareaContinua ($enlace,$id_tarea,$deporte, $pista, $fechaI, $fechaF, $reservaSemana,$nbt );
			if ($response) {
				echo '_OK_6_'.$response.'_';
			} else {
				echo '_ERROR_6_'.$response.'_';
			}
		} else if ($accion == 'finSesion'){
			$estado = $_POST['estado'];
			// mantener sesion
			if ($estado == 1) {
				$_SESSION['timeout'] = time();
				echo "_SESION_CONTINUA_";
			} // cerrar sesion
			else if ($estado == 0) {
				echo "_SESION_FIN_";
				eliminarSesion();
			}
		} else if ( ($accion == 'QUEJA') || ($accion == 'queja') ){
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			header("Location: ".$ruta."index_quejas.php?v1=$deporte&v2=$pista");
		}
		mysqli_close($enlace);
	}
?>
