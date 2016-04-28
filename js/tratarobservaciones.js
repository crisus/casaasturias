function generarObservacion(entrada) {
	var ruta = '/casaasturias/';
    var pistaSeleccionada = document.getElementById(entrada);
    var data =[];
    data = entrada.split('_');
	window.location=ruta+'indexQuejas.php?v1='+data[2]+'&v2='+data[3];
}
