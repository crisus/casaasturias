<?php
	session_start();
	function comprobarVidaSesion() {
		$inactivo = tiempoInactividadPermitida(); //segundos que tardara en cerrarse la session
		if(isset($_SESSION['timeout']) ) {
			$vida_session = time() - $_SESSION['timeout'];
			if($vida_session > $inactivo) {
				eliminarSesion();
				header("Location: ".$ruta."index.html");
			}
		}
	}
	
	function eliminarSesion() {
		$_SESSION['nUsuario']="";
		$_SESSION['clave']="";
		$_SESSION['tipoUsuario']="";
		$_SESSION['timeout']=0;
		$_SESSION['indice']=0;
       	//header("Location: ".$ruta."index.html");
	}
	
	function tiempoInactividadPermitida() {
		//if (!isset($_SESSION['tipoUsuario']) ) {return 0; } // corresponde eliminar sesion
		if ($_SESSION['tipoUsuario']=="1") {return 400; }// 2min
		if ($_SESSION['tipoUsuario']=="2") {return 60*10; }// 10 min
		if ($_SESSION['tipoUsuario']=="3") {return 60*60*20; }// 20 h
	}
?>