//******************************************************************//
//																	//
// Nombre: Juan Carlos Piña Moreno									//
// Nombre del módulo: Funciones para el manejo de proyectos			//
// Función del módulo: Funciones requeridas para la presentación del//
//					   formulario que agregará un nuevo proyecto	//
//					   												//
// Fecha: 15/05/2013												//
//																	//
//******************************************************************//

/*
* Se crean los demonios para validar y se cargan los elementos dinámicos
* además de crear varibles globales
*/
var contador = 0;
var contadorPagos = 0;
var suma = 0;
var total = 0;
$(document).ready(function(){
	$("#formAddPry,#formSetPry").submit(function(){
		  if(!validaCampos()){
			  return false;
		  }else{
			$("#error").html("");
			$("#error").removeClass("ui-state-error ui-corner-all");
			if(valida("totalP")){
				$("input").removeAttr('disabled');
				return true;
			}else{
				return false;
			}
		  }
	});
	$("#ltxt_fecIni").change(function(e) {
        $("input[type=fechaEtr],#ltxt_fecFin").datepicker("option", "minDate", new Date($("#ltxt_fecIni").datepicker("getDate")));
    });
	$("#ltxt_fecFin").change(function(e) {
        for(var i = 0;i <= contador;i++){
			$("#ltxt_fecEnt"+i).datepicker("option", "maxDate", new Date($("#ltxt_fecFin").datepicker("getDate")))
		}
    });
});
$(document).ready(cargarClientes(0));

function validaCampos(){
    var bandera = true;
    $("#formSetPry,#formAddPry").find('input,select').each(function() {
    if($(this).val() ==""){
        $("#proyecto").accordion("option","active",$(this).parents("div").prev("h3").index("h3"));
        $(this).focus();
        bandera = false;
        return false;
    }
    if($("#error").html() !== ""){
        $("#proyecto").accordion("option","active",$("#lint_pjePag0").parent().index());
        $("#lint_pjePag0").focus();
        bandera = false;
        return false;
    }
    });
    return bandera;
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: cargarClientes
* Función del módulo: Carga los clientes contenidos en la base de datos en un select y lo coloca dentro del documento en el lugar correspondiente
* Fecha: 15/05/2013
*/
function cargarClientes(IdEntCli){
	if(IdEntCli != 0){
		url = "../proyecto/clientes.php?IdEntCli="+IdEntCli;
	}else{ 
		url = "../proyecto/clientes.php";
	}
	$.post(url,{},function(responseText){
		$("#listaClientes").html(responseText);
	});
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: agregaFase
* Función del módulo: Crea los camppos necesarios para ingresar una nueva fase del proyecto
* Fecha: 15/05/2013
*/
var banderaFase = false;
function agregaFase(actual){
	if(!banderaFase){
		contador = actual;
		banderaFase = true;
	}
	if(confirm("¿Agregar nueva fase?")){
		var index = contador;
		index++;
		var newElem = "<tr class='entrada"+(index%2)+"' id='fase"+index+"'><td>"+(index+1)+"</td><td><input type='text' id='ltxt_ctoFas"+index+"' name='ltxt_ctoFas"+index+"' size='60'/></td><td><input type='fechaEtr' id='ltxt_fecEnt"+index+"' name='ltxt_fecEnt"+index+"'/></td><td id='boton"+index+"'><a href='#' id='quitaFase' style='height: 20px;'></a></td></tr>";
		if(index > 1){
			$("#boton"+contador).html("");
		}
		$('#fase' + contador).after(newElem);//se inserta el nuevo renglon
		//se vuelve a agregar estilo jquery ui
		$( "input[type=fechaEtr],input[type=fechaPag]").datepicker();
	 	$( "input[type=fechaEtr],input[type=fechaPag]").datepicker('option', { dateFormat: 'dd-mm-yy' }); 
		$("td,input").addClass("ui-corner-all");
		$("#ltxt_fecEnt"+index).datepicker("option", "minDate", new Date($("#ltxt_fecEnt"+contador).datepicker("getDate")));
		$("#ltxt_fecEnt"+index).datepicker("option", "maxDate", new Date($("#ltxt_fecFin").datepicker("getDate")));
		$("input[type=fechaEtr]").change(function(e) {
			for(var i = 1;i <= contador;i++){
				$("#ltxt_fecEnt"+i).datepicker("option", "minDate", new Date($("#ltxt_fecEnt"+(i-1)).datepicker("getDate")))
			}
		});
		$("#quitaFase").button({icons: {primary: "ui-icon-trash"}});
		$("#quitaFase").on("click",function(click,ui){quitarFase();});
		contador++;
	}else{return;}
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: agregaPago
* Función del módulo: Coloca los campos necesarios para poder ingresar un nuevo pago
* Fecha: 15/05/2013
*/
var banderaPago = false;
function agregaPago(actual){
	if(!banderaPago){
		contadorPagos = actual;
		banderaPago = true;
	}
	if(confirm("¿Agregar nuevo pago?")){
		var index = contadorPagos;
		index++;
		var newElem ="<tr class='entrada"+(index%2)+"' id='pago"+index+"'><td>"+(index+1)+"</td><td><input type='text' name='ltxt_ctoPag"+index+"' id='ltxt_ctoPag"+index+"' size='50' /></td><td><input type='text' name='lint_pjePag"+index+"' id='lint_pjePag"+index+"' size='8' onblur='valida("+'"totalP"'+")'/></td><td>$<input type='text' name='lint_subPag"+index+"' id='lint_subPag"+index+"' size='10' disabled='disabled'/></td><td>$<input type='text' name='lint_ivaPag"+index+"' id='lint_ivaPag"+index+"' size='10' disabled='disabled'/></td><td>$<input type='text' name='lint_totPag"+index+"' id='lint_totPag"+index+"' size='10' onblur='valida("+'"totalP"'+")'/></td><td><input type='fechaPag' name='ltxt_fecPag"+index+"' id='ltxt_fecPag"+index+"' /></td><td id='botonP"+index+"'><a href='#' id='quitaPago' style='height: 20px;'></a></td></tr>";
		if(index > 1){
			$("#botonP"+contadorPagos).html("");
		}
		$('#pago' + contadorPagos).after(newElem);//se inserta el nuevo renglon
		//se vuelve a agregar estilo jquery ui
	 	$( "input[type=fechaEtr],input[type=fechaPag]").datepicker(); 
		$( "input[type=fechaEtr],input[type=fechaPag]").datepicker('option',{dateFormat:'dd-mm-yy'});
		$("input[type=text],input[type=fechaEtr],input[type=fechaPag]").addClass("ui-corner-all");
		$("td").addClass("ui-corner-all");
		$("#quitaPago").button({icons: {primary: "ui-icon-trash"}});
		$("#quitaPago").on("click",function(click,ui){quitarPago(0); valida("totalP",0);});
		contadorPagos++;
	}else{return;}
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: valida
* Función del módulo: Valida el contenido de los campos creados dinámicamente, recibe como parámetro el origen de donde se solicitó la función
* Fecha: 15/05/2013
*/
function valida(origen,actual){
	if(!banderaPago){
		contadorPagos = actual;
		banderaPago = true;
	}
	var expresion = new RegExp("^[0-9]*.?[0-9]+$");
	if(expresion.test($("#lint_ctoPry").val())){//aplica expresion regular
            total = parseFloat($("#lint_ctoPry").val());
	}else{
            total = 0;
            $("#lint_ctoPry").val("0");
	}
	if($("#lbool_iva").attr("checked")){
            iva = 0.16;	
	}else{
            iva = 0;
        }
	if(origen == "totalP"){
            suma = 0;
            for(var i = 0;i<=contadorPagos;i++){
                    pje = "lint_pjePag"+i;
                    totP = "lint_totPag"+i;
                    if(!expresion.test($("#"+totP).val())){
                            if(expresion.test($("#"+pje).val())){                               
                                subTotalPago = (($("#lint_pjePag"+i).val())*total)/100;
                                ivaPago = subTotalPago * iva;
                                totalPago = subTotalPago + ivaPago;
                                $("#lint_subPag"+i).val(subTotalPago.toFixed(2));
                                $("#lint_ivaPag"+i).val(ivaPago.toFixed(2));
                                $("#lint_totPag"+i).val(totalPago.toFixed(2));
                                suma = suma + parseFloat(totalPago);
                            }else{
                                $("#"+totP).val("");
                                $("#lint_subPag"+i).val("");
                                $("#lint_ivaPag"+i).val("");
                                $("#lint_pjePag"+i).val("");
                            }
                    }else{
                            //obtiene porcentaje
                            pagoSinIVA = (parseFloat($("#"+totP).val())*total)/((total*iva)+total);
                            $("#"+pje).val((pagoSinIVA*100/total).toFixed(5));
                            subTotalPago = (($("#lint_pjePag"+i).val())*total)/100;
                            ivaPago = subTotalPago * iva;
                            $("#lint_subPag"+i).val(subTotalPago.toFixed(2));
                            $("#lint_ivaPag"+i).val(ivaPago.toFixed(2));
                            suma = suma + parseFloat($("#"+totP).val());
                    }
            }
	}
	if(suma.toFixed(2) > ((total*iva)+total)){
		$("#error").addClass("ui-state-error ui-corner-all");
		$("#error").html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Error:</b> Se superó el 100%");
		excedente = suma.toFixed(2)-((total*iva)+total);
		excedenteSinIVA = (excedente*total)/((total*iva)+total);
		pjeExcedente = (excedenteSinIVA*100/total).toFixed(5);
		$("#info").html("Se superó el porcentaje en un <b>"+pjeExcedente+"%</b> <br/>O en un monto total de <b>$"+excedente.toFixed(2)+"</b>");
		return false;
	}else if(suma.toFixed(2) < ((total*iva)+total)){
			$("#error").addClass("ui-state-error ui-corner-all");
			$("#error").html("<span class='ui-icon ui-icon-alert' style='float: left; margin-right: .3em;'></span><b>Error:</b> Aún no se alcanza el 100%");
			faltante = ((total*iva)+total)- suma.toFixed(2);
			faltanteSinIVA = (faltante*total)/((total*iva)+total);
			pjeFaltante = (faltanteSinIVA*100/total).toFixed(5);
			$("#info").html("Falta un porcentaje de <b>"+pjeFaltante+"%</b> <br/>O un monto total de <b>$"+faltante.toFixed(2)+"</b>");
		return false;
		}else{
			$("#error").removeClass("ui-state-error ui-corner-all");
			$("#error").html("");
			$("#info").html("");
			return true;
	}
}

// Se cargan estilos de jquery ui
$(function() {
	$(document).tooltip();
	$( "input[type=fechaEtr],input[type=fechaPag],input[type=fecha]").datepicker();
    $( "input[type=fechaEtr],input[type=fechaPag],input[type=fecha]").datepicker('option',{dateFormat:'dd-mm-yy'});
	$( "input[type=submit],input[type=button]").button();
	$( "#proyecto").accordion({collapsible: true,heightStyle: "content"});
	$("input[type=text],input[type=fechaEtr],input[type=fechaPag],input[type=fecha],textarea,td").addClass("ui-corner-all");
  });

function quitarFase(actual){
	if(!banderaFase){
		contador = actual;
		banderaFase = true;
	}
	if(confirm("¿Seguro de eliminar la fase o entregable?")){
		var url = "../proyecto/eliminaFase.php";
		$.post(url,{IdEntEtr:$("#IdEntEtr"+contador).val()});
		if(contador>1){
			$("#boton"+(contador-1)).html("<a href='#' id='quitaFase' style='height: 20px;'></a>");
			$("#quitaFase").button({icons: {primary: "ui-icon-trash"}});
			$("#quitaFase").on("click",function(click,ui){quitarFase(0);});
		}
		$("#fase"+contador).remove();
		contador--;
		if($("#totFases").val() > contador){
			$("#totFases").val($("#totFases").val()-1);
		}
	}
}

function quitarPago(actual){
	if(!banderaPago){
		contadorPagos = actual;
		banderaPago = true;
	}
	if(confirm("Si elimina el pago se perderán las dispersiones realizadas inmediatamente")){
		var url = "../proyecto/eliminaPagoDisp.php";
		$.post(url,{IdEntPag:$("#IdEntPag"+contadorPagos).val()});
		if(contadorPagos>1 && !$("#ltxt_ctoPag"+(contadorPagos-1)).attr("disabled")){
			$("#botonP"+(contadorPagos-1)).html("<a href='#' id='quitaPago' style='height: 20px;'></a>");
			$("#quitaPago").button({icons: {primary: "ui-icon-trash"}});
			$("#quitaPago").on("click",function(click,ui){quitarPago(actual);});
		}
		$("#pago"+contadorPagos).remove();
		contadorPagos--;
		if($("#totPagos").val() > contadorPagos){
			$("#totPagos").val($("#totPagos").val()-1);
		}
	}else{
		return;
	}
}

function buscaProy(IdEntPry){
	var url="../proyecto/buscaProy.php";
	$.post(url,{IdEntPry:IdEntPry},function(responseText){
		$("#contenido").html(responseText);
	});
}

function eliminarProyecto(){
    if(confirm("¿Seguro de eliminar el proyecto?")){
            $("#formElimina").submit();
    }
}

function enviaModificar(IdEntPry){
    var url="../vista/modificaProy.php";
    $.get(url,{id:IdEntPry},function(responseText){
        $("#workbench").html(responseText);
    });
}

function consultarDispersion(pago){
    var IdEntPry=($("#IdEntPry").val());
    $.post("../ingresos/consultaDispersion.php",{IdEntPry:IdEntPry,pago:pago},function(data){
            $("#workbench").html(data);
            $("input[type=button],input[type=submit]").button();
            $("input[type=text],input[type=password],select,td,h2").addClass("ui-corner-all");
            $("input[type=fecha]").datepicker({dateFormat: 'dd-mm-yy'});
            $("#dialog , #dialog2, #dialogregistro,#dialogmod,#consultarUsuarios,#registrarUsuarios,#modificarUsuarios").dialog({
                width: 350,
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
    
}

function programarDispersion(pago){
    if (confirm("¿Deseas programar dispersión?")) {
        var IdEntPry=($("#IdEntPry").val());
        var renglones=2;
        var IdEntPag=[];
        IdEntPag[1]=pago;
        $.post("../ingresos/registroDispersion.php",{IdEntPry:IdEntPry,pago:IdEntPag,renglones:renglones},function(data){
            $("#workbench").html(data);
            $("input[type=button],input[type=submit]").button();
            $("input[type=text],input[type=password],select,td,h2").addClass("ui-corner-all");
            $("input[type=fecha]").datepicker({dateFormat: 'dd-mm-yy'});
            $("#dialog , #dialog2, #dialogregistro,#dialogmod,#consultarUsuarios,#registrarUsuarios,#modificarUsuarios").dialog({
                width: 350,
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
    }
}
