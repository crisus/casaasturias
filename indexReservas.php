<?php

	//session_start();
    include_once "connection.inc";
	include_once "sesiones.inc";
	//echo 'tipo sesion: '.$_SESSION['tipoUsuario'];
	$ruta = '/casaasturias/';
	comprobarVidaSesion();
	//echo 'tipo sesion: '.$_SESSION['tipoUsuario'];
	if ( ($_SESSION['nUsuario']) && ($_GET) ) {
		$deporte = $_GET['v1'];
		$pista = (int) $_GET['v2'];
		$incrementoFecha = $_GET['ifecha'];
		$enlace = enlazarBBDD();
	} else {
		header("Location: ".$ruta."index.html");
	}
	//$fecha = date("d-m-Y");
	$fecha = date("d-m-Y", mktime(0, 0, 0, date("m")  , date("d")+$incrementoFecha, date("Y") ) );
	$horaActual = date("H:i");

	$caracteristicas = getCaracteristicas($enlace);
	$caracteristicas->data_seek(0);
	$caracteristica = $caracteristicas->fetch_row();
	$maxDiasReservas = $caracteristica[5];
	$horaInicial = $caracteristica[0];
	$horaFinal = $caracteristica[1];
	$margenTiempoAntesR = $caracteristica[2]*60;
	$margenTiempoDespuesR = $caracteristica[3]*60;
	//echo 'tipo sesion: '.$_SESSION['tipoUsuario'];
?>
<!DOCTYPE html>
<html lang="ES">
	<head>
		<title> SOCIEDAD REAL CASA DE ASTURIAS</title>
		<meta charset="utf-8"/>
		<link rel="stylesheet" type="text/css" href="<?php echo $ruta;?>css/estilo.css">
		<script type="text/javascript" src="<?php echo $ruta;?>js/comprobar.js"></script>
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
			<form>
				<div class="informacion">
					<h4 id="deporte"><?php echo strtoupper($deporte); ?></h4>
					<h4 id="pista">Pista: <?php echo $pista; ?></h4>
					<div class="fecha">
<?php if ($incrementoFecha > 0) { ?>
					<input class="nav_fecha" id="ayer" type="button" value="<" onclick="undiamenos(<?php echo '\''.$deporte.'\','.$pista.','.$incrementoFecha; ?>)">
<?php } ?>
					<h4 id="fecha"><?php echo $fecha; ?></h4>
<?php if ($incrementoFecha < $maxDiasReservas) { ?>
					<input class="nav_fecha" id="futuro" type="button" value=">" onclick="undiamas(<?php echo '\''.$deporte.'\','.$pista.','.$incrementoFecha; ?>)">
<?php } ?>
					</div>
					<h4 id="hora"><?php echo $horaActual; ?></h4>
				</div>
<?php
	$pistas = getPistas($enlace, $deporte);
	$pistas->data_seek($pista-1); // tabla de base de datos se inicia en 0
	$actual = $pistas->fetch_row();
//	    numero pista     tiempo		min players	max players
	if ( ($actual[0]) && ($actual[1]) && ($actual[2]) && ($actual[3]) ) {
?>
				<div class="reservas">
					<table class="tablaReservas">
						<tr class="nombres-campos">
							<th class="hora">Bloque</th>
							<th class="numero">N. Socio</th>
							<th class="nombre">Nombre</th>
							<th class="firma">Firma</th>
							<th class="observaciones">Observaciones</th>
						</tr>
		<?php
		$tiempoBloque = $actual[1];
		$segActual = strtotime($horaActual);
		$segInicial = strtotime($horaInicial);
		$principio = $segInicial;
		$segFinal = strtotime($horaFinal);
		$segBloque = $tiempoBloque*60;
		//$margenTiempo = 5*60;
		$i=1;
		$nbtActual = 0;
		if ( ($segActual > $principio) && ($segActual < $segFinal) ) {
			$x = $segInicial;
			while ($x < $segActual) {
				$x= $x + $segBloque;
				$nbtActual= $nbtActual + 1;
			}
		} else {
			$nbtActual = -1;
		}
		$nbtActual2 = ($segActual-$segInicial) / $segBloque;
		//echo "bloque:_".$nbtActual."_".$nbtActual2;
		while ( ( $segInicial+$segBloque <= $segFinal) && ($i < 100) ) {
			// Al final del bucle
			// $segInicial = $segInicial+$segBloque;
			// $i++;
			$posicionFirma = 0;
			$consulta = null;
			$consulta2 = null;
			if ( ($segActual >= $segInicial-$margenTiempoAntesR) && ($segActual <= $segInicial+$margenTiempoDespuesR) ) 				{
				$confirmarReserva = 1;
			} else {
				$confirmarReserva = 0;

			}
			if ( ($segActual >= $segInicial-$margenTiempoAntesR) && ($segActual <= $segInicial+$segBloque-$margenTiempoAntesR) ) 				{
				$cogerPista = 1;
			} else {
				$cogerPista = 0;

			}
			$puedeConfirmar = $confirmarReserva;
?>
						<tr class="entradas">
							<th class="hora">
				<?php echo date("H:i",$segInicial)." a ".date("H:i",$segInicial+$segBloque);?>
							</th>
							<th class="numero">
<?php			if ( ($segActual+$margenTiempoAntesR  >= $segInicial) && ($incrementoFecha == 0) ){
				$consulta = getFirmadas($enlace, $deporte,$pista,$fecha,$i );
				$firma = 1;
				$hayReservas = false;
				//echo "firmadas";
				if ($cogerPista == 1) {
					$consulta2 = getReservas($enlace, $deporte,$pista,$fecha,$i );
					$hayReservas = true;
					//echo "reservas";
				}
			} else if ( ($segInicial > $segActual) || ($incrementoFecha>0) ) {
				$consulta = getReservas($enlace, $deporte,$pista,$fecha,$i );
				$firma = 0;
				$hayReservas = false; // a false porque es falso que reservas esten en consulta2
				//echo "reservas";
			}
	// NUMERO DE IDENTIFICACION USUARIOS
			$hayTarea= false;
			if ($consulta->num_rows > 0) {
				$consulta->data_seek(0);
				$reserva = $consulta->fetch_row();
				if ($reserva[0] == 'PERSONAL') {
					$hayTarea = true;
				}
			}
			$s =0;
			$hayFirmada = false;
			for ($j=1; ($j <= $actual[3]) && (!$hayTarea); $j++)
			{
				$t = $j-1;
				if ($consulta->num_rows > $t) // firmadas o reservadas
				{
					$hayFirmada = true; // solo es utilizado en caso de existir consulta2
					$consulta->data_seek($t);
					$reserva = $consulta->fetch_row(); ?>
					<input type="text" id="nUsuario_<?php echo $i.'_'.$j; ?>" value="<?php echo $reserva[0]; ?>"
<?php					if ($reserva[0] == $_SESSION['nUsuario'])
					{
						$posicionFirma = $j;
					}
					// Modificar la propia reserva
					if ( ( ($reserva[0] == $_SESSION['nUsuario']) || ($_SESSION['tipoUsuario'] == 2) ) && ( ( (($i-1)*$segBloque)+$principio > $segActual) || ($incrementoFecha>0 ) ) )
					{?>
						 onchange="comprobar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i.' , '.$nbtActual; ?>)">
<?php					} else
					{?>
						disabled>
<?php					}
				} else if ( ($consulta2 != null) && ($consulta2->num_rows > $s) ) // reservadas cuando hay firmadas
				{

					$consulta2->data_seek($s);
					$libre = 0;
					$s = $s+1;
					$reserva = $consulta2->fetch_row();
					if ($hayFirmada) {
						$puedeConfirmar = $cogerPista;
					}else {
						$puedeConfirmar = $confirmarReserva;
					}
					$yaFirmado=false;
					for ($c = 0; $consulta->num_rows > $c; $c++) {
						$buscando->data_seek($c);
						$buscado = $buscando->fetch_row();
						if ($buscado[0] == $reserva[0]) { $yaFirmado= true; }
					}
					if (!$yaFirmado) {
						if ($puedeConfirmar == 1) {?>
							<input type="text" id="nUsuario_<?php echo $i.'_'.$j; ?>" value="<?php echo $reserva[0]; ?>"
<?php						} else { ?>
							<input type="text" id="nUsuario_<?php echo $i.'_'.$j; ?>" value="xxxxx/xx"
<?php						}
						if ($reserva[0] == $_SESSION['nUsuario']) {
							$posicionFirma = $j;
						}
						// Modificar la propia reserva
						if ( ( ($reserva[0] == $_SESSION['nUsuario']) || ($_SESSION['tipoUsuario'] == 2) ) && ( ( (($i-1)*$segBloque)+$principio > $segActual) || ($incrementoFecha>0 ) ) )
						{?>
							 onchange="comprobar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i.' , '.$nbtActual; ?>)">
<?php						} else
						{?>
							disabled>
<?php						}?>
<?php					} else { $j--;}
				} else
				{ ?>
					<input type="text" id="nUsuario_<?php echo $i.'_'.$j; ?>" value="xxxxx/xx" onchange="comprobar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i.' , '.$nbtActual; ?>)"
<?php 					if ( ((($i-1)*$segBloque)+$principio <= $segActual) && ($incrementoFecha ==0) )
					{ ?>
						disabled>
<?php					} else
					{ ?>
						>
<?php					}
				}
			} // fin for
			if ($_SESSION['tipoUsuario'] == 2) {?>
				<input class="select_tareas" type="text" disabled>
<?php			}?>
							</th>
							<th class="nombre">
<?php	// NOMBRES
			if ($hayTarea) { ?>
				<input type="text" id="nombre_<?php echo $i.'_'.$j; ?>" value="<?php echo $reserva[1]; ?>" disabled>
<?php			}
			$s=0;
			$hayFirmada = false;
			for ($j=1; ($j <= $actual[3]) && (!$hayTarea); $j++) {
				if ( $j-1 < $consulta->num_rows)
				{
					$hayFirmada = true; // solo es utilizado en caso de existir consulta2
					$consulta->data_seek($j-1);
					$reserva = $consulta->fetch_row();
			?>
					<input type="text" id="nombre_<?php echo $i.'_'.$j; ?>" value="<?php echo $reserva[1]; ?>" disabled>
<?php 				} else if ( ($consulta2 != null) && ($consulta2->num_rows > $s) )
				{
					$consulta2->data_seek($s);
					$s+=1;
					$reserva = $consulta2->fetch_row();
					if ($hayFirmada) {
						$puedeConfirmar = $cogerPista;
					}else {
						$puedeConfirmar = $confirmarReserva;
					}
					$yaFirmado=false;
					for ($c = 0; $consulta->num_rows > $c; $c++) {
						$buscando->data_seek($c);
						$buscado = $buscando->fetch_row();
						if ($buscado[0] == $reserva[0]) { $yaFirmado= true; }
					}
					if (!$yaFirmado) {
						if ($puedeConfirmar == 1) {?>
							<input type="text" id="nombre_<?php echo $i.'_'.$j; ?>" value="<?php echo $reserva[1]; ?>" disabled>
<?php						} else { ?>
							<input type="text" id="nombre_<?php echo $i.'_'.$j; ?>" value="" disabled>
<?php						}
					} else { $j--; }
				} else
				{ ?>
					<input type="text" id="nombre_<?php echo $i.'_'.$j; ?>" value="" disabled>
<?php				}
			} // fin for
			if ($_SESSION['tipoUsuario'] == 2) {
				$consulta_actividades = getActividades($enlace); ?>
				<select class="tareas"
<?php 				if ( ((($i-1)*$segBloque)+$principio <= $segActual) && ($incrementoFecha==0) ) { ?>
						disabled>
<?php 				} else { ?>
						>
<?php				}
				for ($k=0; $k < $consulta_actividades->num_rows; $k++) {
					$consulta_actividades->data_seek($k);
					$actividad = $consulta_actividades->fetch_row(); ?>
					<option id="tarea_<?php echo $i.'_'.$j.'_'.$actividad[0]; ?>" onclick="reservar(this.id,'<?php echo $deporte; ?>',<?php echo $pista.','.$i; ?>)"> <?php echo $actividad[1]; ?></option>

<?php				}?>
				</select>
				<button onclick="mostrarDialogo()"><img src="<?php echo $ruta;?>img/icon-cal.png" alt="Cal" width="15" height="15"></button>
<?php			} ?>

							</th>
							<th class="firma">
<?php   // FIRMA
			$libre = 1;
			$s = 0;
			if ($_SESSION['puede_firmar'] == 0) {
				$puedeConfirmar = 0;
			} else if ($_SESSION['puede_firmar'] == 1) {
				$puedeConfirmar = $cogerPista;
			}

			$hayFirmada = false;
			for ($j=1;($j <= $actual[3]) && (!$hayTarea); $j++) {
				if ( $j-1 < $consulta->num_rows)  // firmadas o reservadas
				{
					$hayFirmada = true;
					$libre=0;
					$consulta->data_seek($j-1);
					$reserva = $consulta->fetch_row(); ?>
					<input type="checkbox" id="firma_<?php echo $i.'_'.$j; ?>" value="" <?php if ( ( ($puedeConfirmar==0) || ($j != $posicionFirma) ) || ($incrementoFecha>0) || ($_SESSION['tipoUsuario'] == 2) ) {echo 'disabled';} ?> onclick="firmar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i; ?>)" <?php if ($firma==1) {echo 'disabled checked'; }?> >
<?php				} else if ( ($consulta2 != null) && ($consulta2->num_rows > $s) ) // reservadas cuando hay firmadas
				{
					$libre = 0;
					$s = $s+1;
					if ($hayFirmada) {
						$puedeConfirmar = $cogerPista;
					}else {
						$puedeConfirmar = $confirmarReserva;
					}
					$yaFirmado=false;
					for ($c = 0; $consulta->num_rows > $c; $c++) {
						$buscando->data_seek($c);
						$buscado = $buscando->fetch_row();
						if ($buscado[0] == $reserva[0]) { $yaFirmado= true; }
					}
					if (!$yaFirmado) {
?>
						<input type="checkbox" id="firma_<?php echo $i.'_'.$j; ?>" <?php if ( ( ($puedeConfirmar==0) || ($j != $posicionFirma) ) || ($incrementoFecha>0) || ($_SESSION['tipoUsuario'] == 2) ) {echo 'disabled';} ?> onclick="firmar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i; ?>)" >
<?php					} else { $j--;}
				} else // resto
				{
					if ( ($consulta2!=null)&&($consulta2->num_rows==0) ) { $libre=1;}
?>
					<input type="checkbox" id="firma_<?php echo $i.'_'.$j; ?>"  <?php if ( ( ($libre==0) || ($puedeConfirmar==0) ) || ($incrementoFecha>0) || ($_SESSION['tipoUsuario'] == 2) ) {echo "disabled"; }?> onclick="firmar(this.id, '<?php echo $deporte; ?>' , <?php echo $pista.' , '.$i; ?>)">
<?php			 	}
			}
			if ($_SESSION['tipoUsuario'] == 2) {?>
				<input class="select_tareas" type="text" disabled>
<?php			}?>
							</th>


<?php			// boton descripcion de desperfectos         ?>
							<th class="observaciones" id="observaciones_<?php echo $i;?>">
								<button class="button-observaciones" id="boton_quejas_<?php echo $deporte.'_'.$pista.'_'.$i; ?>" onclick="generarObservacion(this.id)">OBSERVACIONES</button>
							</th>
						</tr>
<?php			//} else {
				//$consulta = getFirmadas($enlace, $deporte,$pista,$fecha,$i );
				//$consulta2 = getReservas($enlace, $deporte,$pista,$fecha,$i );
				//if ($consulta->num_rows > 0) {

				//}
			//}
			$segInicial = $segInicial+$segBloque;
			$i++;
		}
		?>

					</table>
				</div>
			</form>
		</section>
<?php
	} else {
		echo 'PROBLEMAS';
	}
	if ($_SESSION['nUsuario']) {
		mysqli_close($enlace);
	}
?>
		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>

	</body>
</html>
