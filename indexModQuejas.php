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
				<h2>RESOLVER OBSERVACIONES</h2>
				<form>
					<input type="checkbox" class="verQuejas" value="REALIZADAS" onclick="obtenerQuejas()">
					<input type="checkbox" class="verQuejas" value="ARCHIVADAS" onclick="obtenerQuejas()">
					<input type="checkbox" class="verQuejas" value="SIN LEER" checked onclick="obtenerQuejas()">
				</form>
			</div>
			<div id="observaciones" class="observaciones">
				<div class="bloque-observacion">
					<div class="data">
						<label id="observacion" class="queja"></label>
						<label id="asunto" class="asunto"></label>
					</div>
					<div class="botones">
						<button type="button" value="Archivar" onclick="" class="accion"></button>
						<button type="button" value="Agregar \nA Tareas" onclick="" class="accion"></button>
					</div>
				</div>
			</div>
		</section>


		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>

	</body>
</html>
