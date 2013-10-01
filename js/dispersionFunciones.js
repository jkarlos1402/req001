////////////////////////////////////////////////////////////////////////////
function habilitaDispersion(aux){
	document.getElementById("controlDispersion"+aux).style.visibility = "visible";
	document.getElementById("controlDispersion"+aux).style.display = "";	
	document.getElementById("Programar"+aux).disabled = true;
	$("#numeroDeDispersion"+aux).val(1);
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaBanco(IdEntPoE,padre,hijo,IdEntCue){		
	var url = "../ingresos/banco.php";
	$("#datoscuenta").html("");
	$.post(url,{IdEntPoE:IdEntPoE,padre:padre,hijo:hijo,IdEntCue:IdEntCue},function(responseText){
		$("#datosbanco"+padre+""+hijo).html(responseText);
	});
}

///////////////////////////////////////////////////////////////////////////////////////
function consultaBancoSec(IdEntPoE,padre,hijo,hijosec,IdEntCue){
	//alert("Debe aparecer en"+padre+""+hijo+""+hijosec);
	var url = "../ingresos/bancoSec.php";
	$("#datoscuenta"+padre+""+hijo+""+hijosec).html("");
	$.post(url,{IdEntPoE:IdEntPoE,padre:padre,hijo:hijo,hijosec:hijosec,IdEntCue:IdEntCue},function(responseText){
		$("#datosbanco"+padre+""+hijo+""+hijosec).html(responseText);
	});
}

/////////////////////////////////////////////////////////////////////////////////////
function consultaCuenta(IdEntPoE,IdEntBan,padre,hijo,IdEntCue){
    if(IdEntBan !== -1){
        var url = "../ingresos/cuenta.php";
        $.post(url,{IdEntPoE:IdEntPoE,IdEntBan:IdEntBan,padre:padre,hijo:hijo,IdEntCue:IdEntCue},function(responseText){
                $("#datoscuenta"+padre+""+hijo).html(responseText);
        });
    }else{
        $("#datoscuenta"+padre+""+hijo).html("");
    }
}

///////////////////////////////////////////////////////////////////////////////////////
function consultaCuentaSec(IdEntPoE,IdEntBan,padre,hijo,hijosec,IdEntCue){
    if(IdEntBan !== -1){
        var url = "../ingresos/cuentaSec.php";
        $.post(url,{IdEntPoE:IdEntPoE,IdEntBan:IdEntBan,padre:padre,hijo:hijo,hijosec:hijosec,IdEntCue:IdEntCue},function(responseText){
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
    var url = "../ingresos/destino.php";
    $.post(url,{padre:padre,hijo:hijo},function(responseText){
        $("#divDispersion"+padre+hijo).find("tr:first").find("td:last").prev("td").html(responseText);
    });
}

/////////////////////////////////////////////////////////////////////////////////////
function guardarOrigen(){
    var url = "../ingresos/guardaOrigen.php";
    if($("#nuevoorg").val()!=''){
    var origennuevo=$("#nuevoorg").val();
    var ultimoIdOrigen = -1;
    $.post(url,{origennuevo:origennuevo},function(responseText){
            $("#dialog").dialog("close"); 
            ultimoIdOrigen=responseText;
            $(".origenDis").each(function(){
                $(this).find("option:last").remove();
                $(this).append("<option value='"+ultimoIdOrigen+"'>"+origennuevo+"</option><option value='otros'>OTRO...</option>");
            });
            $(".origenSec").each(function(){
                $(this).append("<option value='"+ultimoIdOrigen+"'>"+origennuevo+"</option>");
            });
    });
    }
    else{
        $("#msj").html('<p style="margin-left: 40px;"><span class="ui-icon ui-icon-alert" style="float: left;"></span><strong>Campo requerido</strong></p>')
                    .css({"color":"#cd0a0a","width": "210px"})
                    .addClass("ui-state-error ui-corner-all");
        $("#nuevoorg").focus();    
    }
}

/////////////////////////////////////////////////////////////////////////////////////
function guardarDestino(){
    var url = "../ingresos/guardaDestino.php";
    if($("#nuevodest").val()!=''){
            var destinonuevo=$("#nuevodest").val();
            var ultimoIdDestino = -1;
            $.post(url,{destinonuevo:destinonuevo},function(responseText){
                $("#dialog2").dialog("close"); 
                ultimoIdDestino = responseText;  
                $(".destinoDis").each(function(){
                    $(this).find("option:last").remove();
                    $(this).append("<option value='"+ultimoIdDestino+"'>"+destinonuevo+"</option><option value='otros'>OTRO...</option>");
                });
                $(".destinoSec").each(function(){
                    $(this).append("<option value='"+ultimoIdDestino+"'>"+destinonuevo+"</option>");
                });
            });
    }
    else{
        $("#msj2").html('<p style="margin-left: 40px;"><span class="ui-icon ui-icon-alert" style="float: left;"></span><strong>Campo requerido</strong></p>')
                    .css({"color":"#cd0a0a","width": "210px"})
                    .addClass("ui-state-error ui-corner-all");
        $("#nuevodest").focus();    
    }
}

/////////////////////////////////////////
function habilitaOrigen(combo,pago,dispersion,secundaria){
    if($(combo).val()!== "-1"){
        if(secundaria !== 0){
            $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("visibility","visible");
            $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("display","");
            $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").prop("selectedIndex",0);
            $("#datosbanco"+pago+dispersion+secundaria).html("");
            $("#datoscuenta"+pago+dispersion+secundaria).html("");
            $("#MonDspPag_"+pago+"_"+dispersion+"_"+secundaria+"_").val("0.00");
            $("#IdDesPag_"+pago+"_"+dispersion+"_"+secundaria+"_").prop("selectedIndex",0);
        }else{
            $("#IdOrgPag_"+pago+"_"+dispersion+"_0_").css("visibility","visible");
            $("#IdOrgPag_"+pago+"_"+dispersion+"_0_").css("display","");
            $("#IdOrgPag_"+pago+"_"+dispersion+"_0_").prop("selectedIndex",0);
            $("#datosbanco"+pago+dispersion).html("");
            $("#datoscuenta"+pago+dispersion).html("");
            $("#MonDspPag_"+pago+"_"+dispersion+"_0_").val("0.00");
            $("#IdDesPag_"+pago+"_"+dispersion+"_0_").prop("selectedIndex",0);
        }
    }else{
        $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("visibility","hidden");
        $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").css("display","none");
        $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_").prop("selectedIndex",0);
        if(secundaria === 0){
            $("#datosbanco"+pago+dispersion).html("");
            $("#datoscuenta"+pago+dispersion).html("");
        }else{
            $("#datosbanco"+pago+dispersion+secundaria).html("");
            $("#datoscuenta"+pago+dispersion+secundaria).html("");
        }
    }
    if(secundaria === 0){
        $("#agrega"+pago+dispersion).css({'visibility': 'hidden', 'display': 'none'});
        $("#divDispersion"+pago+dispersion).find(".dispSec").css({'visibility': 'hidden', 'display': 'none'}).next(".dispSec").remove();//se eliminan dispersiones secundarias 
        $("#divDispersion"+pago+dispersion).find("#numeroDeDispersionesSec"+pago+dispersion).val("0");
        $("#MonDspPag_"+pago+"_"+dispersion+"_1_").val("0.00").attr("disabled","disabled");
        $("#IdEntPoE_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).attr("disabled","disabled");
        $("#IdOrgPag_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).css({'visibility': 'hidden', 'display': 'none'}).attr("disabled","disabled");
        $("#datosbanco"+pago+dispersion+"1").html("");
        $("#datoscuenta"+pago+dispersion+"1").html("");
        $("#MonDspPag_"+pago+"_"+dispersion+"_1_").val("0.00").attr("disabled","disabled");
        $("#FecMovDspPag_"+pago+"_"+dispersion+"_1_").val("").attr("disabled","disabled");
        $("#IdDesPag_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).attr("disabled","disabled");
    }
}
/////////////////////////////////////////////////////////////////////////////////////
function agregaOrigen(valor,pago,dispersion,secundaria){
    if(valor.value === 'otros'){	
        $("#msj").html('').removeClass("ui-state-error ui-corner-all");
        $( "#dialog").dialog( "open" );
    }
    if($("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_ :selected").text() === "DEPOSITO" || $("#IdOrgPag_"+pago+"_"+dispersion+"_"+secundaria+"_ :selected").text() === "TRANSFERENCIA"){
        if(secundaria === 0){
            consultaBanco($("#IdEntPoE_"+pago+"_"+dispersion+"_"+secundaria+"_").val(),pago,dispersion,-1);
        }else{
            consultaBancoSec($("#IdEntPoE_"+pago+"_"+dispersion+"_"+secundaria+"_").val(),pago,dispersion,secundaria,-1);
        }
    }else{
        if(secundaria === 0){
            $("#datosbanco"+pago+dispersion).html("");
            $("#datoscuenta"+pago+dispersion).html("<input type='hidden' name='IdEntCue_"+pago+"_0[]' value='-1'/>");
        }else{
            $("#datosbanco"+pago+dispersion+secundaria).html("");
            $("#datoscuenta"+pago+dispersion+secundaria).html("<input type='hidden' name='IdEntCue_"+pago+"_"+dispersion+"[]' value='-1'/>");
        }
    }
}

/////////////////////////////////////////////////////////////////////////////////////
function agregaDestino(valor,padre,hijo,hijosec){
    if(valor === 'otros'){	
        $("#msj2").html('').removeClass("ui-state-error ui-corner-all");
        $("#dialog2").dialog( "open" );
        $("#pagoPadre").val(padre);
        $("#dispersionPago").val(hijo);
    }
    if(valor === '2' || valor === '3'){
        habilitaDispersionSecundaria(padre,hijo,1);	
    }
    if(valor !== '2' && valor !== '3'){
        $("#agrega"+padre+hijo).css({'visibility': 'hidden', 'display': 'none'});
        $("#divDispersion"+padre+hijo).find(".dispSec").css({'visibility': 'hidden', 'display': 'none'}).next(".dispSec").remove();//se eliminan dispersiones secundarias 
        $("#divDispersion"+padre+hijo).find("#numeroDeDispersionesSec"+padre+hijo).val("0");
        $("#MonDspPag_"+padre+"_"+hijo+"_1_").val("0.00").attr("disabled","disabled");
        $("#IdEntPoE_"+padre+"_"+hijo+"_1_").prop("selectedIndex",0).attr("disabled","disabled");
        $("#IdOrgPag_"+padre+"_"+hijo+"_1_").prop("selectedIndex",0).css({'visibility': 'hidden', 'display': 'none'}).attr("disabled","disabled");
        $("#datosbanco"+padre+hijo+"1").html("");
        $("#datoscuenta"+padre+hijo+"1").html("");
        $("#MonDspPag_"+padre+"_"+hijo+"_1_").val("0.00").attr("disabled","disabled");
        $("#FecMovDspPag_"+padre+"_"+hijo+"_1_").val("").attr("disabled","disabled");
        $("#IdDesPag_"+padre+"_"+hijo+"_1_").prop("selectedIndex",0).attr("disabled","disabled");
        validaTotal(padre);
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

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: agregarCampo()
//Funcion del módulo: Agrega una nueva fila con 'inputs' para rellenar y se les asigna dinámicamente el id y el name consecutivo 
//					  a los inputs que arrojo la consulta						
//Fecha:10/05/03
//*************************************
function agregaDispersion(padre){
    var indicePago = parseInt($("#numerodePago"+padre).val());
    var indiceDispersion = parseInt($("#numerodePago"+padre).prev("div").find("div").last().find(".controlDispersion").val());
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

    $("#indice"+padre+"1").attr("id","indice"+padre+(indiceDispersion+1));

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
    $("#indice"+padre+(indiceDispersion+1)).attr("id","indice"+padre+"1");
    $("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdEntPoE_"+indicePago+"_1_0_");
    $("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"FecMovDspPag_"+indicePago+"_1_0_");
    $("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdOrgPag_"+indicePago+"_1_0_");
    $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"MonDspPag_"+indicePago+"_1_0_");
    $("#datosbanco"+indicePago+(indiceDispersion+1)).attr('id',"datosbanco"+indicePago+1);
    $("#datoscuenta"+indicePago+(indiceDispersion+1)).attr('id',"datoscuenta"+indicePago+1);
    $("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr('id',"IdDesPag_"+indicePago+"_1_0_");
    $("#numeroDeDispersion"+(indiceDispersion+1)).attr('id',"numeroDeDispersion"+1);
    $("#numeroDeDispersionesSec"+indicePago+(indiceDispersion+1)).attr('id',"numeroDeDispersionesSec"+indicePago+1);
    $("#agrega"+indicePago+(indiceDispersion+1)).attr('id',"agrega"+indicePago+1);
    ////////////////////////////////////////////////////////////////////////////////////
    if((indiceDispersion+1)>2){
        if(!$("#elimina"+indicePago+indiceDispersion).button()){
            $("#elimina"+indicePago+indiceDispersion).html("");
            $("#elimina"+indicePago+indiceDispersion).removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only ui-state-hover").removeAttr("role aria-disabled class");
            $("#elimina"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-trash"},text: false});
            $("#agrega"+indicePago+indiceDispersion).html("");
            $("#agrega"+indicePago+indiceDispersion).removeClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only");
            $("#agrega"+indicePago+indiceDispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});
        }  
    }
    newElem.find(".dispSec").attr("id","dispSec"+padre+(indiceDispersion+1)+1).css({'visibility': 'hidden', 'display': 'none'}).next(".dispSec").remove();//se eliminan dispersiones secundarias 
    newElem.find("#numeroDeDispersionesSec"+indicePago+(indiceDispersion+1)).val("0");
    newElem.find("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").val("").next().next().removeAttr("checked").next().val("1");
    //alert(newElem.find("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").attr("title"));
    newElem.find("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").val("");
    $("#numerodePago"+padre).prev("div").find("div").last().after(newElem);// se inserta!!!!

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
    $("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").prop("selectedIndex",0);
    $("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_0_").prop("selectedIndex",0);
    $("#IdDesPag_"+indicePago+"_"+(indiceDispersion+1)+"_0_").prop("selectedIndex",0);

    $("#dispSec"+indicePago+(indiceDispersion+1)+1).css("visibility","hidden");
    $("#dispSec"+indicePago+(indiceDispersion+1)+1).css("display","none");
    $("#FecMovDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").removeClass("hasDatepicker");
    $( "input[type=fecha]").datepicker({ dateFormat: 'dd-mm-yy' });
    $("#IdEntPoE_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('onchange',"habilitaOrigen(this,"+indicePago+","+(indiceDispersion+1)+",1)");
    $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('onblur',"validaTotal("+indicePago+")");
    $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").css("background-color","#FFF");
    $("#MonDspPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").val("0.00").next().removeAttr("checked").next().val("1");
    $("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").css({'visibility': 'hidden', 'display': 'none'});
    $("#IdOrgPag_"+indicePago+"_"+(indiceDispersion+1)+"_1_").attr('onchange',"agregaOrigen(this,"+indicePago+","+(indiceDispersion+1)+",1)");
    $("#datosbanco"+indicePago+(indiceDispersion+1)+1).html("");
    $("#datoscuenta"+indicePago+(indiceDispersion+1)+1).html("");

    $("#numerodePago"+padre).prev("div").find("div").last().find(".controlDispersion").val(indiceDispersion+1);
    $("#divDispersion"+padre+(indiceDispersion+1)).find("table").find("tr:first").find("td:first").html(padre+"."+(indiceDispersion+1));
    $("#divDispersion"+padre+(indiceDispersion+1)).find("table").find("tr:last").find("td:first").html(padre+"."+(indiceDispersion+1)+".1");
    $("#numerodePago"+padre).prev("div").find("div").last().find("table").find("tr:first").find("td:last").html("<li id='agrega"+indicePago+(indiceDispersion+1)+"' style='visibility:hidden; display:none;' onclick='agregaDispersionSecundaria("+indicePago+','+(indiceDispersion+1)+");'></li><li id='elimina"+indicePago+(indiceDispersion+1)+"' onclick=eliminaDispersion("+indicePago+","+(indiceDispersion+1)+");></li>");
    $("#elimina"+padre+(indiceDispersion+1)).button({icons: {primary: "ui-icon-trash"},text: false});
    $("#agrega"+padre+"1").button({icons: {primary: "ui-icon-plusthick"},text: false});
    $("#indice"+padre+(indiceDispersion+1)).val((indiceDispersion+1));
    reOrganizaDispersion(indicePago,1);
}

function eliminaDispersion(pago,dispersion){
    if(confirm("¿Seguro de eliminar la dispersion del pago?")){
	$("#divDispersion"+pago+dispersion).remove();
	var indicePago = parseInt($("#numerodePago"+pago).val());
	var indiceDispersion = parseInt($("#numerodePago"+pago).prev("div").find("div").last().find(".controlDispersion").val());
	var html = "";
	if($("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_0_ option:selected").text() === "TRANSFERIRLOS A UNA CUENTA" || $("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_0_").text() === "REGRESAR EFECTIVO"){
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
}

///////////////////////////////////////////////////////////
function habilitaDispersionSecundaria(pago,dispersion,hijo){
    $("#dispSec"+pago+dispersion+hijo).css({"visibility":"visible","display":""});
    $("#agrega"+pago+dispersion).css({"visibility":"visible","display":""});
    if(!$("#agrega"+pago+dispersion).hasClass("ui-button")){
        $("#agrega"+pago+dispersion).button({icons: {primary: "ui-icon-plusthick"},text: false});
    }
    $("#numeroDeDispersionesSec"+pago+dispersion).val(parseInt($("#numeroDeDispersionesSec"+pago+dispersion).val())+1);
    $("#MonDspPag_"+pago+"_"+dispersion+"_1_").val("0.00").removeAttr("disabled");
    $("#FecMovDspPag_"+pago+"_"+dispersion+"_1_").val("").removeAttr("disabled");
    $("#IdOrgPag_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).removeAttr("disabled");
    $("#IdEntPoE_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).removeAttr("disabled");
    $("#IdDesPag_"+pago+"_"+dispersion+"_1_").prop("selectedIndex",0).removeAttr("disabled");
   //$("#")
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

    $("#MonDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").val("0.00").next().removeAttr("checked").next().val("1");
    $("#dispSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)).css("background-color","#AED5B2");
    $("#FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").removeClass("hasDatepicker");
    $("input[type=fecha]").datepicker({ dateFormat: 'dd-mm-yy' });
    $("#IdEntPoE_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").prop("selectedIndex",0);
    $("#IdEntPoE_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('onchange',"habilitaOrigen(this,"+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");");
    $("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").prop("selectedIndex",0);
    $("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('onchange',"agregaOrigen(this,"+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");");
    $("#IdDesPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").prop("selectedIndex",0);
    $("#datosbanco"+indicePago+indiceDispersion+(indiceDispersionSec+1)).html("");
    $("#cve_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").attr('value',indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_");
    $("#datoscuenta"+indicePago+indiceDispersion+(indiceDispersionSec+1)).html("");
    $("#IdOrgPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").css({'visibility': 'hidden', 'display': 'none'});
    $("#FecMovDspPag_"+indicePago+"_"+indiceDispersion+"_"+(indiceDispersionSec+1)+"_").val("");

    if((indiceDispersionSec+1)>1){
        $("#numerodePago"+indicePago).prev("div").find("#divDispersion"+indicePago+indiceDispersion).find("table").find("tr:last").find("td:last").html("<li id='eliminaSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)+"' onclick=eliminaDispersionSec("+indicePago+","+indiceDispersion+","+(indiceDispersionSec+1)+");></li>");
        $("#eliminaSec"+indicePago+indiceDispersion+(indiceDispersionSec+1)).button({icons: {primary: "ui-icon-trash"},text: false});	
    }
    $("#numeroDeDispersionesSec"+pago+indiceDispersion).val(indiceDispersionSec+1);
    reOrganizaDispersion(indicePago,1);
}

function eliminaDispersionSec(pago,dispersion,secundaria){
    if(confirm("¿Seguro de eliminar la dispersion secundaria?")){
        $("#dispSec"+pago+dispersion+secundaria).remove();
        reOrganizaDispersion(pago,1);
        validaTotal(pago);
    }
}

banderaTotal = false;//controla los mensajes de error
function validaTotal(pago){
    suma=0;
    montoTotal = parseFloat($("#montoTotal"+pago).val());
    banderaSecundarias = true;
    banderaTotal = false;
    $("#controlDispersion"+pago).find(".montoDispersion").each(function(index, element) {
        if(isNaN($(this).val()) || $(this).val() === "")
            $(this).val(0);
        $(this).val(parseFloat($(this).val()).toFixed(2));
        suma = parseFloat(suma) + parseFloat($(this).val());
        if(!validaTotalDispersion(pago,(index+1))){
            banderaSecundarias = false;
        }
    });
    if(suma > montoTotal){
        $("#error"+pago).addClass("ui-state-error ui-corner-all");
        $("#error"+pago).html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span>Se superó el monto del pago!");
        $("#controlDispersion"+pago).find(".montoDispersion").each(function(index3){
            $(this).css("background-color","#FF6C70");
        });
        return false;	
    }
    else{
        $("#error"+pago).removeClass("ui-state-error ui-corner-all");
        $("#error"+pago).html("");
        $("#controlDispersion"+pago).find(".montoDispersion").each(function(index3){
            $(this).css("background-color","#FFF");
        });
        if(banderaSecundarias){
            return true;
        }else{
            return false;
        }
    }				
}
  
function validaTotalDispersion(pago,dispersion){
    montoTotalSec = parseFloat($("#MonDspPag_"+pago+"_"+dispersion+"_0_").val());
    sumaSec = 0.00;
    $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index1){
        if(isNaN($(this).val()) || $(this).val() === "")
            $(this).val(0);
        $(this).val(parseFloat($(this).val()).toFixed(2));
        sumaSec += parseFloat($(this).val());
    });
    if(sumaSec > montoTotalSec){
        $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index2){
            $(this).css("background-color","#FEE9EC");
        });
        if(!banderaTotal){
            $("#errorSec"+pago).addClass("ui-state-error ui-corner-all");
            $("#errorSec"+pago).html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span> Se superó el monto de la dispersión");
        }
        banderaTotal = true;
	return false;
    }else{
        if(!banderaTotal){
            $("#errorSec"+pago).removeClass("ui-state-error ui-corner-all");
            $("#errorSec"+pago).html(""); 
        }
        $("#divDispersion"+pago+dispersion).find(".montoSecundaria").each(function(index3){
            $(this).css("background-color","#FFF");
        });
        $("#MonDspPag_"+pago+"_"+dispersion+"_0_").next("input").val((montoTotalSec-sumaSec).toFixed(2));
        return true;
    }
}

function guardarDispersiones(pago,idpago){
    url="../ingresos/registraDispersion.php";
    nombreForm = "#form"+pago;
    //alert(validaCamposDispersion(pago));
    if(validaCamposDispersion(pago) && validaTotal(pago) ){
        $.post(url,$(nombreForm).serialize(),function(data){
            $("#mensajePopUp").html("<p><strong>"+data+"</strong></p>").addClass("ui-widget ui-state-highlight ui-corner-all").css({"width":"250px","position":"absolute","margin-left":"500px","margin-top":"-150px","text-align": "center"}).show( "puff", 1000 ).delay(2000).hide( "puff", 1000 );
        });
    }
}

function checa(elem){
    if($(elem).next("input").val()==="1"){
        $(elem).next("input").val("0");
    }else{
        $(elem).next("input").val("1");
    }
}
    
function validaCamposDispersion(pago){
    alerta = true;
    $("#controlDispersion"+pago).find("select,input").each(function(index){
        if(($(this).prop("selectedIndex") === 0 || $.trim($(this).val()) === "") && !$(this).attr("disabled")){
            $(this).css({'background-color':'#FFB7B7'}).focus();
            alerta = false;
            return false;
        }else{
            $(this).css({'background-color':'#FFF'});
        }
    });
    return alerta;
}
