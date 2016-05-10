<?php
<<<<<<< HEAD
=======
	ini_set("session.cookie_lifetime","72000");
	ini_set("session.gc_maxlifetime","72000");
>>>>>>> aviso_fin_sesion
	session_start();
	include_once "respuestasWeb.inc";
	include_once "connection.inc";
	$ruta = '/casaasturias/';
	// identificar socios, y devolver el enlace de acceso
	if ($_POST) {
		$numeroUsuario = $_POST['nUsuario'];
		$clave = $_POST['pass'];
		//echo 'CONECTANDO';
		$enlace = enlazarBBDD();	
		//echo 'CONECTADO';
		$mensaje = comprobarUsuario($enlace, $numeroUsuario, $clave);
<<<<<<< HEAD
		$inactivo = 120; //segundos que tardara en cerrarse la session 
		if ( ($mensaje != "ERROR") && ($mensaje != "SIN BBDD") && ($mensaje != "3") ){
			if (!isset($_SESSION['nUsuario'])) {
				$_SESSION['nUsuario']= $numeroUsuario;
				$_SESSION['clave']= $clave;
				$_SESSION['tipoUsuario']= $mensaje;
				$_SESSION['timeout'] = time();
				$_SESSION['indice'] = 1;
			} else {
				$_SESSION['nUsuario']= $numeroUsuario;
				$_SESSION['clave']= $clave;
				$_SESSION['tipoUsuario']= $mensaje;
				$_SESSION['timeout'] = time();
				$_SESSION['indice'] = 2;
=======
		if ( ($mensaje != "ERROR") && ($mensaje != "SIN BBDD") && ($mensaje != '3') ){
			//ini_set("session.cookie_lifetime","200");
			//ini_set("session.gc_maxlifetime","200");
			//session_start();
			$_SESSION['nUsuario']= $numeroUsuario;
			$_SESSION['clave']=$clave;
			$_SESSION['tipoUsuario']=$mensaje;
			$_SESSION['timeout']=time();
			$_SESSION['indice']=1;
			if (!isset($_SESSION['puede_firmar']) ){
				$_SESSION['puede_firmar'] = 0;
>>>>>>> aviso_fin_sesion
			}
			echo "_OK_10_".$_SESSION['indice']."_";
			mysqli_close($enlace);
		} else if ($mensaje=='3') {
			$_SESSION['puede_firmar'] = 1;
			echo "_OK_11_";
			mysqli_close($enlace);
<<<<<<< HEAD
		} else if ($mensaje == "3") {
			$_SESSION['puede_firmar']=1;
		}else {
			echo "_ERROR_$mensaje";
=======
		} else {
			echo "_ERROR_".$mensaje."_";
>>>>>>> aviso_fin_sesion
			mysqli_close($enlace);
		}
	}
	// Se direcciona a la pagina correspondiente, segun la adjudicacion de la sesion
	if ($_GET) {
		if ($_GET['inicio'] == $_SESSION['indice'] ) {
			//echo 'CONECTANDO';
			$enlace = enlazarBBDD();	
			//echo 'CONECTADO';		
			$response = montar($enlace);
			echo $response;
			mysqli_close($enlace);
		} else {
<<<<<<< HEAD
			header("Location:/casaasturias/index.html");
		}		
	} 	
=======
			header("Location: ".$ruta."index.html");
		}
	}
>>>>>>> aviso_fin_sesion
?>
