<?php

	include_once "cifrar.php";


	if ($_POST) {
		$accion=$_POST['accion'];
		if ( $accion == 'gamal') {
			getKey();
			$clavePublica = $GLOBALS['key_public'];
			// p:g:k
			echo "_OK_".$clavePublica[0].":".$clavePublica[1].":".$clavePublica[2]."__";
		} else if ( $accion == 'desencriptar') {
			$y1 = $_POST['y1'];
			$y2 = explode(',', $_POST['y2'] );
			//echo "_OK2_descifrarPHP".$y1.":".$y2[2];
			$palabra = descifrar($y1, $y2,$_SESSION['key_public'],$_SESSION['key_private']);
			//echo "_OK2_".$palabra;
		} else {
			echo "_ERROR_000_";
		}
	}

	function getKey() {
		$p = generarPrimos(1000);
		$a = gmp_random_range(0,$p-3)+2;
		$g = gmp_random_range(0,$p-3)+2;
		//$p=103;$a=38;$g=19;
		$k = ExpModP($g, $a, $p);
		//$k = gmp_powm($g,$a,$p);
		$GLOBALS['key_public'] = [$p,$g,$k];
		$GLOBALS['key_private'] = $a;
		$_SESSION['key_public'] = $GLOBALS['key_public'];
		$_SESSION['key_private'] = $GLOBALS['key_private'];
	}

	function ExpModP($g,$a,$p){
		$k=1;
		for ($i=0; $i<$a; $i++) {
			$k = ($k*$g)%$p;
		}
		return $k;
	}
?>
