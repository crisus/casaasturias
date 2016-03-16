<?php
	session_start();
	include_once "respuestasWeb.inc";
	include_once "connection.inc";
	if ($_POST) {
		$numeroUsuario = $_POST['nUsuario'];
		$clave = $_POST['pass'];
		//echo 'CONECTANDO';
		$enlace = enlazarBBDD();	
		//echo 'CONECTADO';
		$mensaje = comprobarUsuario($enlace, $numeroUsuario, $clave);
		$inactivo = 120; //segundos que tardara en cerrarse la session 
		if ( ($mensaje != "ERROR") && ($mensaje != "SIN BBDD") && ($mensaje!= "3") ){
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
			}
			echo "_".$_SESSION['indice']."_";
			mysqli_close($enlace);
		} else if ($mensaje == "3") {
			$_SESSION['puede_firmar']=1;
		}else {
			echo "_ERROR_$mensaje";
			mysqli_close($enlace);
		}
	}
	if ($_GET) {
		if ($_GET['inicio'] == $_SESSION['indice'] ) {
			//echo 'CONECTANDO';
			$enlace = enlazarBBDD();	
			//echo 'CONECTADO';		
			$response = montar($enlace);
			echo $response;
			mysqli_close($enlace);
		} else {
			header("Location:/casaasturias/index.html");
		}		
	} 	
?>
