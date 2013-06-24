// JavaScript Document
/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: cambiaHtml
* Función del módulo: Cambia el contenido html del elemento señalada "workbench" mediante un archivo que contiene código html, recibe como parámetro al url del archivo con código html
* Fecha: 08/05/2013
*/
function cambiaHtml(url){
	document.getElementById('workbench').innerHTML = "<object data='"+url+"' class='homeobj'></object>";
}

