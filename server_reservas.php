<?php
	session_start();
	$ruta = '/casaasturias/';
	$inactivo = 120; //segundos que tardara en cerrarse la session
	if(isset($_SESSION['timeout']) ) {
		$vida_session = time() - $_SESSION['timeout'];
		if($vida_session > $inactivo) {
       			$_SESSION['nUsuario']="";
				$_SESSION['clave']="";
				$_SESSION['tipoUsuario']="";
				$_SESSION['timeout']=0;
				$_SESSION['indice']=0;
       			header("Location: ".$ruta."index.html");
		}
	}
	include_once "connection.inc";

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
			echo $response;
		} else if ($accion == 'firmar') {
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$fecha = $_POST['fecha'];
			$bloque = $_POST['nbTiempo'];
			$response = firmar ($enlace, $deporte, $pista, $fecha, $bloque);
			echo $response;
		} else if ($accion =='eliminarReserva') {
			//var mensaje="accion=eliminarReserva&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$nbt = $_POST['nbTiempo'];
			$fecha = $_POST['fecha'];
			$response = eliminarReserva ($enlace, $deporte, $pista, $fecha, $nbt );
			if ($response) {
				echo 'OK_2';
			} else {
				echo 'ERROR_4';
			}
		} else if ($accion =='tarea') {
			$tarea = $_POST['tarea'];
			$deporte = $_POST['deporte'];
			$pista = $_POST['pista'];
			$nbt = $_POST['nbTiempo'];
			$fecha = $_POST['fecha'];
			$response = reservarTarea ($enlace,$tarea,$deporte, $pista, $fecha, $nbt );
			if ($response) {
				echo 'OK_3';
			} else {
				echo 'ERROR_5';
			}
		}
		mysqli_close($enlace);
	}
?>
