function reservarPista(entrada) {
	var ruta = '/casaasturias/';
	var data=[];
	data = entrada.split("_");
	window.location=ruta+"indexReservas.php?v1="+data[0]+"&v2="+data[1]+"&ifecha=0";
}

function reservarPista2(entrada) {
	var ruta = '/casaasturias/';
    var pistaSeleccionada = document.getElementById(entrada);
    var data =[];
    data = entrada.split("_");
    //alert(ruta+"indexReservas.php?v1="+data[1]+"&v2="+pistaSeleccionada.selectedIndex+"&ifecha=0");
	window.location=ruta+"indexReservas.php?v1="+data[1]+"&v2="+pistaSeleccionada.selectedIndex+"&ifecha=0";
	//window.location=ruta+"index_quejas.php?v1="+data[1]+"&v2="+pistaSeleccionada.selectedIndex+"&ifecha=0";
}

function reservar(id, deporte, pista, nbTiempo, nbtActual) {
	var fecha = document.getElementById("fecha");
	var entrada = document.getElementById(id);
	var data = id.split('_');
	var mensaje ="";
	//alert ("hola"+data[0]);
	if (data[0] != 'tareas') {
		mensaje="accion=reservar&nUsuario="+entrada.value+"&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML+"&nbtActual="+nbtActual;
	} else {
		// tarea_1_5_2
		mensaje="accion=tarea&tarea="+entrada.selectedIndex+"&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
		//generarDialogoContinuidad(nbTiempo);
	}
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function repetir(id, deporte, pista, id_tarea, realizarRepeticion) {
	var data = id.split('_');
	var mensaje = 'accion=continuidad&deporte='+deporte+'&pista='+pista+'&tarea='+id_tarea+'&nbTiempo='+data[1];
	var semana = ['L','M','X','J','V','S','D'];
	var cheks =[];
	var fets =[];
	//alert('funcion repetir '+data[0]+' - '+data[1]);
	if (realizarRepeticion) {
		if (data[0] == 'repetir') {
			cheks = document.getElementsByClassName('checkbox_'+data[1]);
			fets = document.getElementsByClassName('fechasIF_'+data[1]);
			var diasReserva = '';
			var primeraPosicion = 0;
			for (var i=1; i<=cheks.length; i++) {
				if (cheks[i-1].checked) {
					if (diasReserva === '') {
						diasReserva = diasReserva +'&reserva_semana='+i;
						primeraPosicion = i;
					} else {
						diasReserva = diasReserva+'_'+(i-primeraPosicion);
					}
				}
			}
			if (diasReserva !== '') {
				mensaje = mensaje +diasReserva+'&fechaI='+fets[0].value+'&fechaF='+fets[1].value;
				alert(mensaje);
				comunicacion(id,mensaje);
			} else {
				alert('No hay repeticiones señaladas');
			}
		} else if (data[0] == 'unico') {
			// para mejora de borrado de la continuidad
		} else {
			//alert('puff');
		}
	} else {
		alert('unico');
	}
	cerrarDialogo(data[1]);
}

function mostrarDialogo (n_dialogo) {
	//alert('hola dialogo');
	document.getElementById('modal_'+n_dialogo).style.display='block';
}

function cerrarDialogo (n_dialogo) {
	//alert('cerrando dialogo');
	document.getElementById('modal_'+n_dialogo).style.display='none';
	//alert('dialogo cerrado');
}

function undiamenos (deporte, pista, decremento) {
	var ruta = '/casaasturias/';
	decremento--;
	window.location=ruta+"indexReservas.php?v1="+deporte+"&v2="+pista+"&ifecha="+decremento;
}

function undiamas(deporte, pista, incremento) {
	var ruta = '/casaasturias/';
	incremento++;
	window.location=ruta+"indexReservas.php?v1="+deporte+"&v2="+pista+"&ifecha="+incremento;
}

function comprobar(id, deporte, pista, nbTiempo, nbtActual) {
	var entrada = document.getElementById(id);
	if (entrada.value.length == 5) {
		entrada.value = entrada.value + "/";
	}
	if ( (/^\d{5}\\|\/\d{2}/.test(entrada.value) ) && (entrada.value.length == 8) ){
		entrada.style.color='green';
		//alert("aqui");
		reservar(id, deporte, pista, nbTiempo, nbtActual);
	} else if (entrada.value == "") {
		eliminarReserva(id, deporte, pista, nbTiempo);
	} else {
		entrada.style.color='red';
	}
}

function eliminarReserva(id, deporte, pista, nbTiempo) {
	var fecha = document.getElementById("fecha");
	//var entrada = document.getElementById(id);
	var mensaje = "accion=eliminarReserva&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function firmar (id, deporte, pista, nbTiempo) {
	var fecha = document.getElementById("fecha");
	var mensaje = "accion=firmar&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function comunicacion(id,mensaje) {
	var ruta = '/casaasturias/';
	var xmlhttp;
	var salida;
	if (window.XMLHttpRequest) { // code ie7+,
		xmlhttp = new XMLHttpRequest();
	} else { // code ie6-
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange= function() {
		if ( (xmlhttp.readyState==4) && (xmlhttp.status==200) ) {
			salida = xmlhttp.responseText;
			recibir(id,salida);
			//alert(salida);
		}
	}
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"server_reservas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function recibir(id,salida) {
	var ruta = '/casaasturias/';
	var entrada = document.getElementById(id);
	var data=[];
	var er=[];
	er = salida.split("_");
	data = id.split("_");
	var s, out;
	var mensaje ="";
	var volvelAlPrincipio =false;

	//alert("|"+salida+"|");
	if (er[1] == 'OK')  {
		if (er[2] == '1') { // firma
			entrada.disabled = true;
		} else if (er[2] == '2') { // eliminar reserva
			s = 'nombre_'+data[1]+'_'+data[2];
			out = document.getElementById(s);
			out.value = "";
			entrada.disabled = false;
			entrada.value = 'xxxxx/xx';
		} else if (er[2] == '3') { // tarea archivada
			alert ("TAREA ARCHIVADA");
		} else if (er[2] == '4') { // reservar
			s = 'nombre_'+data[1]+'_'+data[2];
			out = document.getElementById(s);
			out.value = er[3];
			entrada.disabled = true;
		} else if (er[2] == '6') { // tarea con continuidad (semanal)
			alert('tarea semanal');
		}
		window.location.reload();
	} else if (er[1] == 'ERROR') {
		if (er[2] == '1') {
			alert('NUMERO DE USUARIO ERRONEO');
			entrada.style.color='red';
		} else if (er[2] == '2') {
			alert('NO PUEDES CONFIRMAR TU RESERVA');
			entrada.style.color='red';
		} else if (er[2] == '3') {
			alert('YA TIENES UNA RESERVA\nPARA ESTE DEPORTE');
			entrada.value = 'xxxxx/xx';
		} else if (er[2] == '4') {
			alert('LA RESERVA\nCONTINUA ACTIVA');
			entrada.value = 'xxxxx/xx';
		} else if (er[2] == '5') {
			alert('YA HAS FIRMADO UNA RESERVA\n A ESTA HORA');
			window.location.reload();
		} else if (er[2] == '6') {
			alert('IMPOSIBLE ESTABLECER CONTINUIDAD')
		} else if (er[2] == '100') { // errores lanzados para pruebas
			confirm(salida);
		}
	} else if (er[1]=="SESION") {
		if (er[2]=="FIN") {
			window.location=ruta+"index.html";
		} else if (er[2]=="CONTINUA") {
			alert("Sesion sigue activa");
		}
	} else {
		//alert("DESCONOCIDO _"+salida+"_");
		//window.location.reload();

		alert("LA SESION DEL SERVIDOR\n HABIA FINALIZADO");
		window.location=ruta+"index.html";
	}
}

function reloadPage() {
	var mensaje="";
	var volvelAlPrincipio = confirm("Va a Finalizarse su Sesion: \n ¿Desea continuar?");
	if (volvelAlPrincipio) {
		// mantener sesion activa
		mensaje = "accion=finSesion&estado=1";
		comunicacion("0", mensaje);
	} else {
		// finalizar la sesion
		mensaje = "accion=finSesion&estado=0";
		comunicacion("0", mensaje);
	}
}

setInterval(function(){reloadPage(); },60000);
