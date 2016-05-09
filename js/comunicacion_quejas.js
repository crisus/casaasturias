function enviarObservacion(deporte, pista){
	var mensaje='accion=quejas&objeto='+deporte+'&elemento='+pista;

	var id = 'observacion';
	var valor = document.getElementById(id);
	mensaje = mensaje+'&observacion='+valor;

	id = 'asunto';
	valor = document.getElementById(id);
	mensaje = mensaje+'&asunto='+valor;

	comunicacion2(mensaje);
}

function obtenerQuejas() {
	var nameClass='verQuejas';
	var elements = document.getElementsByClassName(nameClass);
	var estados = [];
	for (var i=0; i< elements.length; i++) {
		if (elements[i].checked) {
			estados[i] = 1;
		} else {
			estados[i] = 0;
		}
	}
	var mensaje = 'accion=verQuejas&re='+estados[0]+'&ar='+estados[1]+'&nole='+estados[2];
	comunicacion2(mensaje);
}

function comunicacion2(mensaje) {
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
			recepcion(salida);
			//alert(salida);
		}
	};
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"server_quejas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function recepcion(salida) {
	//var ruta = '/casaasturias/';
	//var entrada = document.getElementById(id);
	//var data=[];
	var er=[];
	er = salida.split("_");
	//data = id.split("_");
	//var s, out;
	//var mensaje ="";
	//var volvelAlPrincipio =false;

	//alert("|"+salida+"|");
	if (er[1] == 'OK')  {
		if (er[2] == '1') { // firma
			alert ("ok 1");
		} else if (er[2] == '2') {
			mostrarQuejas(er);
		}
	} else if (er[1] == 'ERROR') {
		if (er[2] == '1') {
			alert('ERROR 1');
		}
	} else {
		alert('Error desconocido comunicacion_quejas.js');
	}
}

function mostrarQuejas(quejas) {
	var i=0;
	var id='observacones';
	var contenedor = document.getElementById(id);
	var textComponent ='';
	for (i=2; i < quejas.length; i= i+5) {
		textComponent = '<div class="bloque-observacion">';
		textComponent = textComponent+'<div class="data">';
		// identificacion queja
		textComponent = textComponent+'<label class="1l_50" id="identificador_'+quejas[i]+'"> '+quejas[i]+'<\label>';
		// asunto
		textComponent = textComponent+'<label class="1l_25" id="asunto_'+quejas[i]+'"> '+quejas[i+1]+'<\label>';
		// deporte-observacion
		textComponent = textComponent+'<label class="1l_25" id="deporte-observacion_'+quejas[i]+'"> '+quejas[i+2]+'<\label>';
		// pista-deporte
		textComponent = textComponent+'<label class="1l_25" id="pista-deporte_'+quejas[i]+'"> '+quejas[i+3]+'<\label>';
		// observacion
		textComponent = textComponent+'<label class="1l_25" id="observacion_'+quejas[i]+'"> '+quejas[i+4]+'<\label>';

		textComponent = textComponent+'<\div>';
		textComponent = textComponent+'<div class="botones">';
		// botones
		textComponent = textComponent+'<button class="accion" type="button" value="Archivar" id="archivar_'+quejas[i]+'" onclick="archivar(this)" >';
		textComponent = textComponent+'<button class="accion" type="button" value="Agregar\nA Tareas" id="agregar_'+quejas[i]+'" onclick="agregar(this)" >';
		textComponent = textComponent+'<\div>';
	}
	contenedor.innerHTML = textComponent;
}

function archivar(id) {
	var data = id.split('_');
	var mensaje = 'accion=archivar&objeto='+data[1];
	comunicacion2(mensaje);
}

function agregar(id) {
	var data = id.split('_');
	var mensaje = 'accion=agregar&objeto='+data[1];
	comunicacion2(mensaje);
}
