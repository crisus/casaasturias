<?php
	session_start();
    include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();

	if ( ($_SESSION['nUsuario']) && ($_GET) ) {
		$deporte = $_GET['v1'];
		$pista = (int) $_GET['v2'];
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
		<script type="text/javascript" src="<?php echo $ruta;?>js/comunicacion_quejas.js"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shiv.google.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<header id="cabecera">
			<img class="logo" src="<?php echo $ruta;?>img/casaasturiasescudo.png"></img>
			<h1>Casa De Asturias En Leon</h1>
			<img class="logo" src="<?php echo $ruta;?>img/casaasturiasescudo.png"></img>
		</header>

		<nav id="menu">
			<div class="identificacion">
				USUARIO:
<?php
				if ($_SESSION['tipoUsuario'] == 1) {
					echo 'SOCIO '.$_SESSION['nUsuario'];
				} else if ($_SESSION['tipoUsuario'] == 2) {
					echo 'EMPLEADO '.$_SESSION['nUsuario'];
				}
?>
			</div>
			<div class="menu-zona">
				<ul class = "lista_menu">
					<li><a href="<?php echo $ruta;?>server.php?inicio=<?php echo $_SESSION['indice'];?>">Inicio</a> </li>
					<li><a href="<?php echo $ruta;?>index.html">Cambio de Usuario</a></li>
				</ul>
			</div>
		</nav>

		<section id="contenido">
			<div>
				<h2>OBSERVACIONES</h2>
				<h2><?php echo $deporte;?></h2>
				<h2><?php echo $pista;?></h2>
			</div>
			<div>
				<form>
					<input type="text" id="observacion">
					<input type="text" id="asunto">
					<button type="button" onclick="enviarObsevacion()"></button>
				</form>
			</div>
		</section>


		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>

	</body>
</html>
