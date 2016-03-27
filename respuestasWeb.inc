<?php
    include_once "connection.inc";
	include_once "sesiones.inc";
	$ruta = '/casaasturias/';
	comprobarVidaSesion();	
		
	function montar ($enlace) {
        $ruta = '/casaasturias/';
		if(!isset($_SESSION['tipoUsuario']) ) {
			return "_ERROR_2";
		}
		$responseCont = '';
		$responseCab = '';

		if ($_SESSION['tipoUsuario'] == 1) {
			$identificacion = 'SOCIO '.$_SESSION['nUsuario'];
		} else if ($_SESSION['tipoUsuario'] == 2) {
			$identificacion = 'EMPLEADO '.$_SESSION['nUsuario'];
		}
				
		$responseCab = cabA();
		$responseCab = $responseCab.$identificacion;
		$aux = cabB();
		$responseCab = $responseCab.$aux;
		$aux = cabC();
		$responseCont = $responseCab.$aux;
		
		$deportes = getDeportes($enlace);
		for ($i=0; $deportes->num_rows > $i; $i++) {
			$deportes->data_seek($i);
			$deporte = $deportes->fetch_row();
			$tit_deporte = strtoupper($deporte[0]);
			$responseCont = $responseCont.'		
					<div class="apartados" id="';
$responseCont = $responseCont.$deporte[0].'">
						<div class="iconA">';
			if ($deporte[1] != null) {
$responseCont = $responseCont.'		<img src="';
$responseCont = $responseCont.$deporte[1].'" alt="'.$deporte[0].'">';
			}
$responseCont = $responseCont.'			</div>
						<div class="descrip-apartado">
							<h3>';
$responseCont = $responseCont.$tit_deporte.'</h3>';
			$pistas = getPistas($enlace, $deporte[0]);
			if ($pistas->num_rows > 0) {
$responseCont = $responseCont.'						<div class="flecha">	
								<select id="';
$responseCont = $responseCont.'selector_'.$deporte[0];
$responseCont = $responseCont.'" class="pistas" onchange="reservarPista2(this.id)" >';

$responseCont = $responseCont.'<option>Pistas:</option>';					
				for ($j=0; $pistas->num_rows > $j; $j++) {
					$pistas->data_seek($j);
					$pista = $pistas->fetch_row();
$responseCont = $responseCont.'	
									<option id="';
$responseCont = $responseCont.$deporte[0]."_".$pista[0];
$responseCont = $responseCont.'" >Pista ';
$responseCont = $responseCont.$pista[0].'</option>';				
				}	
$responseCont = $responseCont.'
								</select></div>';
							
			}
$responseCont = $responseCont.'						</div>
					</div>';		
		}
		if ($_SESSION['tipoUsuario'] == 2) {
			$responseCont = $responseCont.'
					<a href="'.$ruta.'indexModificaciones.php">
					<div class="apartados" id="modificaciones">
						<div class="iconA">
							<img src="'.$ruta.'img/modificacion.png" alt="engranjes">
						</div>
						<div class="descrip-apartado">
							<h3>MODIFICACIONES DE<br/> ESTRUCTURAS</h3>
						</div>	
					</div>
					</a>';
		}
		$aux = cabD();		
		$responseCont = $responseCont.$aux; 		
		return $responseCont;
	}
	function cabA() {
        $ruta = '/casaasturias/';
$cab = "\n";
$cab = $cab.'<!DOCTYPE html>';
$cab = $cab.'<html lang="ES">';
$cab = $cab.'	<head>';
$cab = $cab.'		<title> SOCIEDAD CASA DE ASTURIAS</title>';
$cab = $cab.'		<meta charset="utf-8"/>';
$cab = $cab.'		<link rel="stylesheet" type="text/css" href="'.$ruta.'css/estilo.css">';
$cab = $cab.'		<script type="text/javascript" src="'.$ruta.'js/comprobar.js"></script>';
$cab = $cab.'		<!--[if lt IE 9]>';
$cab = $cab.'		<script src="http://html5shiv.google.com/svn/trunk/html5.js"></script>';
$cab = $cab.'		<![endif]-->';
$cab = $cab.'	</head>';
    
$cab = $cab.'	<body>';
$cab = $cab.'		<header id="cabecera">';
$cab = $cab.'			<img class="logo" src="'.$ruta.'img/casaasturiasescudo.png"></img>';
$cab = $cab.'			<h1>Casa De Asturias En Leon</h1>';
$cab = $cab.'			<img class="logo" src="'.$ruta.'img/casaasturiasescudo.png"></img>';
$cab = $cab.'		</header>';

$cab = $cab.'		<nav id="menu"> ';
$cab = $cab.'			<div class="identificacion">';
$cab = $cab.'				USUARIO: ';
		return $cab;	
	}
	function cabB() {
        $ruta = '/casaasturias/';
		$cab = '
			</div>
			<div class="menu-zona"> 
				<ul class = "lista_menu">
					<li><a href="'.$ruta.'server.php?inicio='.$_SESSION['indice'].'">Inicio</a> </li>
					<li><a href="'.$ruta.'index.html">Cambio de Usuario</a></li>
				</ul>
			</div>
		</nav>';
		return $cab;
	}
	function cabC() {
        $ruta = '/casaasturias/';
		$cab = '
		<section id="contenido">
			<form>
				<div id="principal">';
		return $cab;	
	}
	function cabD() {
        $ruta = '/casaasturias/';
		$cab = '
				</div>
			</form>
		</section>		
		
		<footer id="pie">
			<p>© ISW 2 | 2015-2016 | Cristian Canseco Blanco </p>
		</footer>
	
	</body>
</html>';
		return $cab;
	}
?>				