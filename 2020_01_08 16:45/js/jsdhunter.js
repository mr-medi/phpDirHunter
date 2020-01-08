"use strict";
var PNG1 = document.getElementById("png1");
var PNG2 = document.getElementById("png2");
var PNG3 = document.getElementById("png3");
var NAV = document.getElementsByClassName("content");
var TABLA1 = document.getElementById("tabla1");
var GIF = document.getElementById("gif");
var bADic1 = document.getElementById("botonAgregarDiccionario1");
var bADom1 = document.getElementById("botonAgregarDominio1");

var cont = 0;

function crearElemento(etiqueta, IDpadre, tipo, hint, nombre) {
  if(!etiqueta)
    throw new SyntaxError("El parámetro etiqueta está sin definir."); 

  if(!IDpadre)
    throw new SyntaxError("El parámetro padre está sin definir."); 

  var elemento = document.createElement(etiqueta);
 
  elemento.placeholder = hint;
  elemento.type = tipo;
  elemento.name = nombre;

  document.getElementById(IDpadre).appendChild(elemento);

}



function añadirCampos(contador, dominio, diccionario) {

  ++contador;
  if (dominio)
    crearElemento("input", "domains", "text", "https://example.com", "dominio"+contador);

  if (diccionario)
    crearElemento("input", "domains", "text", "https://example.com/list.txt", "dominio"+contador);

} 


function mostrarWeb() {

  setTimeout(function() {
    for(var j = 0; j < NAV.length; ++j)
      NAV[j].style.display="block";
  } ,1400);

}



function ocultarWeb() {

  NAV.style.display="none";
  PNG2.style.display="none";
  TABLA1.style.display="none";

}



function mostrarLink(link, IDpadre, dominio) {

  var elemento = document.createElement("iframe");
  var l = document.getElementById(link);
  elemento.src = dominio + "/" + l.href;
  document.getElementById(IDpadre).appendChild(elemento);

}


PNG1.addEventListener("click", function(){PNG2.style.display="block";PNG3.style.display="block";PNG1.style.display="none";TABLA1.style.display="table";TABLA1.style.visibility="visible";});
PNG3.addEventListener("click", function(){PNG2.style.display="none";PNG3.style.display="none";PNG1.style.display="block";TABLA1.style.display="none";TABLA1.style.visibility="hidden";});
GIF.addEventListener("load", function(){mostrarWeb()});

bADom1.addEventListener("click", function(){ añadirCampos(cont, true)});
bADic1.addEventListener("click", function(){ añadirCampos(cont, false, true)});


mostrarWeb();
