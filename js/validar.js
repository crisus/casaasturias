function comprobar() {
	var entrada = document.getElementById('nUsuario');
	if ( (/^\d{5}\\|\/\d{2}/.test(entrada.value) ) && (entrada.value.length == 8) ){
		entrada.style.color='green';
		return true;
	} else {
		entrada.style.color='red';
		return false;
	}
}

function validar() {
	var entrada = document.getElementById('nUsuario');
	var con = document.getElementById('pass');
	var mensaje = "";
	if (comprobar() ) {
		mensaje="nUsuario="+entrada.value+"&pass="+con.value;
		comunicacion(mensaje);
	} else {
		alert ('FORMATO DE NUMERO\n DE SOCIO ERRONEO');
	}
}

function comunicacion(mensaje) {
	var ruta='/casaasturias/';
	var xmlhttp;
	var salida="";
	if (window.XMLHttpRequest) { // code ie7+,
		xmlhttp = new XMLHttpRequest();
	} else { // code ie6-
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange= function() {
		if ( (xmlhttp.readyState==4) && (xmlhttp.status==200) ) {
			salida = xmlhttp.responseText;
			recibir(salida);
		}
	};
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"server.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function recibir(salida) {
	var ruta='/casaasturias/';
    //alert("respuesta servidor: "+salida);
	var er = salida.split("_");
	//alert ("_"+recibido+"_");
	if (er[1] == "ERROR") {
		alert ('ERROR DE USUARIO POR\n'+er[2]);
	} if (er[1] == "OK"){
		if (er[2]=='11') {
			alert("COMPUTADOR ADECUADO A LA\nCONFIRMACION DE USO DE PISTAS");
			location.reload(true);
		} else if (er[2]=='10'){
			location.href=ruta+'server.php?inicio='+er[3];
		}
	}
}
