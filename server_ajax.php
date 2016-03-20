<?php
	session_start();
	$ruta = '/casaasturias/';
	$inactivo = 120; //segundos que tardara en cerrarse la session
	if(isset($_SESSION['timeout']) ) {
		$vida_session = time() - $_SESSION['timeout'];
		if($vida_session > $inactivo) {
       			$_SESSION['nUsuario']="";
				$_SESSION['clave']="";
				$_SESSION['tipoUsuario']="";
				$_SESSION['timeout']=0;
				$_SESSION['indice']=0;
       			header("Location: ".$ruta."index.html");
		}
	}

	include_once "connection.inc";

	if ( ($_FILES) && ($_SESSION['tipoUsuario']== 2) ) {
		//echo 'Archivo recibido'.$_FILES['sql']["tmp_name"];
		$nombre_tmp = $_FILES["sql"]["tmp_name"];
	        $nombre = $_FILES["sql"]["name"];
		$tipo = $_FILES["sql"]["type"];
		if ($tipo == 'text/x-sql') {
	        	move_uploaded_file($nombre_tmp, "./backup/$nombre");
			$estado = restaurarCopia("./backup/$nombre","tipo_file");
			if ($estado == 0) {
				echo "RESTAURACION COMPLETA";
			} else {
				echo "ERROR en LA Restauracion";
			}
		} else {
			echo "No es una copia\n de seguridad Valida";
		}

	} else if ( (!$_FILES) && ($_POST) && ($_SESSION['tipoUsuario']== 2) ) {
		//echo 'CONECTANDO';
		$enlace = enlazarBBDD();
		//echo 'CONECTADO';

		$accion = $_POST['accion'];
		$objeto = $_POST['objeto'];
		if ($accion == 'anadir') {
			if ($objeto == 'deporte') {
				// necesitamos el nombre del deporte
				$elemento = $_POST['elemento'];
				//echo $accion." ".$objeto." ".$elemento." OK";
				if ( nuevoDeporte($enlace, $elemento) ) {
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			} else if ($objeto == 'pista'){
				// necesitamos el nombre del deporte
				$elemento = $_POST['elemento'];
				if ( nuevaPista($enlace, $elemento) ) {
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			} else if ($objeto == 'tarea') {
				$elemento = $_POST['elemento'];
				if ( nuevaTarea($enlace, $elemento) ) {
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			}
		} else if ($accion == 'eliminar') {
			if ($objeto == 'deporte') {
				// necesitamos el nombre del deporte
				$elemento = $_POST['elemento'];
				//echo $accion." ".$objeto." ".$elemento." OK";
				if (eliminarDeporte($enlace, $elemento) ){
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			} else if ($objeto == 'pista') {
				// necesitamos el nombre del deporte
				$elemento = $_POST['elemento'];
				$posicion = $_POST['posicion'];
				if ( eliminarPista($enlace, $elemento, $posicion) ) {
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			} else if ($objeto == 'tarea') {
				$posicion = $_POST['posicion'];
				if ( eliminarTarea($enlace, $posicion) ) {
					echo "_OK_";
				} else {
					echo "_ERROR_";
				}
			}
		} else if ($accion == 'actualizar') {
			// necesitamos el nombre del deporte
			$elemento = $_POST['elemento'];
			$posicion = $_POST['posicion'];
			$tiempo = $_POST['valor0'];
			$minimo = $_POST['valor1'];
			$maximo = $_POST['valor2'];
			if ( actualizar ($enlace, $elemento, $posicion, $tiempo, $minimo, $maximo) )
			{
				echo "_OK_";
			} else {
				echo "_ERROR_";
			}
		} else if ($accion == 'copia') {
			$descarga =$_POST['descargar'];
			//echo "dato:".$descarga;
			echo copiaSeguridad($descarga);
		} else if ($accion == 'recuperar') {
			$objeto = $_POST['objeto'];
			if ($objeto=='sql') {
				$contenido = listar_archivos("./backup");
				echo $contenido;
			} else if ($objeto=='sql2') {
				$n_date = $_POST['elemento'];
				$estado = restaurarCopia($n_date,"tipo_date");
				if ($estado == 0) {
					echo "_OK_RESTAURACION COMPLETA";
				} else {
					echo "_ERROR_ en LA Restauracion";
				}
			} else {
				echo '_ERROR_Problemas en los mensajes';
			}
		} else if ($accion == 'modificar') {
			$horaInicial = $_POST['dat0'];
			$horaFinal = $_POST['dat1'];
			$margenTiempoAntesR = $_POST['dat2'];
			$margenTiempoDespuesR = $_POST['dat3'];
			$maxDiasReservas = $_POST['dat4'];
			echo setCaracteristicas($enlace,$horaInicial,$horaFinal,$margenTiempoAntesR,$margenTiempoDespuesR,$maxDiasReservas);
		} else {
			echo '_ERROR_'.$accion.'_';
		}
		mysqli_close($enlace);
	} else if ($_SESSION['tipoUsuario']!= 2) {
		echo "_ERROR_-2_";
	} else {
		echo "_ERROR_-2_";
	}
	

	function listar_archivos($carpeta){
		$contenido = "_ERROR_NO EXISTE BACKUP";
		if(is_dir($carpeta)){

			if($dir = opendir($carpeta)){
				$contenido="<select id='sql' name='sql' class='busqueda'>";
				while(($archivo = readdir($dir)) != false){
					$ide2= ".sql";
					if(($archivo != '.') && ($archivo != '..') && ($archivo != '.htaccess') && (strpos($archivo,$ide2)>=0) ){
						$ide= "programador";

						$total= strpos($archivo,$ide2);
						$cadena = substr ($archivo,0,$total);
						$parcial = substr ($cadena,0,strlen($ide));
						if (strcmp($parcial, $ide) == 0) {
							$cadena = substr ($cadena,strlen($ide),strlen($cadena));
						}
						$contenido=$contenido."<option id=$cadena>$cadena</option>";
					}
				}
				$contenido=$contenido."</select>";
				closedir($dir);
			}
		}
		return $contenido;
	}

?>
