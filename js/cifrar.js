var Alf="ABCDEFGHIJKLMNOPQRSTUVWXYZ .";

// Funcion que codifica letras en numeros
// la forma rapida seria letranum(c)=setsearch(Set(Vec(Alf)),c)-1
// pero si el alfabeto tiene espacios, puntos, etc. no me sirve
// porque Set los ordena a su manera, punto y espacio antes que las letra
function letranum(c) {
	var continuar=1;
	var i=1;
	var resultado=i;
	while( continuar  && (i <= Alf.length) ) {
		if(Vec(Alf)[i]==c ) {
			resultado=i-1;
			continuar=0;
		} else {
			i++;
		}
	}
	return resultado;
}

// Las siguientes funciones aplican lo anterior a todos los caracteres
// de una cadena o a todos los nu'meros de una lista o vector
function numletras(lista) {
	var i=1;
	var n=lista.length;
	var res="";
	for(i=1;i<n;i++) {
		res=res+numletra(lista[i]);
	}
	return res;
}

function letrasnum(cadena) {
	var i;
	var n=cadena.length;
	var res=[];
	for(i=1;i<n;i++) {
		res=res+letranum(Vec(cadena)[i]);
	}
	return res;
}

// Funcion que expresa un numero en base L, la longitud del alfabeto
// Hay que pasarle un k, numero de simbolos que queremos,
function numlista(N,k) {
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
}

// Funcion antidoto de la anterior, convierte lista a numero
listanum(lista) {
	//Aqui no hace falta pasarle como parametro la longitud de la lista
	var i;
	var k=lista.length;
	var L=Alf,length;
	var sum =0;
	for (i=0; i<k-1; i++) {
		sum = sum + lista[k-i]*L^i;
	}
}

function cifrarelgamal(mensaje,p,g,alfa) {
	local(k,r,s,rletras,sletras,numeros,M,kk);
	var kk = mensaje.length;
	var numeros = letrasnum(mensaje);
	var M = listanum(numeros);
	var k = random(p);
	var r = (g%p)^k;
	var s = M*(alfa%p)^k;
	var rletras = numletras( numlista(r,kk+1) );
	var sletras = numletras( numlista(s,kk+1) );
	[rletras,sletras]
}

function descifrarelgamal(RS,p,g,a) {
	var rletras=RS[1];
	var sletras=RS[2];
	var l=rletras.length;
	var r=listanum(letrasnum(rletras));
	var s=listanum(letrasnum(sletras));
	var M=(s%p)*(r%p)^(-a);
	var numeros = numlista(M,l-1);
	numletras(numeros);
}
