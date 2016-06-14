function comprobar() {
	var entrada = document.getElementById('nUsuario');
	if (entrada.value.length == 5) {
		entrada.value = entrada.value + "/";
	}
	if ( (/^\d{5}\\|\/\d{2}/.test(entrada.value) ) && (entrada.value.length == 8) ){
		entrada.style.color='green';
		return true;
	} else {
		entrada.style.color='red';
		return false;
	}
}

function key(){
	var mensaje="accion=gamal";
	if (comprobar() ){
		solicitarKey(mensaje);
	} else {
		alert ('FORMATO DE NUMERO\n DE SOCIO ERRONEO');
	}
}
function solicitarKey(mensaje) {
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
			getkey(salida);
		}
	};
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"encriptador.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function getkey(salida) {
    //alert("respuesta servidor: "+salida);
	var er = salida.split("_");
	//alert ("_"+salida+"_");
	if (er[1] == "ERROR") {
		alert ('ERROR DE SERVIDOR\n'+er[2]);
	} else if (er[1] == "OK"){
		//alert('encriptando clave '+er[2]+' privada: '+er[3]);
		var pgk = er[2].split(':');
		validar(pgk);
	} else if (er[1] == "OK2"){
		alert('Modo Prueba');
		//alert('descifrado: '+er[2]);
	} else {
        alert ('_'+salida+'_');
    }
}

function validar(pgk) {
	var entrada = document.getElementById('nUsuario');
	var con = document.getElementById('pass');

	// p, g, k, a
	//pruebaCifrado(pgk[0],pgk[1],pgk[2],er[3]);
	//alert(con.value);
	var data= cifrar(con.value,pgk[0],pgk[1],pgk[2]);
	//enviarMensajeCifrado(data.y1,data.y2);

	var mensaje = "";
	mensaje="nUsuario="+entrada.value+"&y1="+data.y1+"&y2="+data.y2;
	//alert('enviando '+mensaje);
	comunicacion(mensaje);
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
	//alert ("_"+salida+"_");
	if (er[1] == "ERROR") {
		alert ('ERROR DE USUARIO POR\n'+er[2]);
		location.reload(true);
	} else if (er[1] == "OK"){
		if (er[2]=='11') {
			alert("COMPUTADOR ADECUADO A LA\nCONFIRMACION DE USO DE PISTAS");
			location.reload(true);
		} else if (er[2]=='10'){
			//alert (ruta+'server.php?inicio='+er[3]);
			location.href=ruta+'server.php?inicio='+er[3];
		}
	} else if (er[1] == "OK2"){
		alert("Modo Prueba");
		//alert('clave descifrada: '+er[2]);
	}
}
