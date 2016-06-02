<?php

	function generarPrimos($base) {
		$primo = 2;
		// random_int para aleatoriedad segura
		$seleccionPrimo = mt_rand (0, 10);

		for ($i=0; $i < $seleccionPrimo; $i++) {
			$primo = gmp_nextprime ($base );
			$base = $primo;
		}

		return $primo;
	}

?>
