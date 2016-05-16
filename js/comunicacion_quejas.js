function generarObservacion(entrada) {
    var data =[];
	data = entrada.split('_');
	var id = 'observaciones_'+data[4];
	//alert(id);
    var contenedor = document.getElementById(id);
	var contenido = '			';
	contenido = contenido+'			';
	contenido = contenido+'				<div class="queja"><textarea id="observacion_'+data[4]+'" rows="4"></textarea> </div>';
	contenido = contenido+'				<div class="asunto"><input type="text" id="asunto_'+data[4]+'" value="Asunto"></div>';
	contenido = contenido+'				<div class="accion-queja">';
	contenido = contenido+'	<button type="button" onclick="enviarObservacion(\''+data[2]+'\','+data[3]+','+data[4]+')">ENVIAR</button></div>';
	contenido = contenido+'			';
	contenido = contenido+'		';

	contenedor.innerHTML=contenido;
	//window.location=ruta+"index_quejas.php?v1="+data[2]+"&v2="+data[3];
}

function enviarObservacion(deporte, pista, bloque) {
	var mensaje='accion=quejas&objeto='+deporte+'&elemento='+pista;

	var id = 'observacion_'+bloque;
	var queja = document.getElementById(id).value;
	id = 'asunto_'+bloque;
	var asunto = document.getElementById(id).value;

	if ( (queja.length > 0) && (asunto.length > 0) ) {
		mensaje = mensaje+'&observacion='+queja;
		mensaje = mensaje+'&asunto='+asunto;
		alert(mensaje);
		comunicacion2(mensaje);
	} else {
		alert('Campos incompletos');
	}
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
	alert (mensaje);
	if (estados[0] || estados[1] || estados[2]) {
		comunicacion2(mensaje);
	} else {
		alert('CLEAR');
		mostrarQuejas('_OK_2__');
	}
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
			salidaServerQuejas(salida);
			//alert(salida);
		}
	};
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"server_quejas.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function salidaServerQuejas(salida) {
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
		if (er[2] == '1') { // devolucion de estado del servidor, cuando se ingresa una observacion
			alert ("Observacion guardada");
		} else if (er[2] == '2') {  // devolucion del servidor, cuando se requieren ver las observaciones
			mostrarQuejas(salida);
		} else {
			window.location.reload();
		}
	} else if (er[1] == 'ERROR') {
		if (er[2] == '1') {
			alert('ERROR 1');
		} else if (er[2]=='2') {
			alert('Error 2');
		}
	} else {
		alert('Error desconocido comunicacion_quejas.js '+er[1]+er[2]);
	}
}

function mostrarQuejas(salida) {
	alert(salida);
	var posAsunto;
	var quejas = salida.split('_');
	var i=0;
	var id='all-observaciones';
	var contenedor = document.getElementById(id);
	var textComponent ='';
	for (i=3; i < quejas.length-5; i= i+5) {
		textComponent = textComponent+'<div class="bloque-observacion"><form>';
			textComponent = textComponent+'<div class="data-bloque-observacion">';
				// identificacion queja
				//textComponent = textComponent+'<label class="1l_50" id="identificador_'+quejas[i]+'"> '+quejas[i]+'<\label>';
				// asunto
				alert(quejas[i]+' '+ quejas[i+1]+' '+ quejas[i+2]+' '+ quejas[i+3]+' '+ quejas[i+4]);
				textComponent = textComponent+'<label class="d1l_50" id="asunto_'+quejas[i]+'"> '+quejas[i+3]+'</label>';
				// deporte-observacion
				textComponent = textComponent+'<label class="d1l_25" id="deporte-observacion_'+quejas[i]+'"> '+quejas[(i+1)]+'</label>';
				// pista-deporte
				textComponent = textComponent+'<label class="d1l_25" id="pista-deporte_'+quejas[i]+'"> '+quejas[(i+2)]+'</label>';
				// observacion
				textComponent = textComponent+'<textarea class="d2l_100" rows="4" id="observacion_'+quejas[i]+'"> '+quejas[(i+4)]+'</textarea>';

			textComponent = textComponent+'</div>';
			textComponent = textComponent+'<div class="botones-observacion">';
				// botones
				textComponent = textComponent+'<button class="accion" type="button" id="archivar_'+quejas[i]+'" onclick="archivar(this)" >Archivar</button>';
				textComponent = textComponent+'<button class="accion" type="button" id="agregar_'+quejas[i]+'" onclick="agregar(this)">Agregar</button>';
			textComponent = textComponent+'</div>';
		textComponent = textComponent+'</form></div>';
	}
	alert(quejas.length);
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
