<?php
	include_once "sesiones.inc";
	$GLOBALS['Alf'] = "A,B,C,D,E,F,G,H,I,J,K,L,M,N,Ñ,O,P,Q,R,S,T,U,V,W,X,Y,Z, ,.,:,-,_,$,%,0,1,2,3,4,5,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,m,n,ñ,o,p,q,r,s,t,u,v,w,x,y,z";

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

	function cifrar() {

	}

	// y1 numero g^b, y2 array de mensaje
	function descifrar($y1, $y2, $pgk, $a) {
		//echo "_OK2_hola1";
		//$pgk = $_SESSION['key_public'];
		//$a = $_SESSION['key_private'];

		//echo "_OK2_hola2";

		$length = count($y2);
		$y1X = 1;
		for ($i=0; $i < $pgk[0]-1-$a; $i++) {
			$y1X = ($y1X * $y1)%$pgk[0];
		}
		$res = [];
		for ($i=0; $i < $length; $i++) {
			//m[i] = m[i]%p;
			$res[$i] = ($y1X * $y2[$i] )%$pgk[0];
		}
		if ($length > 0) {
			return numletras($res);
		} else {
			return "";
		}
	}

	// $numeros array de numeros representativos de caracteres
	function numletras($numeros) {
		$res="";
		$length = count($numeros);
		for($i=0; $i<$length; $i++) {
			$res=$res.''.numletra($numeros[$i]);
		}
		return $res;
	}

	function numletra($x) {
		$Alf = $GLOBALS['Alf'];
		$vec = explode(',',$Alf);
		$i = gmp_intval ($x);
		if ( ($x <0) || ($x >= count($vec) ) ) {
			$res= '-Z';
		} else {
			$res = $vec[$i];
		}
		return $res;
	}
?>
