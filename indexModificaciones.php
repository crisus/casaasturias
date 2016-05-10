<?php 
	session_start();
<<<<<<< HEAD
	$inactivo = 120; //segundos que tardara en cerrarse la session 
	if(isset($_SESSION['timeout']) ) {
		$vida_session = time() - $_SESSION['timeout'];
		if($vida_session > $inactivo) { 
       			session_destroy();
       			header("Location: casaasturias/index.html"); 
		}
	}
	include_once "connection.inc";
=======
    include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();
>>>>>>> aviso_fin_sesion
?>

<!DOCTYPE html>
<html lang="ES">
	<head>
		<title> SOCIEDAD REAL CASA DE ASTURIAS</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<script type="text/javascript" src="js/modificar.js"></script>
		<!--[if lt IE 9]>
		<script src="http://html5shiv.google.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<header id="cabecera">
			<img class="logo" src="img/casaasturiasescudo.png">
			<h1 id="tit_cabecera">Casa De Asturias En Leon</h1>
			<img class="logo" src="img/casaasturiasescudo.png">
		</header>
		<nav id="menu"> 
			<div class="identificacion">
<?php
	if ($_SESSION['tipoUsuario'] == 2)  {
		echo 'EMPLEADO '.$_SESSION['nUsuario'];
		$enlace = enlazarBBDD();
	} else {
		header("Location: ".$ruta."index.html");
	}
?>
			</div>
			<div class="menu-zona"> 
				<ul class = "lista_menu">
					<li><a href="server.php?inicio=<?php echo $_SESSION['indice'];?>">Inicio</a> </li>
					<li><a href="index.html">Cambio de Usuario</a></li>
				</ul>
			</div>
		</nav>
		<section id="contenido">
			<form>
				<nav class="lateral">
					<nav class="bbdd">
						<h4>BASE DE DATOS</h4>
						
						<input class="action" type="button" id="copiar" value="Copiar" onclick="guardarBBDD()">
						<input class="action" type="button" id="restaurar" value="Restaurar" onclick="restaurarBBDD()">
					</nav>
				</nav>
				<nav id="subir"></nav>
				<nav class="actividades">
					<h4>ACTIVIDADES DE EMPLEADOS</h4>
					<div class="tareas_anadir">
						<input type="text" id="tarea">
						<input class="anadir" type="button" id="anadir_tarea" value="+" onclick="nuevaTarea()">
					</div>
					<div class="tareas_eliminar">	
						<select id="tareas">
	<?php 	$tareas = getTareas($enlace);
		for ($i=0; $tareas->num_rows > $i; $i++) {
			$tareas->data_seek($i);
			$tarea = $tareas->fetch_row();
 	?>
							<option> <?php echo $tarea[1];?></option>
	<?php 	} ?>
						</select>				
						<input class="eliminar" type="button" id="eliminar_tarea" value="×" onclick="eliminarTarea()">
					</div>
				</nav>
				<nav class="actividades">
<?php
		$caracteristicas = getCaracteristicas($enlace);
		$caracteristicas->data_seek(0);
		$caracteristica = $caracteristicas->fetch_row();
		
		/*$horaInicial = $caracteristica[0];
		$horaFinal = $caracteristica[1];
		$margenTiempoAntesR = $caracteristica[2];
		$margenTiempoDespuesR = $caracteristica[3];
		$maxDiasReservas = $caracteristica[5];*/
?>
					<h4>CONFIGURACION BASICA</h4>
					<table class="tabla_caracteristicas">
						<tr class="nombres_caracteristicas">
							<th class="nom_t">Apertura</th>
							<th class="nom_t">Cierre</th>
							<th class="nom_t">Antes</th>
							<th class="nom_t">Despues</th>
							<th class="nom_t">Dias</th>
						</tr>
						<tr class="campos_caracteristicas">
							<th>
								<input type="text" class="caracteristica" id="apertura" value="<?php echo $caracteristica[0]; ?>" onchange="validarHora(this.id)">
							</th>
							<th>
								<input type="text" class="caracteristica" id="cierre" value="<?php echo $caracteristica[1]; ?>" onchange="validarHora(this.id)">
							</th>
							<th>
								<input type="text" class="caracteristica" id="antes" value="<?php echo $caracteristica[2]; ?>" onchange="validar(this.id)">
							</th>
							<th>
								<input type="text" class="caracteristica" id="despues" value="<?php echo $caracteristica[3]; ?>" onchange="validar(this.id)">
							</th>
							<th>
								<input type="text" class="caracteristica" id="dias" value="<?php echo $caracteristica[5]; ?>" onchange="validar(this.id)">
							</th>
							<th >
								<input class="actualizar" type="button" id="actualizar_caracteristicas" value="(o)" onclick="modificarCaracteristicas()">
							</th>
						</tr>
					</table>
				</nav>
				<div class="contenedor_pistas">
					<nav class="navegacion">
						<ul class="deportes">
<?php
	$deportes = getDeportes($enlace);
	for ($i=0; $deportes->num_rows > $i; $i++) {
		$deportes->data_seek($i);
		$deporte = $deportes->fetch_row();
?>							<li><a href="#<?php echo $deporte[0]; ?>"><?php echo strtoupper($deporte[0]);?></a></li>
<?php	}
?>

							<li><input type="button" id="anadir_deporte" name="annadir_deporte" value="+" onclick="nuevoDeporte(this.id)"></li>
						</ul>
					</nav>
					<div class="pistas">
<?php
	$deportes = getDeportes($enlace);
	for ($i=0; $deportes->num_rows > $i; $i++) {
		$deportes->data_seek($i);
		$deporte = $deportes->fetch_row();
?>	
					<div class="pistas_deporte">
						<h3 id="<?php echo $deporte[0]; ?>"><?php echo strtoupper($deporte[0]); ?></h3>
						<div class="boton_titulo">
							<input class="eliminar" type="button" id="eliminar_deporte_<?php echo $deporte[0]; ?>" value="×" onclick="eliminarDeporte(this.id)">
						</div>
						<table class="tabla_pistas_deporte">
							<tr class="nombres-campos">
								<th class="np">Numero Pista</th>
								<th class="tiempo">Tiempo (min)</th>
								<th class="min">Minimo</th>
								<th class="max">Maximo</th>
								<th > <input class="anadir" type="button" id="anadir_pista_<?php echo $deporte[0]; ?>" value="+" onclick="nuevaPista(this.id)"></th>
							</tr>
<?php
		$pistas = getPistas($enlace, $deporte[0]);
		for ($j=0; $pistas->num_rows > $j; $j++) {
			$pistas->data_seek($j);
			$pista = $pistas->fetch_row();
?>
							<tr class="entradas">
								<th><?php echo $pista[0]; ?></th>
								<th>
									<input type="text" class="pista_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" id="tiempo_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" value="<?php echo $pista[1]; ?>" onchange="validar(this.id)">
								</th>
								<th>
									<input type="text" class="pista_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" id="min_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" value="<?php echo $pista[2]; ?>" onchange="validar(this.id)">
								</th>
								<th>
									<input type="text" class="pista_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" id="max_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" value="<?php echo $pista[3]; ?>" onchange="validar(this.id)">
								</th>
								<th >
									<input class="actualizar" type="button" id="actualizar_pista_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" value="(o)" onclick="modificarPista(this.id)">
								</th>
								<th > 
									<input class="eliminar" type="button" id="eliminar_pista_<?php echo $deporte[0]; ?>_<?php echo $pista[0]; ?>" value="×" onclick="eliminarPista(this.id)">
								</th>
							</tr>
<?php		}?>
						</table>
					</div>
					
<?php
	}
	if ($_SESSION['tipoUsuario'] == 2) {
		mysqli_close($enlace);
	}
?>
				</div>
				</div>
			</form>
		</section>	
		<footer id="pie">
			<p>© ISW 1 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>
	</body>
</html>
