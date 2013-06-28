////////////////////////////////////////////////////////////////////////////
function habilitaDispersion(aux){
	document.getElementById("controlDispersion"+aux).style.visibility = "visible";
	document.getElementById("controlDispersion"+aux).style.display = "";	
	document.getElementById("Programar"+aux).disabled = true;
	$("#numeroDeDispersion"+aux).val(1);
	//arrayPosiciones[aux]=[];
	//arrayPosiciones[aux ][1]=1;
	
	
}


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
	//alert("Debe aparecer en"+padre+""+hijo+""+hijosec);
	var url = "../ingresos/bancoSec.php";
	$("#datoscuenta"+padre+""+hijo+""+hijosec).html("");
	$.post(url,{IdEntPoE:IdEntPoE,padre:padre,hijo:hijo,hijosec:hijosec},function(responseText){
		$("#datosbanco"+padre+""+hijo+""+hijosec).html(responseText);
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaCuenta(IdEntPoE,IdEntBan,padre,hijo){
	if($(IdEntBan).val() != -1){
		var url = "../ingresos/cuenta.php";
		$.post(url,{IdEntPoE:IdEntPoE,IdEntBan:IdEntBan.value,padre:padre,hijo:hijo},function(responseText){
			$("#datoscuenta"+padre+""+hijo).html(responseText);
		});
	}else{
		$("#datoscuenta"+padre+""+hijo).html("");
	}
}

///////////////////////////////////////////////////////////////////////////////////////
function consultaCuentaSec(IdEntPoE,IdEntBan,padre,hijo,hijosec){
	if($(IdEntBan).val() != -1){
		var url = "../ingresos/cuentaSec.php";
		$.post(url,{IdEntPoE:IdEntPoE,IdEntBan:$(IdEntBan).val(),padre:padre,hijo:hijo,hijosec:hijosec},function(responseText){
			$("#datoscuenta"+padre+hijo+hijosec).html(responseText);
		});
	}else{
		$("#datoscuenta"+padre+""+hijo+hijosec).html("");
	}
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

/////////////////////////////////////////
function habilitaOrigen(combo,pago,dispersion,secundaria){
	if($(combo).val()!= -1){
		$("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("visibility","visible");
		$("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("display","");
	}else{
		$("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("visibility","hidden");
		$("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("display","none");
		$("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").prop("selectedIndex",0);
		if(secundaria == 0){
			$("#datosbanco"+pago+dispersion).html("");
			$("#datoscuenta"+pago+dispersion).html("");
		}else{
			$("#datosbanco"+pago+dispersion+secundaria).html("");
			$("#datoscuenta"+pago+dispersion+secundaria).html("");
		}
	}
}
/////////////////////////////////////////////////////////////////////////////////////
function agregaOrigen(valor,pago,dispersion,secundaria){
	if(valor.value == 'otros')
	{	
	$( "#dialog").dialog( "open" );
	}
	if($("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_ :selected").text() == "DEPOSITO" || $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_ :selected").text() == "TRANSFERENCIA"){
		if(secundaria == 0)
			consultaBanco($("#IdEntPoE_"+pago+"_"+dispersion+"_"+secundaria+"_").val(),pago,dispersion);
		else
			consultaBancoSec($("#IdEntPoE_"+pago+"_"+dispersion+"_"+secundaria+"_").val(),pago,dispersion,secundaria);
	}else{
		if(secundaria == 0){
			$("#datosbanco"+pago+dispersion).html("");
			$("#datoscuenta"+pago+dispersion).html("");
		}else{
			$("#datosbanco"+pago+dispersion+secundaria).html("");
			$("#datoscuenta"+pago+dispersion+secundaria).html("");
		}
	}
}

/////////////////////////////////////////////////////////////////////////////////////
function agregaDestino(valor,padre,hijo,hijosec){
	if(valor == 'otros')
	{	
	$( "#dialog2").dialog( "open" );
	}
	if(valor==2||valor==3){
		habilitaDispersionSecundaria(padre,hijo,1);	
	}
	if(valor != 2 && valor != 3){
		$("#agrega"+padre+hijo).css({'visibility': 'hidden', 'display': 'none'});
		$("#divDispersion"+padre+hijo).find(".dispSec").css({'visibility': 'hidden', 'display': 'none'}).next(".dispSec").remove();//se eliminan dispersiones secundarias 
		$("#divDispersion"+padre+hijo).find("#numeroDeDispersionesSec"+padre+hijo).val("0");
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

var arrayPosiciones= [[],[]];
var arrayRegtotal=[];

conpag=0;
padreviejo=0;
hijonuevo=1;
var conta=1;

function dispersionesTotales(pago,dispersiones){
	arrayRegtotal[pago]=dispersiones;
}


//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: agregarCampo()
//Funcion del módulo: Agrega una nueva fila con 'inputs' para rellenar y se les asigna dinámicamente el id y el name consecutivo 
//					  a los inputs que arrojo la consulta						
//Fecha:10/05/03
//*************************************


//var contadorDispersion = 1;
function agregaDispersion(padre){
	var indicePago = parseInt($("#numerodePago"+padre).val());
	var indiceDispersion = parseInt($("#numerodePago"+padre).prev("div").find("div").last().find(".controlDispersion").val());
	/*if($("#agrega"+indicePago+1).hasClass("ui-button")){
			$("#agrega"+indicePago+indiceDispersion).button("destroy");
	}*/
	$("#IdEntPoE_"+indicePago+"_1_0_").attr('id',"IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_0_");
	$("#FecMovDspPag_"+indicePago+"_1_0_").attr('id',"FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_");
	$("#IdOrgPag_"+indicePago+"_1_0_").attr('id',"IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_");
	$("#MonDspPag_"+indicePago+"_1_0_").attr('id',"MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_");
	$("#datosbanco"+indicePago+1).attr('id',"datosbanco"+indicePago+(indiceDispersion+1));
	$("#datoscuenta"+indicePago+1).attr('id',"datoscuenta"+indicePago+(indiceDispersion+1));
	$("#IdDesPag_"+indicePago+"_1_0_").attr('id',"IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_");
	$("#numeroDeDispersion"+1).attr('id',"numeroDeDispersion"+(indiceDispersion+1));
	$("#numeroDeDispersionesSec"+indicePago+1).attr('id',"numeroDeDispersionesSec"+indicePago+(indiceDispersion+1));
	if($("#agrega"+padre+"1").hasClass("ui-button")){
		$("#agrega"+padre+"1").button("destroy");
	}
	var botonesControl = $("#numerodePago"+padre).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html();
	$("#agrega"+indicePago+1).attr('id',"agrega"+indicePago+(indiceDispersion+1));
		
	$("#IdEntPoE_"+indicePago+"_1_1_").attr('name',"IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"[]");
	$("#IdEntPoE_"+indicePago+"_1_1_").attr('id',"IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_1_");
	$("#FecMovDspPag_"+indicePago+"_1_1_").attr('name',"FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"[]");
	$("#FecMovDspPag_"+indicePago+"_1_1_").attr('id',"FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_");
	$("#IdOrgPag_"+indicePago+"_1_1_").attr('name',"IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"[]");
	$("#IdOrgPag_"+indicePago+"_1_1_").attr('id',"IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_");
	$("#MonDspPag_"+indicePago+"_1_1_").attr('name',"MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"[]");
	$("#MonDspPag_"+indicePago+"_1_1_").attr('id',"MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_");
	
	$("#datosbanco"+indicePago+1+1).attr('id',"datosbanco"+indicePago+(indiceDispersion+1)+1);
	$("#datoscuenta"+indicePago+1+1).attr('id',"datoscuenta"+indicePago+(indiceDispersion+1)+1);
	
	$("#IdDesPag_"+indicePago+"_1_1_").attr('name',"IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"[]");
	$("#IdDesPag_"+indicePago+"_1_1_").attr('id',"IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_"+1+"_");
	
	var newElem =$("#numerodePago"+padre).prev("div").find("div:first").clone().attr('id', 'divDispersion'+padre+(indiceDispersion+1));				
	$("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('name',"IdEntPoE_"+indicePago+"_1[]");
	$("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('id',"IdEntPoE_"+indicePago+"_1_1_");
	$("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('name',"FecMovDspPag_"+indicePago+"_1[]");
	$("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('id',"FecMovDspPag_"+indicePago+"_1_1_");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('name',"IdOrgPag_"+indicePago+"_1[]");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('id',"IdOrgPag_"+indicePago+"_1_1_");
	$("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('name',"MonDspPag_"+indicePago+"_1[]");
	$("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('id',"MonDspPag_"+indicePago+"_1_1_");
	
	$("#datosbanco"+indicePago+(indiceDispersion+1)+1).attr('id',"datosbanco"+indicePago+1+1);
	$("#datoscuenta"+indicePago+(indiceDispersion+1)+1).attr('id',"datoscuenta"+indicePago+1+1);
	
	$("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('name',"IdDesPag_"+indicePago+"_1[]");
	$("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('id',"IdDesPag_"+indicePago+"_1_1_");
	
	//se regresan originales
	$("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdEntPoE_"+indicePago+"_1_0_");
	$("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"FecMovDspPag_"+indicePago+"_1_0_");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdOrgPag_"+indicePago+"_1_0_");
	$("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"MonDspPag_"+indicePago+"_1_0_");
	$("#datosbanco"+indicePago+(indiceDispersion+1)).attr('id',"datosbanco"+indicePago+1);
	$("#datoscuenta"+indicePago+(indiceDispersion+1)).attr('id',"datoscuenta"+indicePago+1);
	$("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdDesPag_"+indicePago+"_1_0_");
	$("#numeroDeDispersion"+(indiceDispersion+1)).attr('id',"numeroDeDispersion"+1);
	$("#numeroDeDispersionesSec"+indicePago+(indiceDispersion+1)).attr('id',"numeroDeDispersionesSec"+indicePago+1);
	$("#numerodePago"+padre).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html(botonesControl);
	//$("#agrega"+padre+"1").button({icons: {primary: "ui-icon-plusthick"},text: false});
	$("#agrega"+indicePago+(indiceDispersion+1)).attr('id',"agrega"+indicePago+1);
	////////////////////////////////////////////////////////////////////////////////////
	if((indiceDispersion+1)>2){
            $("#elimina"+indicePago+indiceDispersion).html("");
            $("#elimina"+indicePago+indiceDispersion).removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only");
            $("#agrega"+indicePago+indiceDispersion).html("");
            $("#agrega"+indicePago+indiceDispersion).removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only");
            $("#elimina"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-trash"},text: false});
            $("#agrega"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});
	}
	newElem.find(".dispSec").attr("id","dispSec"+padre+(indiceDispersion+1)+1).css({'visibility': 'hidden', 'display': 'none'}).next(".dispSec").remove();//se eliminan dispersiones secundarias 
	newElem.find("#numeroDeDispersionesSec"+indicePago+(indiceDispersion+1)).val("0");
	newElem.find("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").val("");
	newElem.find("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").val("");
	$("#numerodePago"+padre).prev("div").find("div").last().after(newElem);// se inserta!!!!
	$("#elimina"+indicePago+(indiceDispersion+1)).button({icons: {primary: "ui-icon-trash"},text: false});
		//se inserta el nuevo renglon
	//se eliminan campos innecesarios
	
	$("#dispersion"+indicePago+(indiceDispersion+1)).css("background-color","#01DF01")
	$("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").removeClass("hasDatepicker");	
	$( "input[type=fecha]").datepicker({ dateFormat: 'dd-mm-yy' });
	$("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('onchange',"habilitaOrigen(this,"+indicePago+","+(indiceDispersion+1)+",0)");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('onchange',"agregaOrigen(this,"+indicePago+","+(indiceDispersion+1)+",0)");																					
	$("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('onchange',"agregaDestino(this.value,"+indicePago+","+(indiceDispersion+1)+",1)");
        $("#datosbanco"+indicePago+(indiceDispersion+1)).html("");
	$("#datoscuenta"+indicePago+(indiceDispersion+1)).html("");
	$("#agrega"+indicePago+(indiceDispersion+1)).attr('onClick',"agregaDispersionSecundaria("+indicePago+","+(indiceDispersion+1)+");");
	$("#agrega"+indicePago+(indiceDispersion+1)).css("visibility","hidden");
	$("#agrega"+indicePago+(indiceDispersion+1)).css("display","none");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").css("visibility","hidden");
	$("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").css("display","none");
	
	
	$("#dispSec"+indicePago+conta+1).css("background-color","#A9F5A9");
	$("#dispSec"+indicePago+(indiceDispersion+1)+1).css("visibility","hidden");
	$("#dispSec"+indicePago+(indiceDispersion+1)+1).css("display","none");
	$("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").removeClass("hasDatepicker");
	$( "input[type=fecha]").datepicker({ dateFormat: 'dd-mm-yy' });
	$("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('onchange',"consultaBancoSec(this.value,"+indicePago+","+(indiceDispersion+1)+",1)");
        $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('onblur',"validaTotalDispersion("+indicePago+","+(indiceDispersion+1)+")");
        $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").css("background-color","#FFF");
        $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").val("0.00");
	$("#datosbanco"+indicePago+(indiceDispersion+1)+1).html("");
	$("#datoscuenta"+indicePago+(indiceDispersion+1)+1).html("");
	
	$("#numerodePago"+padre).prev("div").find("div").last().find(".controlDispersion").val(indiceDispersion+1);
	$("#divDispersion"+padre+(indiceDispersion+1)).find("table").find("tr:first").find("td:first").html(padre+"."+(indiceDispersion+1));
	$("#divDispersion"+padre+(indiceDispersion+1)).find("table").find("tr:last").find("td:first").html(padre+"."+(indiceDispersion+1)+".1");
        $("#numerodePago"+padre).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html("<li id='agrega"+indicePago+(indiceDispersion+1)+"' style='visibility:hidden; display:none;' onclick='agregaDispersionSecundaria("+indicePago+','+(indiceDispersion+1)+");'></li><li id='elimina"+indicePago+(indiceDispersion+1)+"' onclick=eliminaDispersion("+indicePago+","+(indiceDispersion+1)+");></li>");
        $("#elimina"+padre+(indiceDispersion+1)).button({icons: {primary: "ui-icon-trash"},text: false});
        $("#agrega"+padre+"1").button({icons: {primary: "ui-icon-plusthick"},text: false});
        reOrganizaDispersion(indicePago,1);
}

function eliminaDispersion(pago,dispersion){
    if(confirm("¿Seguro de eliminar la dispersion del pago?")){
	$("#divDispersion"+pago+dispersion).remove();
	var indicePago = parseInt($("#numerodePago"+pago).val());
	var indiceDispersion = parseInt($("#numerodePago"+pago).prev("div").find("div").last().find(".controlDispersion").val());
	var html = "";
	if($("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_0_ option:selected").text() == "TRANSFERIRLOS A UNA CUENTA" || $("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_0_").text() == "REGRESAR EFECTIVO"){
		html = "<li id='agrega"+indicePago+indiceDispersion+"' onclick='agregaDispersionSecundaria("+indicePago+','+indiceDispersion+");'></li><li id='elimina"+indicePago+indiceDispersion+"' onclick=eliminaDispersion("+indicePago+","+indiceDispersion+");></li>";
		html2 =  "<li id='agrega"+indicePago+indiceDispersion+"' onclick='agregaDispersionSecundaria("+indicePago+','+indiceDispersion+");'></li>";
	}else{
		html = "<li id='agrega"+indicePago+indiceDispersion+"' style='visibility:hidden; display:none;' onclick='agregaDispersionSecundaria("+indicePago+','+indiceDispersion+");'></li><li id='elimina"+indicePago+indiceDispersion+"' onclick=eliminaDispersion("+indicePago+","+indiceDispersion+");></li>";
		html2 = "<li id='agrega"+indicePago+indiceDispersion+"' style='visibility:hidden; display:none;' onclick='agregaDispersionSecundaria("+indicePago+','+indiceDispersion+");'></li>";
	}
	if(indiceDispersion>1){
		$("#numerodePago"+pago).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html(html);
		$("#agrega"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});	
		$("#elimina"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-trash"},text: false});	
	}else{
		$("#numerodePago"+pago).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html(html2);
		$("#agrega"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});
	}
        reOrganizaDispersion(indicePago,1);
	validaTotal(indicePago);
    }
}

function reOrganizaDispersion(pago,dispersion){
    $("#controlDispersion"+pago).find("div").each(function(index){
       $(this).find("tr:first").find("td:first").html(pago+"."+(dispersion+index));
       reOrganizaSecundaria(this,pago,1,1,(dispersion+index));
    });
}

function reOrganizaSecundaria(div,pago,dispersion,secundaria,labelDispersion){
    $(div).find(".dispSec").each(function(index0){
        $(this).find("td:first").each(function(index){
            $(this).html(pago+"."+labelDispersion+"."+(index0+1));
        });
    });
    //$("#dispSec"+pago+dispersion+secundaria).nextAll("tr").each(function(index){ 
       // $(this).find("td:first").html(pago+"."+labelDispersion+"."+(secundaria+(index+1)));
    //});
}

var sec=0;
///////////////////////////////////////////////////////////
function habilitaDispersionSecundaria(pago,dispersion,hijo){
	document.getElementById("dispSec"+pago+dispersion+hijo).style.visibility = "visible";
	document.getElementById("dispSec"+pago+dispersion+hijo).style.display = "";
	document.getElementById("agrega"+pago+dispersion).style.visibility = "visible";
	document.getElementById("agrega"+pago+dispersion).style.display = "";
	if(!$("#agrega"+pago+dispersion).hasClass("ui-button"))
		$("#agrega"+pago+dispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});
	$("#numeroDeDispersionesSec"+pago+dispersion).val(parseInt($("#numeroDeDispersionesSec"+pago+dispersion).val())+1);
}

var hijosecnuevo=0;
var contasec=1;
var dispersionvieja=1;
var pagoviejo=1;

var arraySectotal = [[],[]];

////////////////////////////////////////
function aumentaDispersionSec(pago,disp,total){
	conpag=pago;
	condisp=disp;
	arraySectotal[conpag][condisp]=total+1;
	alert(pago+"_"+disp+"="+arraySectotal[conpag][condisp]);
}


///////////////////////////////////////////////////////////////
function agregaDispersionSecundaria(pago,dispersion){
	var indicePago = pago;
	var indiceDispersion = dispersion;
	var indiceDispersionSec = parseInt($("#numeroDeDispersionesSec"+indicePago+indiceDispersion).val());
	$("#cve_"+indicePago+"_"+indiceDispersion+"_1_").attr('name',"cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#cve_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");					
	$("#IdEntPoE_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"IdEntPoE_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#MonDspPag_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"MonDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#datosbanco"+indicePago+indiceDispersion+1).attr('id',"datosbanco"+indicePago+indiceDispersion+(indiceDispersionSec+1));
	$("#datoscuenta"+indicePago+indiceDispersion+1).attr('id',"datoscuenta"+indicePago+indiceDispersion+(indiceDispersionSec+1));
	
	$("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_1_").attr('id',"IdDesPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
		
	
	var newElemSec = $("#dispSec"+indicePago+indiceDispersion+"1").clone().attr('id','dispSec'+indicePago+indiceDispersion+(indiceDispersionSec+1));
	
	$("#cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('name',"cve_"+indicePago+"_"+indiceDispersion+"_1_");
	$("#cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"cve_"+indicePago+"_"+indiceDispersion+"_1_");					
	$("#IdEntPoE_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"IdEntPoE_"+indicePago+"_"+indiceDispersion+"_1_");
	$("#FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_1_");
	$("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"IdOrgPag_"+indicePago+"_"+indiceDispersion+"_1_");
	$("#MonDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"MonDspPag_"+indicePago+"_"+indiceDispersion+"_1_");
	$("#datosbanco"+indicePago+indiceDispersion+(indiceDispersionSec+1)).attr('id',"datosbanco"+indicePago+indiceDispersion+1);
	$("#datoscuenta"+indicePago+indiceDispersion+(indiceDispersionSec+1)).attr('id',"datoscuenta"+indicePago+indiceDispersion+1);
	
	$("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('id',"IdDesPag_"+indicePago+"_"+indiceDispersion+"_1_");
	
	$("#divDispersion"+indicePago+indiceDispersion).find("tr:last").after(newElemSec);
	
        $("#MonDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").val("0.00");
	$("#dispSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)).css("background-color","#A9F5A9");
	$("#FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").removeClass("hasDatepicker");
	$("input[type=fecha]").datepicker({ dateFormat: 'dd-mm-yy' });
	$("#IdEntPoE_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('onchange',"habilitaOrigen(this,"+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");");
        $("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('onchange',"agregaOrigen(this,"+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");");
	$("#datosbanco"+indicePago+indiceDispersion+(indiceDispersionSec+1)).html("");
	$("#cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('value',indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
	$("#datoscuenta"+indicePago+indiceDispersion+(indiceDispersionSec+1)).html("");
	if((indiceDispersionSec+1)>1){
            $("#numerodePago"+indicePago).prev("div").find("#divDispersion"+indicePago+indiceDispersion).find("table").find("tr:last").find("td:last").html("<li id='eliminaSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)+"' onclick=eliminaDispersionSec("+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");></li>");
            $("#eliminaSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)).button({icons: {primary: "ui-icon-trash"},text: false});	
	}
	$("#numeroDeDispersionesSec"+pago+indiceDispersion).val(indiceDispersionSec+1);
        reOrganizaDispersion(indicePago,1);
	//$("#divDispersion"+pago+indiceDispersion).find("table").find("tr:last").find("td:first").html(pago+"."+indiceDispersion+"."+(indiceDispersionSec+1));
}

function eliminaDispersionSec(pago,dispersion,secundaria){
    if(confirm("¿Seguro de eliminar la dispersion secundaria?")){
        $("#eliminaSec"+pago+dispersion+secundaria).parents("tr").remove();
        reOrganizaDispersion(pago,1);
    }
}


///////////////////////////////////////////////////////////// REVISAR LAS SUMAS!!!!
function validaTotal(pago){
	suma=0;
	montoTotal = parseFloat($("#montoTotal"+pago).val());
	$("#controlDispersion"+pago).find(".montoDispersion").each(function(index, element) {
            if(isNaN($(this).val()) || $(this).val() == "")
                $(this).val(0);
            $(this).val(parseFloat($(this).val()).toFixed(2));
            suma = parseFloat(suma) + parseFloat($(this).val());
            validaTotalDispersion(pago,(index+1));
        });
	if(suma > montoTotal){
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

function validaTotalDispersion(pago,dispersion){
    montoTotalSec = parseFloat($("#MonDspPag_"+pago+"_"+dispersion+"_0_").val());
    sumaSec = 0.00;
    $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index1){
        if(isNaN($(this).val()) || $(this).val() == "")
            $(this).val(0);
        $(this).val(parseFloat($(this).val()).toFixed(2));
        sumaSec += parseFloat($(this).val());
    });
    if(sumaSec > montoTotalSec){
        $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index2){
            $(this).css("background-color","#FEE9EC");
        });
        $("#errorSec"+pago).addClass("ui-state-error ui-corner-all");
	$("#errorSec"+pago).html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Error:</b> ¡Se superó el monto de la dispersion!");
	return false;
    }else{
        $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index3){
            $(this).css("background-color","#FFF");
        });
        $("#errorSec"+pago).removeClass("ui-state-error ui-corner-all");
        $("#errorSec"+pago).html("");
        return true; 
    }
}
///////////////////////////////////////////////////////////////////////////////////////
Array.prototype.getLength = function(){
  var i, c = 0;
  for(i in this) if(Object.prototype.hasOwnProperty.call(this, i)) c++;
  return c;
}

var cveaux;
//////////////////////////////////////////////////////////////////////////////////////////////////////
function guardarDispersiones(pago,idpago){
	
	disptotales = arrayPosiciones[pago].getLength();
	$("#form"+ pago+" #totdisp").val(disptotales);
	$("#form"+ pago+" #IdEntPag").val(idpago);
	$("#form"+ pago+" #pago").val(pago);
	
		document.getElementById("form"+pago).submit();
		
	/*
		for(i=1;i<=disptotales;i++){
			
				for(j=0;j<=arrayPosiciones[pago][i];j++){
					
					var valor = (document.getElementById("cve_"+pago+"_"+i+"_"+j+"_").value);
					
					cveaux = valor.split("_");
						//alert(cveaux[]);
						if(cveaux[2]==0){
							alert("if");	
								var IdEntPoE = document.getElementById("IdEntPoE_"+pago+"_"+i+"_"+j+"_").value;
								var FecMovDspPag = document.getElementById("FecMovDspPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdOrgPag = document.getElementById("IdOrgPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdEntBan = document.getElementById("IdEntBan_"+pago+"_"+i+"_"+j+"_").value;
								var IdEntCue = document.getElementById("IdEntCue_"+pago+"_"+i+"_"+j+"_").value;
								var MonDspPag = document.getElementById("MonDspPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdDesPag = document.getElementById("IdDesPag_"+pago+"_"+i+"_"+j+"_").value;
								
								//alert(IdEntPoE+FecMovDspPag+IdOrgPag+IdEntBan+IdEntCue+MonDspPag+IdDesPag)
																
								//var url = "../ingresos/registraDispersion.php";
								
								//$.post(url,{IdEntPag:idpago,IdEntPoE:IdEntPoE,FecMovDspPag:FecMovDspPag,IdOrgPag:IdOrgPag,IdEntBan:IdEntBan,IdEntCue:IdEntCue,MonDspPag:MonDspPag,IdDesPag:IdDesPag},function(responseText){
									//padre=responseText;
									//alert(padre);
									//})
									
									 $.ajax({url: "../ingresos/registraDispersion.php",
									  type: 'POST',
									  async: false,
									  data: { IdEntPag:idpago,IdEntPoE:IdEntPoE,FecMovDspPag:FecMovDspPag,IdOrgPag:IdOrgPag,IdEntBan:IdEntBan,IdEntCue:IdEntCue,MonDspPag:MonDspPag,IdDesPag:IdDesPag },
									  success:function(responseText){
										  alert(responseText);
									  }
									});
									
									
									
									
									
									
								
								
						}
						else{
							if(document.getElementById("FecMovDspPag_"+pago+"_"+i+"_"+j+"_").value==''){
								break;
							}
							else{
								
								alert("else");
								var IdEntPoE = document.getElementById("IdEntPoE_"+pago+"_"+i+"_"+j+"_").value;
								var FecMovDspPag = document.getElementById("FecMovDspPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdOrgPag = document.getElementById("IdOrgPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdEntBan = document.getElementById("IdEntBan_"+pago+"_"+i+"_"+j+"_").value;
								var IdEntCue = document.getElementById("IdEntCue_"+pago+"_"+i+"_"+j+"_").value;
								var MonDspPag = document.getElementById("MonDspPag_"+pago+"_"+i+"_"+j+"_").value;
								var IdDesPag = document.getElementById("IdDesPag_"+pago+"_"+i+"_"+j+"_").value;	
								
								var url = "../ingresos/registraDispersionSec.php";
								$.post(url,{padre:padre,IdEntPag:idpago,IdEntPoE:IdEntPoE,FecMovDspPag:FecMovDspPag,IdOrgPag:IdOrgPag,IdEntBan:IdEntBan,IdEntCue:IdEntCue,MonDspPag:MonDspPag,IdDesPag:IdDesPag},function(responseText){	
								alert(responseText);						
								});
								
								}
																				
						}
					
				}
			
		}
		*/
}