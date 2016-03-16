function reservarPista(entrada) {
	var data=[];
	data = entrada.split("_");
	window.location="/casaasturias/indexReservas.php?v1="+data[0]+"&v2="+data[1]+"&ifecha=0";
}

function undiamenos (deporte, pista, decremento) {
	decremento--;
	window.location="/casaasturias/indexReservas.php?v1="+deporte+"&v2="+pista+"&ifecha="+decremento;
}

function undiamas(deporte, pista, incremento) {
	incremento++;
	window.location="/casaasturias/indexReservas.php?v1="+deporte+"&v2="+pista+"&ifecha="+incremento;
}

function comprobar(id, deporte, pista, nbTiempo, nbtActual) {
	var entrada = document.getElementById(id);
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
	var entrada = document.getElementById(id);
	var mensaje="accion=eliminarReserva&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function reservar(id, deporte, pista, nbTiempo, nbtActual) {
	var fecha = document.getElementById("fecha");
	var entrada = document.getElementById(id);
	var data = id.split('_');
	var mensaje ="";
	//alert ("hola"+data[0]);	
	if (data[0] != 'tarea') {
		mensaje="accion=reservar&nUsuario="+entrada.value+"&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML+"&nbtActual="+nbtActual;
	} else { 
		// tarea_1_5_2
		mensaje="accion=tarea&tarea="+data[3]+"&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
	}
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function firmar (id, deporte, pista, nbTiempo) {
	var fecha = document.getElementById("fecha");
	mensaje = "accion=firmar&deporte="+deporte+"&pista="+pista+"&nbTiempo="+nbTiempo+"&fecha="+fecha.innerHTML;
	//alert(mensaje);
	comunicacion(id,mensaje);
}

function comunicacion(id,mensaje) {
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
	xmlhttp.open("POST","/casaasturias/server_reservas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function recibir(id,salida) {
	var entrada = document.getElementById(id);
	var data=[];
	data = id.split("_");
	//alert("|"+salida+"|");
	if ( (salida != 'ERROR_1') && (salida != 'ERROR_2') && (salida != 'ERROR_3')  && (salida != 'ERROR_4') && (salida != 'ERROR_5')) {
		if (salida == 'OK_1') { // firma
			entrada.disabled = true;
		} else if (salida == 'OK_2') { // eliminar reserva
			var s = 'nombre_'+data[1]+'_'+data[2];
			var out = document.getElementById(s);
			out.value = "";
			entrada.disabled = false;
			entrada.value = 'xxxxx/xx';
		} else if (salida == 'OK_3') {
			alert ("TAREA ARCHIVADA");
		}else { // reservar
			var s = 'nombre_'+data[1]+'_'+data[2];
			var out = document.getElementById(s);
			out.value = salida;
			entrada.disabled = true;
		}
		window.location.reload();
	} else if (salida == 'ERROR_1') {
		alert('NUMERO DE USUARIO ERRONEO');
		entrada.style.color='red';
	} else if (salida == 'ERROR_2') {
		alert('NO PUEDES CONFIRMAR TU RESERVA');
		entrada.style.color='red';
	} else if (salida == 'ERROR_3') { 
		alert('YA TIENES UNA RESERVA\nPARA ESTE DEPORTE');
		entrada.value = 'xxxxx/xx';
	} else if (salida == 'ERROR_4') { 
		alert('LA RESERVA\nCONTINUA ACTIVA');
		entrada.value = 'xxxxx/xx';
	} else if (salida == 'ERROR_5') {
		alert('YA HAS FIRMADO UNA RESERVA\n A ESTA HORA');
		window.location.reload();
	}else {
		alert(salida);
		window.location.reload();
	}
}

function reloadPage() {
	location.reload(true);
}

setInterval("reloadPage()","140000");
