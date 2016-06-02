<?php
	include_once "cifrar.php";

	if ($_POST) {
		$accion=$_POST['accion'];
		if ( $accion == 'gamal') {
			$clavePublica = getKey();
			echo "_OK_".$GLOBALS['key_public']."_".$GLOBALS['key_private']."_";
		} else {
			echo "_ERROR_000_";
		}
	}

	function getKey() {
		$a = generarPrimos(10);
		$GLOBALS['key_public'] = 10;
		$GLOBALS['key_private'] = $a;
	}
?>
