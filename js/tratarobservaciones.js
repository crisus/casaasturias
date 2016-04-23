function observacion(){
	var mensaje="accion=observacion";
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
	}
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
		}
	} else if (er[1] == 'ERROR') {
		if (er[2] == '1') {
			alert('ERROR 1');
		}
	}
}
