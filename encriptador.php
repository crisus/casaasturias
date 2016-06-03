<?php
	include_once "cifrar.php";

	if ($_POST) {
		$accion=$_POST['accion'];
		if ( $accion == 'gamal') {
			getKey();
			$clavePublica = $GLOBALS['key_public'];
			echo "_OK_g:".$clavePublica[0]." p:".$clavePublica[1]." k:".$clavePublica[2]."_".$GLOBALS['key_private']."_";
		} else {
			echo "_ERROR_000_";
		}
	}

	function getKey() {
		$p = generarPrimos(100);
		$a = gmp_random_range(0,$p-1);
		$g = gmp_random_range(0,$p-1);
		$k = ExpModP($g, $a, $p);
		$GLOBALS['key_public'] = [$g,$p,$k];
		$GLOBALS['key_private'] = $a;
	}

	function ExpModP($g,$a,$p){
		$k=$g;
		for ($i=0; $i<$p; $i++) {
			$k = ($k * $k)%$p;
		}
		return $k;
	}
?>
