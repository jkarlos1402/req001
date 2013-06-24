//************************************//
//Nombre: Regino Tabares
//Funcion: Asignacion de propiedades de JQuery UI a los componentes BOTON, SUBMIT.
//			agrega estilo visual a los componentes
//			Inicializa el calendario
//Fecha:10/05/03
//*************************************
$(function() {
			
		$("input[type=button],input[type=submit]").button();
		$("input[type=text],select,td,tr,h2").addClass("ui-corner-all");
		$( "#accordion" ).accordion({
		heightStyle: "content"
		});
		$( "input[type=fecha]" ).datepicker({ dateFormat: 'yy-mm-dd' });
		
		$( "#dialog , #dialog2" ).dialog({
			modal: true,
      autoOpen: false,
      show: {
        effect: "blind",
        duration: 1000
      },
      hide: {
        effect: "explode",
        duration: 1000
      }
	  
    						});
		
});

//************************************//
//Nombre: Regino Tabares
//Funcion del módulo: Verifica los campos en el formulario antes de enviar los datos
//Fecha:10/05/03
//*************************************
$(function(){
	$("#formAddPoE").submit(function(){
		
		if(validaPoE(document.getElementById("bandera").value)){return true;
		}else{
			return false;
		}
	});
});


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: modificaCliente()
//Funcion del módulo: Habilita los 'inputs' para poder modificar el contenido y deshabilita los botones 'Eliminar' y 'Modificar'
//Fecha:10/05/03
//*************************************
function modificaCliente(){
	var con = confirm("¿Desea modificar los datos?");
	if (con == true){
		document.getElementById("NomEntCli").disabled = false;	
		document.getElementById("DirEntCli").disabled = false;	
		document.getElementById("TelEntCli").disabled = false;
		document.getElementById("botonG").style.visibility = 'visible';
		document.getElementById("botonG").style.display='';
		document.getElementById("botonesME").style.visibility = 'hidden';
		document.getElementById("botonesME").style.display='none';
	}
		}	
	
	function eliminaCliente(){
		alert("Eliminacion lógica");
	}


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfoCliente()
//Funcion del módulo: Llamar a "consultaCliente.php" para consultar e imprimir los datos del cliente sin recargar la página
//Fecha:10/05/03
//*************************************
function mostrarInfoCliente(IdEntCli){

var url = "../cliente/consultaCliente.php";
	$.post(url,{IdEntCli:IdEntCli},function(responseText){
		$("#datos").html(responseText);
	});

}

var contador=0;
var ct=0;


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: modifica()
//Funcion del módulo: Habilita los 'inputs' para poder modificar el contenido y deshabilita los botones 'Consultpagos' y 'Modificar'
//Fecha:10/05/03
//*************************************
	function modificaPoE(cont){

	var con = confirm("¿Desea modificar los datos?");
	if (con == true){
		document.getElementById('NomEntPoE').disabled = false;	
		document.getElementById('DirEntPoE').disabled = false;	
		document.getElementById('TelEntPoE').disabled = false;
		document.getElementById('RFCEntPoE').disabled = false;
		document.getElementById('GroEntPoE').disabled = false;
		document.getElementById('IdEntPfl').disabled = false;
		document.getElementById('Mod').style.visibility = 'hidden';
		document.getElementById('Mod').style.display = 'none';
		document.getElementById('Add').style.visibility = 'visible';
		document.getElementById('Add').style.display = '';
		document.getElementById('Save').style.visibility = 'visible';
		document.getElementById('Save').style.display = '';
		document.getElementById('Consultpagos').disabled = true;

		for(i=0;i<=cont;i++)
		{

			document.getElementById("banPoEmod"+i).style.visibility = 'visible';
			document.getElementById("banPoEmod"+i).style.display = '';
			document.getElementById("banPoE"+i).style.visibility = 'hidden';
			document.getElementById("banPoE"+i).style.display='none';
			document.getElementById("sucPoE"+i).disabled = false;
			document.getElementById("ctaPoE"+i).disabled = false;
			document.getElementById("cbePoE"+i).disabled = false;
			}
	
	}
	}
	
	function eliminaPoE(){
		alert("Eliminacion lógica");
	}
	
//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: agregarCampo()
//Funcion del módulo: Agrega una nueva fila con 'inputs' para rellenar y se les asigna dinámicamente el id y el name consecutivo 
//					  a los inputs que arrojo la consulta						
//Fecha:10/05/03
//*************************************
	function agregarCampoPoE(cont){
		ct++;
		if(contador>cont){
			
		}
		else{
		contador=cont;
		
		}
		consultabanco(contador);
       campo = '<tr><td width="111px"><div id="banco'+contador+'" style="display:block;"></div></td><td><input type="text" id="sucPoE'+contador+'" required="required" name="sucPoE'+contador+'" class="ui-corner-all"/></td><td><input type="text" required="required" name="ctaPoE'+contador+'" id="ctaPoE'+contador+'" class="ui-corner-all" /></td><td><input type="text" required="required" name="cbePoE'+contador+'" class="ui-corner-all"/></td></tr>';
	   $("#clon").append(campo);
	   contador++;

}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: consultabanco()
//Funcion del módulo: Llamar a banco.php y realizar la consulta de los bancos registrados e imprimirlos en un SELECT sin recargar la página					
//Fecha:10/05/03
//*************************************
function consultabanco(contador){
	var url = "../participante/banco.php";
	elegido=contador;
	$.post(url,{elegido:elegido},function(responseText){
		$("#banco"+contador).html(responseText);
	});
	
}


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: valida()
//Funcion del módulo: Valida que los campos Sucursal y Cuenta sólo sean numéricos 					
//Fecha:10/05/03
//*************************************
function validaPoE(aux)
{

	var codor = ct + aux;

	var i;
	for(i = 0;i <codor; i++){
	var	suc = "sucPoE"+i;
	var	cta = "ctaPoE"+i;
	var	cbe = "cbePoE"+i;	
	
	
	if(isNaN(document.getElementById(suc).value)){
			alert("La sucursal es numérica");
			document.getElementById(suc).focus();
			return false;
		}
	else if(isNaN(document.getElementById(cta).value)){
			alert("El número de cuenta es numérico");
			document.getElementById(cta).focus();
			return false;
		}
							}
return true;							
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfoPoE()
//Funcion del módulo: Llamar a "consultaParticipante.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:10/05/03
//*************************************
function mostrarInfoPoE(PoE){
var url = "../participante/consultaParticipante.php";
	$.post(url,{PoE:PoE},function(responseText){
		$("#datos").html(responseText);
	});
}


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfo()
//Funcion del módulo: Llamar a "consultaProyecto.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:13/05/03
//*************************************
function mostrarInfoProyecto(IdEntPry){

var url = "../proyecto/consultaProyecto.php";
	$.post(url,{IdEntPry:IdEntPry},function(responseText){
		$("#datos").html(responseText);
	});

}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfo()
//Funcion del módulo: Llamar a "consultaProyecto.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:13/05/03
//*************************************
function mostrarInfoIng(IdEntPry){

var url = "../ingresos/consultaIngresos.php";
	$.post(url,{IdEntPry:IdEntPry},function(responseText){
		$("#datos").html(responseText);
	});

}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: actualizarFecha()
//Funcion del módulo: Habilita los 'inputs' para poder modificar el contenido y manda llamar a "actualizaFechaPago.php" para realizar el registro
//Fecha:10/05/03
//*************************************
function actualizarFecha(IdEntPag,fecha,cont){
if(confirm("¿Deseas guardar la fecha de pago?"))
{		
	document.getElementById("div"+cont).style.visibility = 'hidden';
	document.getElementById("div"+cont).style.display='none';
	document.getElementById("divoculto"+cont).style.visibility = 'visible';
	document.getElementById("divoculto"+cont).style.display='';
	
		var url = "../ingresos/actualizaFechaPago.php";
	$.post(url,{IdEntPag: IdEntPag, fecha: fecha},function(responseText){
		$("#mensaje").html(responseText);
	});
	
	return;	
}
}

////////////////////////////////////////////////////////////////////////////
function selTodos(cont,proceso)
{

		if(proceso==1)
		{
			for(var i=1;i<cont;i++)
				{
				document.getElementById("pago"+i).checked=1;
				}
			if(confirm("¿Deseas programar todos los pagos?"))
				{
				document.getElementById("formulario").submit();
				}
			else
				{
					for(var i=1;i<cont;i++)
					{
					document.getElementById("pago"+i).checked=0;
					}
				}
		}
		if(proceso==2)
		{
			for(var i=1;i<cont;i++)
				{
				document.getElementById("pago"+i).checked=1;
				}
			if(confirm("¿Deseas consultar todos los pagos?"))
				{
				
				}
			else
				{
					for(var i=1;i<cont;i++)
					{
					document.getElementById("pago"+i).checked=0;
					}
				}
		}
	
}

////////////////////////////////////////////////////////////////////////////
function programaDisp(aux){
	if(confirm("¿Deseas programar dispersión?")){
	document.getElementById("pago"+aux).checked=1;
	document.getElementById("formulario").submit();
	}
}

////////////////////////////////////////////////////////////////////////////
function programaSel(){
	document.getElementById("formulario").submit();	
}

////////////////////////////////////////////////////////////////////////////
function habilitaDispersion(aux){
	document.getElementById("controlDispersion"+aux).style.visibility = "visible";
	document.getElementById("controlDispersion"+aux).style.display = "";	
	document.getElementById("Programar"+aux).disabled = true;
	
	arrayPosiciones[aux]=[];
	arrayPosiciones[aux ][1]=1;
	
	
}

/*
function accionSelecionados(cont,proceso){

		if(proceso==1)
		{
			if(confirm("¿Deseas programar los pagos seleccionados?")){
				for(var i=1;i<cont;i++){
					if(document.getElementById("pago"+i).checked == 1)
					{
						
					}
				}
			}
			
		}
		if(proceso==2)
		{
			for(var i=1;i<cont;i++){
				document.getElementById("pago"+i).checked=1;
			}
			if(confirm("¿Deseas consultar todos los pagos?")){
				
			}
			else
			{
				for(var i=1;i<cont;i++){
				document.getElementById("pago"+i).checked=0;
			}
			}
		}
	
}
*/


/////////////////////////////////////////////////////////////////////////////////////
function consultaBanco(IdEntPoE,padre,hijo){
		
	var url = "../ingresos/banco.php";
	$("#datoscuenta").html("");
	$.post(url,{IdEntPoE:IdEntPoE,padre:padre,hijo:hijo},function(responseText){
		$("#datosbanco"+padre+""+hijo).html(responseText);
	});
}

///////////////////////////////////////////////////////////////////////////////////////
function consultaBancoSec(IdEntPoE,padre,hijo,hijosec){
	alert("Debe aparecer en"+padre+""+hijo+""+hijosec);
	var url = "../ingresos/bancoSec.php";
	$("#datoscuenta"+padre+""+hijo+""+hijosec).html("");
	$.post(url,{IdEntPoE:IdEntPoE,padre:padre,hijo:hijo,hijosec:hijosec},function(responseText){
		$("#datosbanco"+padre+""+hijo+""+hijosec).html(responseText);
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaCuenta(IdEntPoE,IdEntBan,padre,hijo){
	var url = "../ingresos/cuenta.php";
	$.post(url,{IdEntPoE:IdEntPoE,IdEntBan:IdEntBan,padre:padre,hijo:hijo},function(responseText){
		$("#datoscuenta"+padre+""+hijo).html(responseText);
	});
}

///////////////////////////////////////////////////////////////////////////////////////
function consultaCuentaSec(IdEntPoE,IdEntBan,padre,hijo,hijosec){
	alert("Debe aparecer en"+padre+""+hijo+""+hijosec);
	var url = "../ingresos/cuentaSec.php";
	$.post(url,{IdEntPoE:IdEntPoE,IdEntBan:IdEntBan,padre:padre,hijo:hijo,hijosec:hijosec},function(responseText){
		$("#datoscuenta"+padre+""+hijo+""+hijosec).html(responseText);
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaOrigen(padre,hijo){
	$("#origen"+padre+""+hijo).html("");
	var url = "../ingresos/origen.php";
	$.post(url,{padre:padre,hijo:hijo},function(responseText){
		$("#origen"+padre+""+hijo).html(responseText);
	});
	consultaDestino(padre,hijo);
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaDestino(padre,hijo){
	$("#dest"+padre+""+hijo).html("");
	var url = "../ingresos/destino.php";
	$.post(url,{padre:padre,hijo:hijo},function(responseText){
		$("#dest"+padre+""+hijo).html(responseText);
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function guardarOrigen(){
	var url = "../ingresos/guardaOrigen.php";
	var origennuevo=document.getElementById("nuevoorg").value;
	$.post(url,{origennuevo:origennuevo},function(responseText){
		$("#mensaje").html(responseText);
	consultaOrigen();	
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function guardarDestino(){
	var url = "../ingresos/guardaDestino.php";
	var destinonuevo=document.getElementById("nuevodest").value;
	$.post(url,{destinonuevo:destinonuevo},function(responseText){
		$("#mensaje2").html(responseText);
	consultaDestino();	
	});
}


/////////////////////////////////////////////////////////////////////////////////////
function agregaOrigen(valor){
	if(valor == 'otros')
	{	
	$( "#dialog").dialog( "open" );
	}
	
}

/////////////////////////////////////////////////////////////////////////////////////
function agregaDestino(valor,padre,hijo,hijosec){
	if(valor == 'otros')
	{	
	$( "#dialog2").dialog( "open" );
	}
	if(valor==2||valor==3){
		alert("Se debe abrir "+padre+"_"+hijo+"_"+hijosec);
		habilitaDispersionSecundaria(padre,hijo,hijosec);
	}
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: mostrarInfoPoE()
//Funcion del módulo: Llamar a "consultaParticipante.php" para consultar e imprimir los datos del participante sin recargar la página
//Fecha:10/05/03
//*************************************
function consultaPoE(padre,hijo){
var url = "../ingresos/PoE.php";
	$.post(url,{padre:padre,hijo:hijo},function(responseText){
		$("#datosPoE"+padre+""+hijo).html(responseText);
	});
}

var arrayPosiciones;
function arrayPagos(pagos){
arrayPosiciones = new Array(pagos+1);
}

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: agregarCampo()
//Funcion del módulo: Agrega una nueva fila con 'inputs' para rellenar y se les asigna dinámicamente el id y el name consecutivo 
//					  a los inputs que arrojo la consulta						
//Fecha:10/05/03
//*************************************
padreviejo=1;
hijonuevo=1;
var conta=1;
/////////////////////////////////////////////////////////////////////// REVISAR LOS ARRAYS, BUSCAR LA FORMA DE REDIMENSIONAR SIN PERDER LA INFORMACION
	function agregaDispersion(padre,hijo){

			hijonuevo++;
			
			if(padre!=padreviejo){
			
				hijonuevo=2;
			}
		
	
	//arrayPosiciones[padre]=[];
	arrayPosiciones[padre][hijonuevo]=1;
	
		
	$("#cve"+padre+hijo).attr('name',"cve"+padre+hijonuevo);
	$("#cve"+padre+hijo).attr('id',"cve"+padre+hijonuevo);					
	$("#IdEntPoE"+padre+hijo).attr('name',"IdEntPoE"+padre+hijonuevo);
	$("#IdEntPoE"+padre+hijo).attr('id',"IdEntPoE"+padre+hijonuevo);
	$("#FecMovDspPag"+padre+hijo).attr('name',"FecMovDspPag"+padre+hijonuevo);
	$("#FecMovDspPag"+padre+hijo).attr('id',"FecMovDspPag"+padre+hijonuevo);
	$("#IdOrgPag"+padre+hijo).attr('name',"IdOrgPag"+padre+hijonuevo);
	$("#IdOrgPag"+padre+hijo).attr('id',"IdOrgPag"+padre+hijonuevo);
	$("#MonDspPag"+padre+hijo).attr('name',"MonDspPag"+padre+hijonuevo);
	$("#MonDspPag"+padre+hijo).attr('id',"MonDspPag"+padre+hijonuevo);
	$("#datosbanco"+padre+hijo).attr('id',"datosbanco"+padre+hijonuevo);
	$("#datoscuenta"+padre+hijo).attr('id',"datoscuenta"+padre+hijonuevo);
	$("#IdDesPag"+padre+hijo).attr('name',"IdDesPag"+padre+hijonuevo);
	$("#IdDesPag"+padre+hijo).attr('id',"IdDesPag"+padre+hijonuevo);
	
	
	$("#agrega"+padre+hijo).attr('id',"agrega"+padre+hijonuevo);
	
	var newElem = $('#dispersion'+padre+hijo).clone().attr('id', 'dispersion'+padre+hijonuevo);//se clona el renglon
	
	

	$("#cve"+padre+hijo+1).attr('name',"cve"+padre+hijonuevo+1);
	$("#cve"+padre+hijo+1).attr('id',"cve"+padre+hijonuevo+1);					
	$("#IdEntPoE"+padre+hijo+1).attr('name',"IdEntPoE"+padre+hijonuevo+1);
	$("#IdEntPoE"+padre+hijo+1).attr('id',"IdEntPoE"+padre+hijonuevo+1);
	$("#FecMovDspPag"+padre+hijo+1).attr('name',"FecMovDspPag"+padre+hijonuevo+1);
	$("#FecMovDspPag"+padre+hijo+1).attr('id',"FecMovDspPag"+padre+hijonuevo+1);
	$("#IdOrgPag"+padre+hijo+1).attr('name',"IdOrgPag"+padre+hijonuevo+1);
	$("#IdOrgPag"+padre+hijo+1).attr('id',"IdOrgPag"+padre+hijonuevo+1);
	$("#MonDspPag"+padre+hijo+1).attr('name',"MonDspPag"+padre+hijonuevo+1);
	$("#MonDspPag"+padre+hijo+1).attr('id',"MonDspPag"+padre+hijonuevo+1);
	$("#datosbanco"+padre+hijo+1).attr('id',"datosbanco"+padre+hijonuevo+1);
	$("#datoscuenta"+padre+hijo+1).attr('id',"datoscuenta"+padre+hijonuevo+1);
	$("#IdDesPag"+padre+hijo+1).attr('name',"IdDesPag"+padre+hijonuevo+1);
	$("#IdDesPag"+padre+hijo+1).attr('id',"IdDesPag"+padre+hijonuevo+1);
	
	var newElemSec = $("#dispSec"+padre+hijo+1).clone().attr('id', 'dispSec'+padre+hijonuevo+1);
	
	$("#cve"+padre+hijonuevo+1).attr('name',"cve"+padre+hijo+1);
	$("#cve"+padre+hijonuevo+1).attr('id',"cve"+padre+hijo+1);					
	$("#IdEntPoE"+padre+hijonuevo+1).attr('name',"IdEntPoE"+padre+hijo+1);
	$("#IdEntPoE"+padre+hijonuevo+1).attr('id',"IdEntPoE"+padre+hijo+1);
	$("#FecMovDspPag"+padre+hijonuevo+1).attr('name',"FecMovDspPag"+padre+hijo+1);
	$("#FecMovDspPag"+padre+hijonuevo+1).attr('id',"FecMovDspPag"+padre+hijo+1);
	$("#IdOrgPag"+padre+hijonuevo+1).attr('name',"IdOrgPag"+padre+hijo+1);
	$("#IdOrgPag"+padre+hijonuevo+1).attr('id',"IdOrgPag"+padre+hijo+1);
	$("#MonDspPag"+padre+hijonuevo+1).attr('name',"MonDspPag"+padre+hijo+1);
	$("#MonDspPag"+padre+hijonuevo+1).attr('id',"MonDspPag"+padre+hijo+1);
	$("#datosbanco"+padre+hijonuevo+1).attr('id',"datosbanco"+padre+hijo+1);
	$("#datoscuenta"+padre+hijonuevo+1).attr('id',"datoscuenta"+padre+hijo+1);
	$("#IdDesPag"+padre+hijonuevo+1).attr('name',"IdDesPag"+padre+hijo+1);
	$("#IdDesPag"+padre+hijonuevo+1).attr('id',"IdDesPag"+padre+hijo+1);
	//var newElemSec = $("#dispSec"+padre+hijo).clone().attr('id', 'dispSec'+padre+hijonuevo);
		
	//se regresan originales
	$("#cve"+padre+hijonuevo).attr('name',"cve"+padre+hijo);
	$("#cve"+padre+hijonuevo).attr('id',"cve"+padre+hijo);
	$("#IdEntPoE"+padre+hijonuevo).attr('name',"IdEntPoE"+padre+hijo);
	$("#IdEntPoE"+padre+hijonuevo).attr('id',"IdEntPoE"+padre+hijo);
	$("#FecMovDspPag"+padre+hijonuevo).attr('name',"FecMovDspPag"+padre+hijo);
	$("#FecMovDspPag"+padre+hijonuevo).attr('id',"FecMovDspPag"+padre+hijo);
	$("#IdOrgPag"+padre+hijonuevo).attr('name',"IdOrgPag"+padre+hijo);
	$("#IdOrgPag"+padre+hijonuevo).attr('id',"IdOrgPag"+padre+hijo);
	$("#MonDspPag"+padre+hijonuevo).attr('name',"MonDspPag"+padre+hijo);
	$("#MonDspPag"+padre+hijonuevo).attr('id',"MonDspPag"+padre+hijo);
	$("#datosbanco"+padre+hijonuevo).attr('id',"datosbanco"+padre+hijo);
	$("#datoscuenta"+padre+hijonuevo).attr('id',"datoscuenta"+padre+hijo);
	$("#IdDesPag"+padre+hijonuevo).attr('name',"IdDesPag"+padre+hijo);
	$("#IdDesPag"+padre+hijonuevo).attr('id',"IdDesPag"+padre+hijo);
	
	
	$("#agrega"+padre+hijonuevo).attr('id',"agrega"+padre+hijo);
	$("#dispSec"+padre+hijonuevo+1).attr('id',"dispSec"+padre+hijo+1);
	
	
			
	
	$("#dispSec"+padre+(arrayPosiciones[padre].length-2)+(arrayPosiciones[padre][hijonuevo-1])).after(newElem);
			
	$("#dispersion"+padre+(arrayPosiciones[padre].length-1)).after(newElemSec);
			
		
		//se inserta el nuevo renglon
	//se eliminan campos innecesarios
	
	$("#dispersion"+padre+hijonuevo).css("background-color","#01DF01")
	$("#FecMovDspPag"+padre+hijonuevo).removeClass("hasDatepicker");	
	$( "input[type=fecha]").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#IdEntPoE"+padre+hijonuevo).attr('onchange',"consultaBanco(this.value,"+padre+","+hijonuevo+")");
	$("#IdDesPag"+padre+hijonuevo).attr('onchange',"agregaDestino(this.value,"+padre+","+hijonuevo+",1)");
	$("#datosbanco"+padre+hijonuevo).html("");
	$("#cve"+padre+hijonuevo).attr('value',""+padre+hijonuevo);
	$("#datoscuenta"+padre+hijonuevo).html("");
	$("#agrega"+padre+hijonuevo).attr('onClick',"agregaDispersionSecundaria("+padre+","+hijonuevo+",1)");
	$("#agrega"+padre+hijonuevo).css("visibility","hidden");
	$("#agrega"+padre+hijonuevo).css("display","none");
	
	$("#dispSec"+padre+conta+1).css("background-color","#A9F5A9");
	$("#dispSec"+padre+hijonuevo+1).css("visibility","hidden");
	$("#dispSec"+padre+hijonuevo+1).css("display","none");
	$("#FecMovDspPag"+padre+hijonuevo+1).removeClass("hasDatepicker");
	$( "input[type=fecha]").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#IdEntPoE"+padre+hijonuevo+1).attr('onchange',"consultaBancoSec(this.value,"+padre+","+hijonuevo+",1)");
	$("#datosbanco"+padre+hijonuevo+1).html("");
	$("#cve"+padre+hijonuevo+1).attr('value',""+padre+hijonuevo+1);
	$("#datoscuenta"+padre+hijonuevo+1).html("");
	

	padreviejo=padre;   
	conta++;
	contasec=1;
}


var sec=0;
///////////////////////////////////////////////////////////
function habilitaDispersionSecundaria(pago,dispersion,hijo){
	document.getElementById("dispSec"+pago+dispersion+hijo).style.visibility = "visible";
	document.getElementById("dispSec"+pago+dispersion+hijo).style.display = "";
	document.getElementById("agrega"+pago+dispersion).style.visibility = "visible";
	document.getElementById("agrega"+pago+dispersion).style.display = "";
}

var hijosecnuevo=1;
var contasec=1;
var dispersionvieja=1;
var pagoviejo=1;

///////////////////////////////////////////////////////////////
function agregaDispersionSecundaria(pago,dispersion,hijo){
	hijosecnuevo++;
	
		if((pago!=pagoviejo&&dispersion!=dispersionvieja)||(pago!=pagoviejo)||(dispersion!=dispersionvieja)){
				
								
				if(arrayPosiciones[pago][dispersion]==1){
					hijosecnuevo=2;
					
					//alert("if"+hijosecnuevo);
					}
				else{
						if(arrayPosiciones[pago][dispersion]==null)
						{
						//alert("es nulo");
						}
						else{
							hijosecnuevo=1+(arrayPosiciones[pago][dispersion]);
							//alert("Y ademas entro aqui tamb"+hijosecnuevo);
							}
				}
				
				
			}
			
				
	arrayPosiciones[pago][dispersion]=hijosecnuevo;
	$("#cve"+pago+dispersion+hijo).attr('name',"cve"+pago+dispersion+hijosecnuevo);
	$("#cve"+pago+dispersion+hijo).attr('id',"cve"+pago+dispersion+hijosecnuevo);					
	$("#IdEntPoE"+pago+dispersion+hijo).attr('name',"IdEntPoE"+pago+dispersion+hijosecnuevo);
	$("#IdEntPoE"+pago+dispersion+hijo).attr('id',"IdEntPoE"+pago+dispersion+hijosecnuevo);
	$("#FecMovDspPag"+pago+dispersion+hijo).attr('name',"FecMovDspPag"+pago+dispersion+hijosecnuevo);
	$("#FecMovDspPag"+pago+dispersion+hijo).attr('id',"FecMovDspPag"+pago+dispersion+hijosecnuevo);
	$("#IdOrgPag"+pago+dispersion+hijo).attr('name',"IdOrgPag"+pago+dispersion+hijosecnuevo);
	$("#IdOrgPag"+pago+dispersion+hijo).attr('id',"IdOrgPag"+pago+dispersion+hijosecnuevo);
	$("#MonDspPag"+pago+dispersion+hijo).attr('name',"MonDspPag"+pago+dispersion+hijosecnuevo);
	$("#MonDspPag"+pago+dispersion+hijo).attr('id',"MonDspPag"+pago+dispersion+hijosecnuevo);
	$("#datosbanco"+pago+dispersion+hijo).attr('id',"datosbanco"+pago+dispersion+hijosecnuevo);
	$("#datoscuenta"+pago+dispersion+hijo).attr('id',"datoscuenta"+pago+dispersion+hijosecnuevo);
	$("#IdDesPag"+pago+dispersion+hijo).attr('name',"IdDesPag"+pago+dispersion+hijosecnuevo);
	$("#IdDesPag"+pago+dispersion+hijo).attr('id',"IdDesPag"+pago+dispersion+hijosecnuevo);
	
	
	var newElemSec = $("#dispSec"+pago+dispersion+hijo).clone().attr('id', 'dispSec'+pago+dispersion+hijosecnuevo);
	
	$("#cve"+pago+dispersion+hijosecnuevo).attr('name',"cve"+pago+dispersion+hijo);
	$("#cve"+pago+dispersion+hijosecnuevo).attr('id',"cve"+pago+dispersion+hijo);					
	$("#IdEntPoE"+pago+dispersion+hijosecnuevo).attr('name',"IdEntPoE"+pago+dispersion+hijo);
	$("#IdEntPoE"+pago+dispersion+hijosecnuevo).attr('id',"IdEntPoE"+pago+dispersion+hijo);
	$("#FecMovDspPag"+pago+dispersion+hijosecnuevo).attr('name',"FecMovDspPag"+pago+dispersion+hijo);
	$("#FecMovDspPag"+pago+dispersion+hijosecnuevo).attr('id',"FecMovDspPag"+pago+dispersion+hijo);
	$("#IdOrgPag"+pago+dispersion+hijosecnuevo).attr('name',"IdOrgPag"+pago+dispersion+hijo);
	$("#IdOrgPag"+pago+dispersion+hijosecnuevo).attr('id',"IdOrgPag"+pago+dispersion+hijo);
	$("#MonDspPag"+pago+dispersion+hijosecnuevo).attr('name',"MonDspPag"+pago+dispersion+hijo);
	$("#MonDspPag"+pago+dispersion+hijosecnuevo).attr('id',"MonDspPag"+pago+dispersion+hijo);
	$("#datosbanco"+pago+dispersion+hijosecnuevo).attr('id',"datosbanco"+pago+dispersion+hijo);
	$("#datoscuenta"+pago+dispersion+hijosecnuevo).attr('id',"datoscuenta"+pago+dispersion+hijo);
	$("#IdDesPag"+pago+dispersion+hijosecnuevo).attr('name',"IdDesPag"+pago+dispersion+hijo);
	$("#IdDesPag"+pago+dispersion+hijosecnuevo).attr('id',"IdDesPag"+pago+dispersion+hijo);
	
	//alert("#dispSec"+pago+dispersion+(arrayPosiciones[pago][dispersion]-1));
	$("#dispSec"+pago+dispersion+(arrayPosiciones[pago][dispersion]-1)).after(newElemSec);
	
	$("#dispSec"+pago+dispersion+hijosecnuevo).css("background-color","#A9F5A9");
	$("#FecMovDspPag"+pago+dispersion+hijosecnuevo).removeClass("hasDatepicker");
	$( "input[type=fecha]").datepicker({ dateFormat: 'yy-mm-dd' });
	$("#IdEntPoE"+pago+dispersion+hijosecnuevo).attr('onchange',"consultaBancoSec(this.value,"+pago+","+dispersion+","+hijosecnuevo+")");
	$("#datosbanco"+pago+dispersion+hijosecnuevo).html("");
	$("#cve"+pago+dispersion+hijosecnuevo).attr('value',""+pago+dispersion+hijosecnuevo);
	$("#datoscuenta"+pago+dispersion+hijosecnuevo).html("");
	
			//alert(pago+""+dispersion+""+contasec);
	dispersionvieja=dispersion;
	pagoviejo=pago;
	contasec++;

}


var total=0;
var suma;
/////////////////////////////////////////////////////////////
function validaTotal(pago){
suma=0;
	
		if(conta==null){
		conta=1;	
		}
	
		for(i=1;i <=conta;i++){
			suma=suma+parseInt(document.getElementById("MonDspPag"+pago+i).value);
		}
		if(suma > document.getElementById("montoTotal"+pago).value){
			$("#error"+pago).addClass("ui-state-error ui-corner-all");
			$("#error"+pago).html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Error:</b> Se superó el monto del pago!");
		return false;	
		}
		else{
			$("#error"+pago).removeClass("ui-state-error ui-corner-all");
			$("#error"+pago).html("");
			return true;
	}
		
		
}
