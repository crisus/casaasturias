<?php
	//session_start();
    include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();

	if ( $_SESSION['nUsuario'] ) {
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
			<img class="logo" src="<?php echo $ruta;?>img/casaasturiasescudo.png">
			<h1>Casa De Asturias En Leon</h1>
			<img class="logo" src="<?php echo $ruta;?>img/casaasturiasescudo.png">
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
					<div class="gestion-observaciones">VER REALIZADAS<input type="checkbox" class="verQuejas" onclick="obtenerQuejas()"></div>
					<div class="gestion-observaciones">VER ARCHIVADAS<input type="checkbox" class="verQuejas" onclick="obtenerQuejas()"></div>
					<div class="gestion-observaciones">VER NO LEIDAS<input type="checkbox" class="verQuejas" checked onclick="obtenerQuejas()"></div>
				</form>
			</div>
			<div id="all-observaciones" class="all-observaciones">
<?php
				$datas = getQuejas($enlace, 0, 0, 1);
				for ($i=0; ($datas) && ($i < $datas->num_rows); $i++) {
					$quejas = $datas->fetch_row();
					// [id, deporte, pista, asunto, observacion, n_socio fecha, archivada, realidad]
?>
				<div class="bloque-observacion">
					<form>
					<div class="data-bloque-observacion">
<?php				if ( ($quejas[7]==0) && ($quejas[8] == 0) ) { ?>
						<label class="d1l_25" id="estado_<?php echo $quejas[0];?>">SIN LEER</label>
<?php				} else if ( ($quejas[7]==1) && ($quejas[8] == 0) ) { ?>
						<label class="d1l_25" id="estado_<?php echo $quejas[0];?>">ARCHIVADO</label>
<?php				} else if ( ($quejas[7]==0) && ($quejas[8] == 1) ) { ?>
						<label class="d1l_25" id="estado_<?php echo $quejas[0];?>">REALIZADA</label>
<?php				} else if ( ($quejas[7]==1) && ($quejas[8] == 1) ) { ?>
						<label class="d1l_25" id="estado_<?php echo $quejas[0];?>">ARCHIVADA Y REALIZADA</label>
<?php				}?>
						<label class="d1l_25" id="deporte-observacion_<?php echo $quejas[0];?>"><?php echo strtoupper($quejas[1]);?> </label>
						<label class="d1l_25" id="pista-deporte_<?php echo $quejas[0];?>">Pista: <?php echo $quejas[2];?> </label>
						<label class="d1l_50" id="asunto_<?php echo $quejas[0];?>">Asunto: <?php echo $quejas[3];?> </label>
						<textarea class="d2l_100" id="observacion_<?php echo $quejas[0];?>" rows="4"><?php echo $quejas[4];?> </textarea>
					</div>
					<div class="botones-observacion">
						<button class="accion" type="button" id="archivar_<?php echo $quejas[0];?>" onclick="archivar(this.id)" >Archivar</button>
						<button class="accion" type="button" id="agregar_<?php echo $quejas[0];?>" onclick="agregar(this.id)" >Agregar</button>
					</div>
					</form>
				</div>
<?php
				}
?>
			</div>
		</section>


		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>

	</body>
</html>
