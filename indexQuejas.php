<?php
	session_start();
    include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();

	if ( ($_SESSION['nUsuario']) && ($_GET) ) {
		$deporte = $_GET['v1'];
		$pista = (int) $_GET['v2'];
		$incrementoFecha = $_GET['ifecha'];
		$enlace = enlazarBBDD();
	} else {
		header("Location: ".$ruta."index.html");
	}

?>
<!DOCTYPE html>
<html lang="ES">
	<head>
		<title> SOCIEDAD REAL CASA DE ASTURIAS</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>css/estilo.css">
		<script type="text/javascript" src="<?php echo $ruta;?>js/tratarobservaciones.js"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shiv.google.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

	<body>

		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>

	</body>
</html>
