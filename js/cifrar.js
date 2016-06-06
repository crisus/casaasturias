var Alf="ABCDEFGHIJKLMNÑOPQRSTUVWXYZ .:-_$%012345789abcdefghijklmnñopqrstuvwxyz";

// Funcion que codifica numeros en letras segun el alfabeto
// Quiero que empiece en 0
function numletra(i) {
	var vec = Alf.split('');
	return vec[i];
}

// Funcion que codifica letras en numeros
// segun el alfabeto dado

function letranum(c) {
	//alert('letranum '+c);
	var vec = Alf.split('');
	var i=0;
	while (i <= vec.length)  {
		//alert(i+'__'+vec[i]+'__'+c);
		if(vec[i]==c ) {
			return i;
		}
		i++;
	}
	return -1;
}

// Las siguientes funciones aplican lo anterior a todos los caracteres
// de una cadena o a todos los nu'meros de una lista o vector
function numletras(numeros) {
	var i=0;
	var res="";
	for(i=0; i<numeros.length; i++) {
		res=res+numletra(numeros[i]);
	}
	return res;
}



// Funcion que expresa un numero en base L, la longitud del alfabeto
// Hay que pasarle un k, numero de simbolos que queremos,
/*function numlista(N,k) {
	//solo hay que ir combinando cocientes y restos sucesivos mod L
	var i;
	var lista=[];
	var L=Alf.length;
	var N1=N;
	for(i=1;i<k-1;i++) {
		lista=N1%L+lista;
		N1=N1/L;
	}
	lista=N1+lista;
	return lista;
}
*/
// Funcion antidoto de la anterior, convierte lista a numero
/*function listanum(lista) {
	//Aqui no hace falta pasarle como parametro la longitud de la lista
	var i;
	var k=lista.length;
	var L=Alf.length;
	var sum =0;
	for (i=0; i<k-1; i++) {
		sum = sum + lista[k-i]*L^i;
	}
	return sum;
}*/
// convierte letras a posicion en alfabeto
function letrasnum(mensaje) {
	//alert('letrasnum '+mensaje);
	var vec = mensaje.split('');
	//alert(vec[0]+' '+vec[1]);
	//alert(letranum(vec[0]));
	var i;
	var res=[];
	for(i=0; i<vec.length; i++) {
		res[i]=letranum(vec[i]);
	}
	//alert(letranum(res[0]));
	return res;
}
/*
function cifrarelgamal(mensaje,p,g,alfa) {
	var kk = mensaje.length;
	var numeros = letrasnum(mensaje);
	var M = listanum(numeros);
	var k = Math.random()*p;
	var r = (g%p)^k;
	var s = M*(alfa%p)^k;
	var RS =[];
	RS[0] = numletras( numlista(r,kk+1) );
	RS[1] = numletras( numlista(s,kk+1) );
	return RS;
}
*/
function cifrar(mensaje,p,g,k) {
	var b = Math.floor(Math.random() * (p-3) ) + 2;
	//alert(b+' '+mensaje);
	var m =  letrasnum(mensaje);
	//alert('c: '+m);
	var y1 = 1;
	var y2 = 1;
	var res='';
	var i=0;
	var L = Alf.length;
	for (i=0; i<b; i++) {
		y1 = (y1 * g)%p;// g^b
		y2 = (y2 * k)%p;// k^b
	}
	for (i=0; i<m.length; i++ ) {
		res = res +((y2 * m[i])%p);
		if (i!=m.length-1) {
			res = res + ',';
		}
	}
	return {y1: y1, y2: res};
}

function descifrar(mC, p, g, a) {
	//var m = letrasnum(mC.y2);
	var m = mC.y2.split(',');
	//alert(y1+' '+m);
	var i=0;
	var y1X = 1;
	for (i=0; i < p-1-a; i++) {
		y1X = (y1X * mC.y1)%p;
	}
	var res = [];
	for (i=0; i < m.length; i++) {
		//m[i] = m[i]%p;
		res[i] = (y1X*m[i])%p;
	}
	//alert('d: '+res);
	return numletras(res);
}

function pruebaCifrado(p,g,k,a) {
	//alert('cifrando');
	var data= cifrar('ABCDEFGHIJKLMNÑOPQRS',p,g,k);
	k=1;
	for (var i=0; i<a; i++) {
		k = (k*g)%p;
	}
	//alert('K: '+k);
	//alert('descifrando '+data.y1+' '+data.y2);
	// envia dato al servidor
	enviarMensajeCifrado(data.y1,data.y2);
	var res= descifrar(data, p, g, a);
	alert('Se ha descifrado: '+res);
}

/*
function descifrarelgamal(RS,p,g,a) {
	var rletras=RS[0];
	var sletras=RS[1];
	var l=rletras.length;
	var r=listanum(letrasnum(rletras));
	var s=listanum(letrasnum(sletras));
	var M=(s%p)*(r%p)^(-a);
	var numeros = numlista(M,l-1);
	return numletras(numeros);
}
*/
function enviarMensajeCifrado(y1,y2){
	var mensaje = 'accion=desencriptar&y1='+y1+'&y2='+y2;
	solicitarKey(mensaje);
}
