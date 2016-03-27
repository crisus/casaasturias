function validar(id) {
	var entrada = document.getElementById(id);
	var valor = entrada.value;
	if (/^([0-9])*$/.test(valor)) {
		entrada.style.color='green';
		return true;
	} else {
		entrada.style.color='red';
		return false;
	}
}

function validarHora(id) {
	var entrada = document.getElementById(id);
	var valor = entrada.value;
	if (/^\d{1,2}:\d{2}$/.test(valor)) {
		entrada.style.color='green';
		return true;
	} else {
		entrada.style.color='red';
		return false;
	}
}

function comunicacion(mensaje, descargar) {
	var xmlhttp;
	var salida;
	var ruta='/casaasturias/';
	if (window.XMLHttpRequest) { // code ie7+,
		xmlhttp = new XMLHttpRequest();
	} else { // code ie6-
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange= function() {
		if ( (xmlhttp.readyState==4) && (xmlhttp.status==200) ) {
			salida = xmlhttp.responseText;
			//alert("recibido ,"+salida+".");
			recibir(salida, descargar);
		}
	}
	//alert ("enviando ,"+mensaje+", ");
	xmlhttp.open("POST",ruta+"server_ajax.php",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send(mensaje);
}

function enviarArchivo(formData) {
	var xmlhttp;
	var salida;
	var ruta='/casaasturias/';
	if (window.XMLHttpRequest) { // code ie7+,
		xmlhttp = new XMLHttpRequest();
	} else { // code ie6-
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange= function() {
		if ( (xmlhttp.readyState==4) && (xmlhttp.status==200) ) {
			salida = xmlhttp.responseText;
			alert("OK");
			window.location.reload();
		}
	}
	//alert ("enviando Archivo");
	xmlhttp.open("POST",ruta+"server_ajax.php",true);
	//xmlhttp.setRequestHeader("Content-type","multipart/form-data");
	xmlhttp.send(formData);
}

// metodo de accion de elementos respuesta
function recibir(salida, descargar){ // descargar = 0, no hace nada; = 1, descarga directa; = 2, coloca elementos para subir un archivo elegido
	var er = [];
	er = salida.split("_");
	if ( (er[1]=='ERROR') && (er[2] == '-1') ) {
		alert ("ERROR de ACCESO");
	} else if ( (descargar == 1) && (salida!="reload") ){
		//alert("OK");
		document.location = salida;
	} else if (descargar == 2) {
		var objeto = '<div class="subir">';
		objeto = objeto+'<h4>RESTAURAR BASE DE DATOS</h4>';
		objeto = objeto+salida;
		objeto = objeto+'<input class="busqueda" type="button" onclick=\"subir(\'tipo_select\')\" value=\"Subir y Restaurar\"></div>';
		var entrada = document.getElementById("subir");
		entrada.innerHTML=objeto;
	} else {
		alert("OK");
		window.location.reload();
	}
}

// metodo de captacion de envio de datos al servidor
function enviar(mensaje, descargar) {
	comunicacion(mensaje, descargar);
}

function nuevaTarea() {
	//alert('nueva Tarea');
	var entrada = document.getElementById("tarea").value;
	var mensaje = "accion=anadir&objeto=tarea&elemento="+entrada;
	enviar(mensaje,0);
}

function eliminarTarea (){
	//alert('eliminar Tarea');
	var entrada = document.getElementById("tareas");
	var indice = entrada.selectedIndex;
	var texto = "indice: " + indice;
	var valor = entrada.options[indice].value;
	texto += " valor: " + valor ;
	//var textoEscogido = entrada.options[indice].text;
	//texto += " textoEscogido: " + textoEscogido ;
	//alert(texto);
	var mensaje = "accion=eliminar&objeto=tarea&posicion="+indice;
	enviar(mensaje, 0);
}

function guardarBBDD () {
	var mensaje = "accion=copia";
	var r=confirm("¿Quieres  Descargar \n la Copia de Seguridad\n que se va ha realizar?");
	var descargar = 0;
	//var r=1;
	if (r) {
		descargar = 1;
		mensaje = mensaje + "&descargar=1";
	} else {
		mensaje = mensaje + "&descargar=0";
	}
	//alert(mensaje);
	enviar(mensaje, descargar);
}

function restaurarBBDD () {
	var boton = document.getElementById("restaurar");
	boton.disabled =true;
	var mensaje = "accion=recuperar";
	//alert('restaurar BBDD');
	var r=confirm("¿Quieres  subir \n una Copia de Seguridad?");
	var entrada = document.getElementById("subir");

	var objeto = '<div class="subir">';
	objeto = objeto+'<h4>RESTAURAR BASE DE DATOS</h4>';
	objeto = objeto+'<input class="busqueda" id="sql" name="sql"  type="file" value="sql">';
	objeto = objeto+'<input class="busqueda" type="button" onclick=\"subir(\'tipo_file\')\" value="Subir y Restaurar"></div>';
	if (r) {
		entrada.innerHTML = objeto;
	} else {
		mensaje = mensaje + "&objeto=sql";
		enviar(mensaje,2);
	}
}

function subir(tipo) {
	var boton = document.getElementById("restaurar");
	boton.disabled =false;
	if (tipo == 'tipo_select') {
		var elemento = document.getElementById('sql');
		var eleccion = elemento.value;
		var mensaje = "accion=recuperar&objeto=sql2&elemento="+eleccion;
		//alert(mensaje);
		enviar(mensaje,0);
	} else if (tipo == 'tipo_file') {
		var fileSelect = document.getElementById('sql'); // buscar

		var files = fileSelect.files;

		var formData = new FormData();
		var file;
		//alert(files.length);
		for (var i =0; i< files.length; i++) {
			file = files[i];
			//alert(file.name);
			//if (file.type.match('text/x-sql')) {
				//alert("Esto es un archivo de copia sql");
    				formData.append('sql', file, file.name);
  			//} else {
			//	alert ("NO ES UNA COPIA DE SEGURIDAD");
			//}

		}
		enviarArchivo(formData);
	} else {
		alert("orden ERRONEA");
	}

	var entrada = document.getElementById("subir");
	entrada.innerHTML = "";
}

// nuevo deporte
//id="anadir_deporte"
function nuevoDeporte(id) {
	var data=[];
	data = id.split("_");
	var nombreDeporte = prompt("¿Que deporte desea agragar?", "Nombre Deporte");
	//alert (nombreDeporte);
	if ( (nombreDeporte != null) && (nombreDeporte != "") ) {
		var mensaje = "accion="+data[0]+"&objeto="+data[1]+"&elemento="+nombreDeporte+"";
		enviar(mensaje,0);
	}
}

// elimina pista correspondiente
// id= eliminar_pista_tenis
function eliminarDeporte(id) {
	var data=[];
	data = id.split("_");
	var mensaje = "accion="+data[0]+"&objeto="+data[1]+"&elemento="+data[2]+"";
	enviar(mensaje,0);
}

// nueva pista en el deporte correspondiente
// id="anadir_pista_tenis"
function nuevaPista(id) {
	var data=[];
	data = id.split("_");
	var mensaje = "accion="+data[0]+"&objeto="+data[1]+"&elemento="+data[2];
	enviar(mensaje,0);
}

// elimina pista correspondiente
// id= eliminar_pista_tenis_2
function eliminarPista(id) {
	var data=[];
	data = id.split("_");
	var mensaje = "accion="+data[0]+"&objeto="+data[1]+"&elemento="+data[2]+"&posicion="+data[3];
	enviar(mensaje,0);
}

// actualiza valores de la pista correspondiente
// id= actualizar_pista_tenis_3
function modificarPista(id) {
	var data=[];
	data = id.split("_");
	var mensaje = "accion="+data[0]+"&objeto="+data[1]+"&elemento="+data[2]+"&posicion="+data[3];
	var busqueda = data[1]+"_"+data[2]+"_"+data[3];
	var datosPista = document.getElementsByClassName(busqueda);
	var valido = true;
	for (var i=0; (i< datosPista.length && valido); i++) {
		valido = valido && validar(datosPista[i].id);
		mensaje = mensaje+"&valor"+i+"="+datosPista[i].value;
	}

	if (valido) {
		enviar(mensaje,0);
	} else {
		alert("Error en valores introducidos");
	}
}

function modificarCaracteristicas() {
	var data = document.getElementsByClassName("caracteristica");
	var mensaje = "accion=modificar&objeto=caracteristicas";
	var valido = true;
	for (var i=0; (i < data.length && valido); i++) {
		if (i < 2)
			valido = valido && validarHora(data[i].id);
		else
			valido = valido && validar(data[i].id);
		mensaje = mensaje+"&dat"+i+"="+data[i].value;
	}
	if (valido) {
		enviar(mensaje,0);
	} else {
		alert("Error en valores introducidos");
	}
}

function reloadPage() {
	var mensaje="";
	var volvelAlPrincipio = confirm("Va a Finalizarse su Sesion: \n ¿Desea continuar?");
	if (volvelAlPrincipio) {
		// mantener sesion activa
		mensaje = "accion=finSesion&estado=1";
		comunicacion(mensaje,0);
		window.location.reload();
	} else {
		// finalizar la sesion
		mensaje = "accion=finSesion&estado=0";
		comunicacion(mensaje,0);
	}
}

setInterval(reloadPage,400000);
