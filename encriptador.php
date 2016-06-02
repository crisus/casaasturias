<?php
	if ($_POST) {
		$accion=$_POST['accion'];
		if ( $accion == 'gamal') {
			echo "_OK_10_";
		} else {
			echo "_ERROR_000_";
		}
	}
?>
