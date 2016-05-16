<?php
	$ruta = '/casaasturias/'; 
	date_default_timezone_set("Europe/Madrid");

	function enlazarBBDD() {
		$host="localhost";
		$user="reservas";
		$passBBDD="sekret";
		$nombreBBDD="programador";
        $port="3306";
        $socket="MySQL57";
		$enlace = new MySQLi($host,$user,$passBBDD,$nombreBBDD,$port);
		if (!$enlace) {
			echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    			echo "errno de depuración: ".mysqli_connect_errno().PHP_EOL;
    			echo "error de depuración: ".mysqli_connect_error().PHP_EOL;
			exit;
		}
		return $enlace;
	}

	function copiaSeguridad($descargar) {
		$ruta="/casaasturias/";
		$host="localhost";
		$user="reservas";
		$passBBDD="sekret";
		$nombreBBDD="programador";
        $port="3306";
        $socket="MySQL57";

		$backup_file = $nombreBBDD.date("Y-m-d-H-i-s").".sql";
		$command = "mysqldump --opt -h $host  $nombreBBDD -u $user -p$passBBDD --default-character-set=utf8 -r \"./backup/$backup_file\"";
		system($command,$output);
		if ($descargar==1) {
			//$_SERVER['SERVER_NAME'].
			echo $ruta."backup/$backup_file";
		} else {		
			echo $output;
		}
	}

	function restaurarCopia($n_file, $tipo) {
		$host="localhost";
		$user="root";
		$passBBDD="sekret";
		$nombreBBDD="programador";
		//crear bbdd
		$datos_de_conexion = mysqli_connect($host, $user, $passBBDD);
		$consulta = "CREATE DATABASE IF NOT EXITS $nombreBBDD"; 
		$resultado = mysqli_query($datos_de_conexion, $consulta); 

		// leer archivo de restauracion
		if ($tipo == 'tipo_file') {
			$file = $n_file;
		} else if ($tipo == 'tipo_date') {
			$file = "./backup/".$nombreBBDD.$n_file.".sql";
		}
		$command = "mysql -u $user -p$passBBDD $nombreBBDD --default-character-set=utf8 < $file";
		system($command,$output);
		//echo $n_file.$tipo.$file;
		return $output;		
	}
	
	function comprobarUsuario($enlace, $idUsuario, $clave) {
		$campoNumero = 'id_usuario';
		$campoPass = 'clave';
		$campoTipo = 'tipo';
		$tablaUsuarios = 'usuario';
		$nombreBBDD="programador";
	
		// SELECT `clave`,`tipo` FROM `programador`.`usuario` WHERE `id_usuario`='00020/00';
		$consulta = 'SELECT `';
		$consulta = $consulta.$campoPass;
		$consulta = $consulta.'` , `';
		$consulta = $consulta.$campoTipo;
		$consulta = $consulta.'` FROM `';
		$consulta = $consulta.$nombreBBDD;
		$consulta = $consulta.'`.`';
		$consulta = $consulta.$tablaUsuarios;
		$consulta = $consulta.'` WHERE `';
		$consulta = $consulta.$campoNumero;
		$consulta = $consulta.'` = \'';
		$consulta = $consulta.$idUsuario;
		$consulta = $consulta.'\'; ';

		$resultado = $enlace->query($consulta);
		if ($resultado) {
			$m1 = "ERROR";
			if ($resultado->num_rows == 1) {
				$resultado->data_seek(0);
				$fila = $resultado->fetch_row();
				if ($fila[0] == $clave) {
					$m1 = $fila[1];
				} else {
					$m1 = "ERROR";
				}
			} else {
				$m1 = "ERROR";
			}
			
			$resultado->close();
			return $m1;
		} else {
			return "SIN BBDD";
		}
	}
	
	function getCaracteristicas($enlace) {
		$tabla = '`caracteristicas`';
		$nombreBBDD="programador";

		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tabla;
		$consulta = $consulta.'; ';
		// SELECT `deporte`,`iconA` FROM `programador`.`deportes`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function getDeportes($enlace) {
		//SELECT `deportes`.`deporte` , `deportes`.`iconA` FROM `deportes`
		$tablaDeportes = '`deportes`';
		$campoRutaIcono = '`deportes`.`iconA`';
		$campoDeporte = '`deportes`.`deporte`';
		$nombreBBDD="programador";
		
		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaDeportes;
		$consulta = $consulta.'; ';
		// SELECT `deporte`,`iconA` FROM `programador`.`deportes`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function getActividades($enlace) {
		$tablaActividades = '`programador`.`actividades`';
		$nombreBBDD="programador";
		
		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaActividades;
		$consulta = $consulta.'; ';
		// SELECT * FROM `actividades`
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function getPistas($enlace, $deporte) {
		$tablaDeporte = "`".$deporte.'`';
		$campoNumeroPista = $tablaDeporte.'`np`';
		$nombreBBDD="programador";

		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaDeporte;
		$consulta = $consulta.'; ';

		// SELECT * FROM `programador`.`tenis`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function getTareas($enlace) {
		$tabla = '`actividades`';
		$nombreBBDD="`programador`";

		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tabla;
		$consulta = $consulta.'; ';

		// SELECT * FROM `programador`.`tenis`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function nuevoDeporte($enlace, $deporte) {
		$deporte = strtolower($deporte);
		//INSERT INTO `programador`.`deportes` (`deporte`, `iconA`, `numero_pistas`) VALUES ('tenis', NULL, NULL);
		$peticion1 = "INSERT INTO `programador`.`deportes` (`deporte`,`iconA`, `numero_pistas`) VALUES ('".$deporte."', NULL, NULL);";
		//"CREATE TABLE IF NOT EXISTS `programador`.`pistas_tenis` (`np` INT(2) NOT NULL,`tiempo` INT(3),`min` INT(1),`max` INT(1),PRIMARY KEY (`np`)	);";
		$peticion2 = "CREATE TABLE IF NOT EXISTS `programador`.`".$deporte."` (`np` INT(2) NOT NULL,`tiempo` INT(3) NULL,`min` INT(2) NULL,`max` INT(2) NULL,PRIMARY KEY (`np`));";
		$resultado = $enlace->query($peticion1);
		$resultado = $enlace->query($peticion2);
		return $resultado;
	}

	function eliminarDeporte ($enlace, $deporte) {
		//DELETE FROM `programador`.`deportes` WHERE `deportes`.`deporte` = \'tenis\'
		$peticion1 = "DELETE FROM `programador`.`deportes` WHERE `deportes`.`deporte`='".$deporte."';";
		//"DROP TABLE ``fronton``"
		$peticion2 = "DROP TABLE `".$deporte."`;";
		$resultado = $enlace->query($peticion1);
		$resultado = $enlace->query($peticion2);
		return $resultado;
	}

	function nuevaPista($enlace, $deporte) {
		$pistas = getPistas($enlace, $deporte);
		$numero = 0;
		$j=0;
		while ( ($pistas->num_rows > $j) && ($numero == 0) ) {
			$pistas->data_seek($j);
			$pista = $pistas->fetch_row();
			if ($pista[0] != $j+1) {
				$numero = $j+1;
			}
			$j++;
		}
		if ($pistas->num_rows == $j) {
			$numero = $j+1;
		}
		//INSERT INTO `programador`.`tenis` (`np` ,`tiempo` ,`min` ,`max`)VALUES ('1', '60', '2', '6');
		//INSERT INTO `programador`.`tenis` (`np`, `tiempo`, `min`, `max`) VALUES ('1',NULL, NULL, NULL);
		$peticion1 = "INSERT INTO `programador`.`".$deporte."` (`np`,`tiempo`, `min`, `max`) VALUES ('".$numero."',NULL, NULL, NULL);";
		$resultado = $enlace->query($peticion1);
		return $resultado;
	}

	function eliminarPista($enlace, $deporte, $posicion) {
		//DELETE FROM `programador`.`tenis` WHERE `tenis`.`np` = 2
		$peticion1 = "DELETE FROM `programador`.`".$deporte."` WHERE `".$deporte."`.`np`=".$posicion.";";
		//echo $peticion1;
		$resultado = $enlace->query($peticion1);
		return $resultado;
	}

	function setCaracteristicas ($enlace, $horaInicial, $horaFinal, $margenTiempoAntesR, $margenTiempoDespuesR, $maxDiasReservas){
		$peticion = "UPDATE `programador`.`caracteristicas` SET `hora_apertura` = '$horaInicial', `hora_cierre` = '$horaFinal', `minutos_antes_reserva` = '$margenTiempoAntesR', `minutos_despues_reserva` = '$margenTiempoDespuesR', `dias_para_reservar` = '$maxDiasReservas' WHERE `caracteristicas`.`id` =1;";
		$resultado = $enlace->query($peticion);
		return "_OK_";
	}
	
	function actualizar ($enlace, $deporte, $posicion, $tiempo, $minimo, $maximo) {
		// UPDATE `programador`.`futbol` SET `tiempo` = '120', `min` = '22', `max` = '22' WHERE `futbol`.`np` =1;
		$peticion1 = "UPDATE `programador`.`".$deporte."` SET `tiempo`='".$tiempo."', `min`='".$minimo."', `max`='".$maximo."'  WHERE `".$deporte."`.`np`=".$posicion.";";
		$resultado = $enlace->query($peticion1);
		return $resultado;
	}

	//$tabla4="CREATE TABLE IF NOT EXISTS `programador`.`reservas` (`n_socio` VARCHAR(8),`fecha` DATE,`deporte` VARCHAR(45),`np` INT(2),`nbTiempo` INT(2),`confirmacion` BOOLEAN);";
// SELECT * FROM `reservas` WHERE `fecha` = '2015-12-29' AND `deporte` LIKE 'tenis' AND `np` =2 AND `nbTiempo` =3

	function getReservas ($enlace, $deporte,$pista,$fecha,$nbt ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');
		
		$tablaReservas = '`reservas`';
		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaReservas;
		$consulta = $consulta." WHERE ";
		$consulta = $consulta.' `fecha`=\''.$date.'\' AND';
		$consulta = $consulta.' `deporte`=\''.$deporte.'\' AND';
		$consulta = $consulta.' `np`=\''.$pista.'\' AND';
		$consulta = $consulta.' `nbTiempo`=\''.$nbt.'\';';
		//echo $consulta;
		// SELECT * FROM `programador`.`tenis`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function getFirmadas ($enlace, $deporte,$pista,$fecha,$nbt ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');
		
		$tablaReservas = '`firmadas`';
		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaReservas;
		$consulta = $consulta." WHERE ";
		$consulta = $consulta.' `fecha`=\''.$date.'\' AND';
		$consulta = $consulta.' `deporte`=\''.$deporte.'\' AND';
		$consulta = $consulta.' `np`=\''.$pista.'\' AND';
		$consulta = $consulta.' `nbTiempo`=\''.$nbt.'\';';
		//echo $consulta;
		// SELECT * FROM `programador`.`tenis`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}

	function buscarSocio($enlace, $usuario, $date, $deporte) {
		$hoy = date("Y-m-d");
		//$date = $datetime->format('Y-m-d');
		
		$pistas = getPistas($enlace, $deporte);

		$caracteristicas = getCaracteristicas($enlace);
		$caracteristicas->data_seek(0);
		$caracteristica = $caracteristicas->fetch_row();
		
		$horaInicial = $caracteristica[0];
		$horaFinal = $caracteristica[1];
		$segInicial = strtotime($horaInicial);
		$segFinal = strtotime($horaFinal);
		
		$horaActual = date("H:i");
		$segActual = strtotime($horaActual);
		$i=0;
		/* buscar en cada pista, calculando el nbt correspondiente segun bloque de tiempo de la propia pista*/
		while ($i < $pistas->num_rows) {
			$pistas->data_seek($i);
			$pista = $pistas->fetch_row();
			
			$tiempoBloque = $pista[1];
			$segBloque = $tiempoBloque*60;
		
			// Calculado el bloque actual para la pista que se va a comparar
			//$nbtActual2 = ($segActual-$segInicial) / $segBloque;
			$nbtActual = 1;
			if ( ($segActual > $segInicial) && ($segActual < $segFinal) && ($hoy == $date)) {
				$x = $segInicial;
				while ($x < $segActual) {
					$x= $x + $segBloque;
					$nbtActual= $nbtActual + 1;	
				}
			} else {
				$nbtActual = -1;
			}
			
			// reservas, a partir de la hora actual, no puede haber mas reservas, antes si puede haberlas estando sin firmar, en caso de firmadas se evalua en el siguiente bloque
			$pista = $i+1;
			$peticion= " SELECT * FROM `programador`.`reservas` WHERE `reservas`.`n_socio` LIKE '".$usuario."' AND `reservas`.`fecha`='".$date."' AND `reservas`.`deporte` LIKE '".$deporte."' AND `reservas`.`np`=$pista AND `reservas`.`nbTiempo` >= $nbtActual;";
			
			//echo $peticion;
			$consulta = $enlace->query($peticion);
			if ($consulta->num_rows >= 1) {
				return true;
			}
			
			// firmadas, todo el dia no puede contenr otra pista firmada
			$peticion= " SELECT * FROM `programador`.`firmadas` WHERE `firmadas`.`n_socio` LIKE '".$usuario."' AND `firmadas`.`fecha`='".$date."' AND `firmadas`.`deporte` LIKE '".$deporte."' AND `firmadas`.`np`=$pista ;";
			$consulta = $enlace->query($peticion);
			if ($consulta->num_rows >= 1) {
				return true;
			}
			//echo $i;
			$i++;
		}	
		return false;	
	}

	function reservar ($enlace, $usuario ,$deporte, $pista, $nbTiempo, $nbtActual, $fecha ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');

		// REVISAR tablas de reservas y firmadas para que solo disponga de un uso diario
		if ( buscarSocio($enlace, $usuario, $date, $deporte) ) {
			return "_ERROR_3_";
		}
		// Si no has reservado, ni jugado, localizamos tu nombre para registrarte la reserva
		$peticion= " SELECT * FROM `programador`.`usuario` WHERE `id_usuario` LIKE '".$usuario."';";
		$consulta = $enlace->query($peticion);
		
		if ($consulta->num_rows == 1) {
			$consulta->data_seek(0);
			$resultado = $consulta->fetch_row();
			$nombre = $resultado[1];
// INSERT INTO `programador`.`reservas` (`n_socio`, `nombre`, `fecha`, `deporte`, `np`, `nbTiempo`, `confirmacion`) VALUES ('00020/00', 'ana', '2015-12-29', 'tenis', '2', '3', '0');		
			$peticion = "INSERT INTO `programador`.`reservas` (`n_socio`,`nombre`,`fecha`, `deporte`, `np`, `nbTiempo`) VALUES ('".$usuario."','".$nombre."','".$date."', '".$deporte."', '".$pista."','".$nbTiempo."');";
			//echo $peticion;
			$consulta = $enlace->query($peticion);
			if ($consulta) {
				return "_OK_4_".$nombre."_";
			} else {
				return "_ERROR_1_";
			}
		} 
		return "_ERROR_2_";
	}
	

	function setQueja($enlace, $deporte, $pista, $observacion, $asunto) {
		$hoy = date("Y-m-d");
		$user = $_SESSION['nUsuario'];

// INSERT INTO `programador`.`observaciones` (`deporte`, `pista`, `asunto`, `observacion`, `n_socio`, `fecha`, `archivada`, `realizada`) VALUES ('padel', '2', 'mal estado', 'red alta', '00001/00', '2016/03/05', '0', '0');
	
	
		$peticion = "INSERT INTO `programador`.`observaciones` (`deporte`, `pista`, `asunto`, `observacion`, `n_socio`, `fecha`,   `archivada`, `realizada`) VALUES ('".$deporte."','".$pista."','".$asunto."','".$observacion."', '".$user."' , '".$hoy."',  '0', '0');";
		
		//echo '_'.$peticion.'_';
		$consulta = $enlace->query($peticion);
		if ($consulta) {
			return true;
		}
	
		return false;
	}
	
	/*
	*	Funcion que retorna las quejas almacenadas,
	* 	Se ha desarrollado en base a la prueba de equivalencia, de datos buscados
	*/
	function getQuejas($enlace, $realizada, $archivada, $sinVer) {
		$hoy = date("Y-m-d");
	
		$tablaReservas = '`programador`.`observaciones`';
		$consulta = 'SELECT * FROM ';
		$consulta = $consulta.$tablaReservas;
		if ( ($sinVer=='0') || ($archivada=='0') ) {
			$consulta = $consulta." WHERE ";
		} else if ($realizada=='0') {
			$consulta = $consulta." WHERE ";
		} 
		//$consulta = $consulta.' `fecha`=\''.$hoy.'\' AND';
		if ($sinVer == 0) {
			$consulta = $consulta.' `archivada`=\''.$archivada.'\'';
			$consulta = $consulta.' AND `realizada`=\''.$realizada.'\'';
		} else if ($sinVer == 1) {
			if  ($realizada == 0){
				$consulta = $consulta.' `realizada`=\''.$realizada.'\'';
			} else if ($archivada == 0){
				$consulta = $consulta.' `archivada`=\''.$archivada.'\'';
			}
		}
		$consulta = $consulta.';';
		
		echo $consulta;
		// SELECT * FROM `programador`.`observaciones`;
		$resultado = $enlace->query($consulta);
		return $resultado;
	}
	
	function archivarQueja($enlace, $id) {
		$peticion = "UPDATE `programador`.`observaciones` SET `archivada`=1 WHERE `actividades`.`id` LIKE '".$id."';";
		$data = $enlace->query($peticion);
		return $data;
	}
	
	function agregarQueja($enlace, $id) {
		$peticion = "UPDATE `programador`.`observaciones` SET `realizada`=1 WHERE `actividades`.`id` LIKE '".$id."';";
		$data = $enlace->query($peticion);
		return $data;
	}

	function bucarSiEstasEnOtroLugar($enlace, $date) {	
		$hoy = date("Y-m-d");
		//$date = $datetime->format('Y-m-d');
		
		$deportes = getDeportes($enlace);
		$j=0;
		// buscar en todos los deportes
		while ($deportes->num_rows > $j) {
			$deportes->data_seek($j);
			$d = $deportes->fetch_row();
			$deporte = $d[0];
			
			// necesitamos las pistas del deporte a comprobar
			$pistas = getPistas($enlace, $deporte);

			// recuperamos las caracteristicas, para el calculo de horas
			$caracteristicas = getCaracteristicas($enlace);
			$caracteristicas->data_seek(0);
			$caracteristica = $caracteristicas->fetch_row();
		
			// se establecen los alores de la hora actual
			$horaInicial = $caracteristica[0];
			$horaFinal = $caracteristica[1];
			$segInicial = strtotime($horaInicial);
			$segFinal = strtotime($horaFinal);
		
			$horaActual = date("H:i");
			$segActual = strtotime($horaActual);
			$i=0;
			/* buscar en cada pista, calculando el nbt correspondiente segun bloque de tiempo de la propia pista*/
			while ($pistas->num_rows > $i) {
				$pistas->data_seek($i);
				$pista = $pistas->fetch_row();
			
				$tiempoBloque = $pista[1];
				$segBloque = $tiempoBloque*60;
		
				// Calculado el bloque actual para la pista que se va a comparar
				//$nbtActual2 = ($segActual-$segInicial) / $segBloque;
				$nbtActual = 1;
				if ( ($segActual > $segInicial) && ($segActual < $segFinal) && ($hoy == $date)) {
					$x = $segInicial;
					while ($x < $segActual) {
						$x= $x + $segBloque;
						$nbtActual= $nbtActual + 1;	
					}
					$nbtActual = $nbtActual -1;
				} else {
					$nbtActual = -1;
				}
				// firmadas, todo el dia no puede contenr otra pista firmada
				
				// SELECT * FROM `programador`.`firmadas` WHERE `firmadas`.`n_socio` LIKE '00002/00' AND `firmadas`.`fecha`='2016-03-20' AND `firmadas`.`deporte` LIKE 'padel' AND `firmadas`.`np`=3 AND `firmadas`.`nbTiempo`=7;
				
				$peticion= "SELECT * FROM `programador`.`firmadas` WHERE `firmadas`.`n_socio` LIKE '".$_SESSION['nUsuario']."' AND `firmadas`.`fecha`='".$date."' AND `firmadas`.`deporte` LIKE '".$deporte."' AND `firmadas`.`np`=$pista[0] AND `firmadas`.`nbTiempo`=".$nbtActual.";";
				
				$consulta = $enlace->query($peticion);
				if ( $consulta->num_rows >= 1 ) {
					return true;
				}
				//echo $i;
				//$bloques = $bloques."\nd:".$deporte." p:".$pista[0]." b:".$nbtActual;
				//$bloques = $bloques."\n\n".$peticion;
				$i++;
			}
			$j++;
		}
		
		//echo "_ERROR_100_".$bloques."_";
		
		return false;	
	}

	function firmar ($enlace, $deporte, $pista, $fecha, $nbt ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');

		// Se comprueba que no se firme diferentes pistas a la misma hora
		
		if ( bucarSiEstasEnOtroLugar($enlace, $date ) ) {
			return "_ERROR_5_";
		}
		// Se obtiene el nombre del firmante
		$peticion= "SELECT * FROM `programador`.`usuario` WHERE `id_usuario` LIKE '".$_SESSION['nUsuario']."';";
		$consulta = $enlace->query($peticion);
		if ($consulta->num_rows == 1) {
			$consulta->data_seek(0);
			$resultado = $consulta->fetch_row();
			$nombre = $resultado[1];
		}
		//DELETE FROM `programador`.`reservas` WHERE `reservas`.`n_socio` = \'00004/00\' AND `reservas`.`nombre` = \'isabel\' AND `reservas`.`fecha` = \'2016-01-26\' AND `reservas`.`deporte` = \'padel\' AND `reservas`.`np` = 4 AND `reservas`.`nbTiempo` = 11
		
		eliminarReservaFutura($enlace, $usuario, $date, $deporte);
		
		// Se añade la reserva a la tabla de firmadas
		$peticion = "INSERT INTO `programador`.`firmadas` (`n_socio`,`nombre`,`fecha`, `deporte`, `np`, `nbTiempo`) VALUES ('".$_SESSION['nUsuario']."','".$nombre."','".$date."', '".$deporte."', '".$pista."','".$nbt."');";
		$consulta = $enlace->query($peticion);
		//echo $peticion;
		return '_OK_1_';
	}

	function eliminarReservaFutura($enlace, $usuario, $date, $deporte) {
		$hoy = date("Y-m-d");
		//$date = $datetime->format('Y-m-d');
		
		$pistas = getPistas($enlace, $deporte);

		$caracteristicas = getCaracteristicas($enlace);
		$caracteristicas->data_seek(0);
		$caracteristica = $caracteristicas->fetch_row();
		
		$horaInicial = $caracteristica[0];
		$horaFinal = $caracteristica[1];
		$segInicial = strtotime($horaInicial);
		$segFinal = strtotime($horaFinal);
		
		$horaActual = date("H:i");
		$segActual = strtotime($horaActual);
		$i=0;
		while ($i < $pistas->num_rows) {
			$pistas->data_seek($i);
			$pista = $pistas->fetch_row();
			
			$tiempoBloque = $pista[1];
			$segBloque = $tiempoBloque*60;
		
			$nbtActual = 1;
			if ( ($segActual > $segInicial) && ($segActual < $segFinal) && ($hoy == $date)) {
				$x = $segInicial;
				while ($x < $segActual) {
					$x= $x + $segBloque;
					$nbtActual= $nbtActual + 1;	
				}
			} else {
				$nbtActual = -1;
			}
			// Calculado el bloque actual para la pista que se va a comparar
			//$nbtActual2 = ($segActual-$segInicial) / $segBloque;
			$pista = $i+1;
					// Se borra de la tabla de reservas las reservas posteriores a la hora actual de ejecucion
			$peticion = "DELETE FROM `programador`.`reservas` WHERE `reservas`.`n_socio` LIKE '".$_SESSION['nUsuario']."' AND `reservas`.`fecha`='".$date."' AND `reservas`.`deporte` LIKE '".$deporte."' AND `reservas`.`np`=$pista AND `reservas`.`nbTiempo` > $nbtActual;";
			$consulta = $enlace->query($peticion);

			$i++;
		}	
	}

	function reservarTarea ($enlace,$tarea,$deporte, $pista, $fecha, $nbt ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');
		
		$peticion = "SELECT * from `programador`.`actividades` WHERE `id`=".$tarea.";";
		$consulta = $enlace->query($peticion);
		$consulta->data_seek(0);
		$row = $consulta->fetch_row();
		$nombreTarea = $row[1];

		$peticion = "DELETE FROM `programador`.`reservas` WHERE `reservas`.`fecha`='".$date."' AND `reservas`.`deporte` LIKE '".$deporte."' AND `reservas`.`np`='".$pista."' AND `reservas`.`nbTiempo`='".$nbt."';";
		$consulta = $enlace->query($peticion);
		
		$peticion = "DELETE FROM `programador`.`firmadas` WHERE `firmadas`.`fecha`='".$date."' AND `firmadas`.`deporte` LIKE '".$deporte."' AND `firmadas`.`np`='".$pista."' AND `firmadas`.`nbTiempo`='".$nbt."';";
		$consulta = $enlace->query($peticion);

		if ($tarea > 0) {
			$peticion = "INSERT INTO `programador`.`reservas` (`n_socio`,`nombre`,`fecha`, `deporte`, `np`, `nbTiempo`) VALUES ('PERSONAL','".$nombreTarea."','".$date."', '".$deporte."', '".$pista."','".$nbt."');";
			$consulta = $enlace->query($peticion);

			$peticion = "INSERT INTO `programador`.`firmadas` (`n_socio`,`nombre`,`fecha`, `deporte`, `np`, `nbTiempo`) VALUES ('PERSONAL','".$nombreTarea."','".$date."', '".$deporte."', '".$pista."','".$nbt."');";
			$consulta = $enlace->query($peticion);
		}
		return $consulta;
	}

	function eliminarReserva ($enlace, $deporte, $pista, $fecha, $nbt ) {
		$datetime = new DateTime($fecha);
		$date = $datetime->format('Y-m-d');
		$peticion = "DELETE FROM `programador`.`reservas` WHERE `reservas`.`n_socio` LIKE '".$_SESSION['nUsuario']."' AND `reservas`.`fecha`='".$date."' AND `reservas`.`deporte` LIKE '".$deporte."' AND `reservas`.`np`='".$pista."' AND `reservas`.`nbTiempo`='".$nbt."';";
		//echo $peticion;
		$consulta = $enlace->query($peticion);
		return $consulta;
	}

	function nuevaTarea($enlace, $elemento) {
		$tareas = getTareas($enlace);
		$numero = $tareas->num_rows;
		$peticion1 = "INSERT INTO `programador`.`actividades` (`id`,`actividad`) VALUES (".$numero.",'".$elemento."');";
		$resultado = $enlace->query($peticion1);
		return $resultado;
	}

	function eliminarTarea($enlace, $posicion) {
		if ($posicion == 0) {
			return;
		}
		//DELETE FROM `programador`.`actividades` WHERE `tenis`.`np` = 2
		$peticion1 = "DELETE FROM `programador`.`actividades` WHERE `actividades`.`id`=".$posicion.";";
		//echo $peticion1;
		$resultado = $enlace->query($peticion1);

		// actualizar ids
		$tareas = getTareas($enlace);
		$j = $posicion+1;
		while ( ($tareas->num_rows >= $j) ) {
			$tareas->data_seek($j);
			$tarea = $tareas->fetch_row();
			$numero = $j-1;
			$peticion1 = "UPDATE `programador`.`actividades` SET `id`=".$numero." WHERE `actividades`.`id`=".$j.";";
			$enlace->query($peticion1);
			$j++;
		}
		
		return $resultado;
	}
?>