//******************************************************************//
//																	//
// Nombre: Juan Carlos Piña Moreno									//
// Nombre del módulo: Funciones para el manejo de personas/empresas	//
// Función del módulo: Funciones requeridas para la presentación del//
//					   formulario que agregará una nueva persona	//
//					   o empresa									//
// Fecha: 15/05/2013												//
//																	//
//******************************************************************//
/*
* Se crean los demonios para validar y se cargan los elementos dinámicos
*
*/
var contador = 0;
var bandera = true;
//$(document).ready(cargarPerfiles());
//$(document).ready(cargarBancos());
$(document).ready(function(){$("#formAddPoE").submit(function(){if(valida()){return true;}else{return false;}});});

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: cargarPerfiles
* Función del módulo: Carga los perfiles contenidos en la base de datos en un select y lo coloca dentro del documento en el lugar correspondiente
* Fecha: 08/05/2013
*/
var consulta = false;
function cargarPerfiles(IdEntCli){
	if(IdEntCli != ""){
		var url = "../participante/perfiles.php?id="+IdEntCli;
		consulta = true;
	}else{
		var url = "../participante/perfiles.php";
		consulta = false;
	}
	$.post(url,{},function(responseText){
		$("#perfil").html(responseText);
		if(IdEntCli != "")
			mostrarCampos();
	});
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: cargarBancos
* Función del módulo: Carga los bancos contenidos en la base de datos en un select y lo coloca dentro del documento en el lugar correspondiente
* Fecha: 08/05/2013
*/
function cargarBancos(IdEntBan,index){
	if(IdEntBan != ""){
		var url = "../participante/bancos.php?id="+IdEntBan+"&index="+index;
	}else{
		var url = "../participante/bancos.php";
		index = 0;
	}
	$.post(url,{},function(responseText){
		$("#banco"+index).html(responseText);
		
	});
}

/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: agregarCuenta
* Función del módulo: Añade los campos necesarios al formulario para poder ingresar más de una cuenta
* Fecha: 08/05/2013
*/
var banderaCuentas = false;
function agregarCuenta(actual){
	if(!banderaCuentas){
		contador = actual-1;
		banderaCuentas = true;
	}
	var index = contador;
	index++;
	//se cambian los valores originales
	$("#IdEntCue"+contador).attr({'name':"IdEntCue"+index});
	$("#IdEntCue"+contador).attr('id',"IdEntCue"+index);
	$("#lint_banPoE"+contador).attr({'name':"lint_banPoE"+index});
	$("#lint_banPoE"+contador).attr('id',"lint_banPoE"+index);
	$("#lint_sucPoE"+contador).attr('name',"lint_sucPoE"+index);
	$("#lint_sucPoE"+contador).attr('id',"lint_sucPoE"+index);
	$("#lint_ctaPoE"+contador).attr('name',"lint_ctaPoE"+index);
	$("#lint_ctaPoE"+contador).attr('id',"lint_ctaPoE"+index);
	$("#ltxt_cbePoE"+contador).attr('name',"ltxt_cbePoE"+index);
	$("#ltxt_cbePoE"+contador).attr('id',"ltxt_cbePoE"+index);
	$("#termina"+contador).attr('id',"termina"+index);
	var newElem = $('#cuentas' + contador).clone().attr('id', 'cuentas' + index);//se clona el renglon
	$("#termina"+index).attr('id',"termina"+contador);
	$("#lint_banPoE"+index).attr('name',"lint_banPoE"+contador);//se regresan valores originales
	$("#lint_banPoE"+index).attr('id',"lint_banPoE"+contador);
	$("#IdEntCue"+index).attr({'name':"IdEntCue"+contador});
	$("#IdEntCue"+index).attr('id',"IdEntCue"+contador);
	$("#lint_sucPoE"+index).attr('name',"lint_sucPoE"+contador);
	$("#lint_sucPoE"+index).attr('id',"lint_sucPoE"+contador);
	$("#lint_ctaPoE"+index).attr('name',"lint_ctaPoE"+contador);
	$("#lint_ctaPoE"+index).attr('id',"lint_ctaPoE"+contador);
	$("#ltxt_cbePoE"+index).attr('name',"ltxt_cbePoE"+contador);
	$("#ltxt_cbePoE"+index).attr('id',"ltxt_cbePoE"+contador);
	$("#validacionSuc"+index).attr('name',"validacionSuc"+contador);
	$("#validacionSuc"+index).attr('id',"validacionSuc"+contador);
	$("#cuentas"+contador).after(newElem);//se inserta el nuevo renglon
	$("#cuentas"+index).removeClass("entrada"+(contador%2));
	$("#cuentas"+index).addClass("entrada"+(index%2));	
	$("#cuentas"+index).find("input").val("");
	if(index>1){
		$("#termina"+contador).html("");
	}
	$("#termina"+index).html("<a href='#' id='quitaCuenta'>Eliminar</a>");
	$("input").addClass("ui-corner-all");
	$("#quitaCuenta").button({icons: {primary: "ui-icon-trash"}});
	$("#quitaCuenta").on("click",function(click,ui){quitarCuenta(0);});
	contador++;
}

jQuery.fn.telefono=function(){
	if(isNaN($(this).val()) || $(this).val().length < 7 || $(this).val().length > 12){
		return false;
	}
	return true;
}

jQuery.fn.ext=function(){
	if(isNaN($(this).val()) || $(this).length < 1 || $(this).length > 10){
		return false;
	}
	return true;
}
/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: valida
* Función del módulo: Valida los datos ingresados en la sección de cuentas bancarias para evitar errores en la inserción.
* Fecha: 08/05/2013
*/
function valida(){
	$("#formAddPoE").find('input[type=text],select').each(function() {
		if($(this).val()=="" && !$(this).hasClass("nulo") && !$(this).parents("td").hasClass("empresa")){
			$("#participante").accordion("option","active",$(this).parents("div").prev("h3").index("h3"));
			$(this).focus();
			bandera = false;
			return false;
		}
		bandera = true;
	});
	if(!bandera)
		return false;
	if(!$("#ltxt_telPoE").parents("td").hasClass("empresa") && !$("#ltxt_telPoE").telefono()){
		$("#participante").accordion("option","active",$("#ltxt_telPoE").parents("div").prev("h3").index("h3"));
		alert("Número telefónico inválido");
		$("#ltxt_telPoE").focus();
		return false;
	}
	if(!$("#ltxt_extPoE").parents("td").hasClass("empresa") && !$("#ltxt_extPoE").ext()){
		$("#participante").accordion("option","active",$("#ltxt_extPoE").parents("div").prev("h3").index("h3"));
		alert("Extensión inválida");
		$("#ltxt_extPoE").focus();
		return false;
	}
	if(!$("#ltxt_telCtoPoE").parents("td").hasClass("empresa") && !$("#ltxt_telCtoPoE").telefono()){
		$("#participante").accordion("option","active",$("#ltxt_telCtoPoE").parents("div").prev("h3").index("h3"));
		alert("Número telefónico inválido");
		$("#ltxt_telCtoPoE").focus();
		return false;
	}
	if(!$("#ltxt_extCtoPoE").parents("td").hasClass("empresa") && !$("#ltxt_extCtoPoE").ext()){
		$("#participante").accordion("option","active",$("#ltxt_extCtoPoE").parents("div").prev("h3").index("h3"));
		alert("Extensión inválida");
		$("#ltxt_extCtoPoE").focus();
		return false;
	}
	var expresion = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(!$("#ltxt_emailCtoPoE").parents("td").hasClass("empresa") && !expresion.test($("#ltxt_emailCtoPoE").val())){
		alert("Correo inválido");
		$("#participante").accordion("option","active",$("#ltxt_emailCtoPoE").parents("div").prev("h3").index("h3"));
		$("#ltxt_emailCtoPoE").focus();
		return false;
	}
	var i = 0;
	for(i = 0;i <= contador; i++){
		suc = "lint_sucPoE"+i;
		cta = "lint_ctaPoE"+i;
		cbe = "ltxt_cbePoE"+i;
		if(isNaN($("#"+suc).val())){
			alert("La sucursal es numérica");
			$("#participante").accordion("option","active",$("#"+suc).parents("div").prev("h3").index("h3"));
			$("#"+suc).focus();
			return false;
		}
                if($("#"+suc).val().length>4){
                    alert("La sucursal es no es válida");
			$("#participante").accordion("option","active",$("#"+suc).parents("div").prev("h3").index("h3"));
			$("#"+suc).focus();
			return false;
                }
		if(isNaN($("#"+cta).val())){
			alert("El número de cuenta es numérico");
			$("#participante").accordion("option","active",$("#"+cta).parents("div").prev("h3").index("h3"));
			$("#"+cta).focus();
			return false;
		}
                if($("#"+cta).val().length!=16){
			alert("El número de cuenta debe tener 16 dígitos");
			$("#participante").accordion("option","active",$("#"+cta).parents("div").prev("h3").index("h3"));
			$("#"+cta).focus();
			return false;
		}
		if($("#"+cbe).val().length != 18 || isNaN($("#"+cbe).val())){
			alert("CLABE inválida");
			$("#participante").accordion("option","active",$("#"+cbe).parents("div").prev("h3").index("h3"));
			$("#"+cbe).focus();
			return false;
		}
	}
	return true;
}

/*
*  Aplica tema de jquery ui
*/
$(function() {
	$(document).tooltip();
	$( "input[type=button],input[type=submit]" ).button();
	$("td").addClass("ui-corner-all");
	$("#participante").accordion({collapsible: true,heightStyle: "content"});
	$("input").addClass("ui-corner-all");
});
  
/*
* Nombre: Juan Carlos Piña Moreno
* Nombre del módulo: quitarCuenta
* Función del módulo: elimina los campos corrsespondientes a una cuenta
* Fecha: 15/05/2013
*/
function quitarCuenta(actual){
	if(!banderaCuentas){
		contador = actual;
		banderaCuentas = true;
	}
	if(confirm("¿Realmente desea eliminar la cuenta? El registro se perderá de inmediato")){
		if(contador>1){
			$("#termina"+(contador-1)).html("<a href='#' id='quitaCuenta'>Eliminar</a>");
			$("#quitaCuenta").button({icons: {primary: "ui-icon-trash"}});
			$("#quitaCuenta").on("click",function(click,ui){quitarCuenta();});
		}
		$("#totalCuentas").val($("#totalCuentas").val()-1);
		var url = "../participante/eliminaCuenta.php";
		$.post(url,{IdEntCue: $("#IdEntCue"+contador).val()},function(responseText){
			$("#datos").after(responseText);
		});
		$("#cuentas"+contador).remove();
		contador--;
	}else{return;}
}

function mostrarCampos(){
	if($("#ltxt_pflPoE :selected").text()=="PM INT" || $("#ltxt_pflPoE :selected").text()=="PM EXT"){
		$(".ocultar").removeClass("empresa");
		if(!consulta)
			$(".ocultar").children("input").val("");
	}else{
		$(".ocultar").addClass("empresa");
		if(!consulta)
			$(".ocultar").children("input").val("");
	}
}


function mostrarInfoPoE(IdEntPoE){
	$("#datos").html("");
	if(IdEntPoE != 0){
		creaBarra();
		var url = "../participante/consultaParticipante.php";
		$.post(url,{PoE:IdEntPoE},function(responseText){
			$("#datos").html(responseText);
			eliminaBarra();
		});
	}
}

function habilitaCampos(){
	$(document).find("input,select").removeAttr("disabled");
	$(document).find("input[type=button],input[type=submit],td").css("visibility","visible");
	$(document).find("input[type=button],input[type=submit],td").css("display","");
	$("#modificarPoE").css("visibility","hidden");
	$("#modificarPoE").css("display","none");
}

function eliminaPoE(){
	if(confirm("¿Eliminar lógicamente la persona o empresa?")){
		$("#formElimina").submit();
	}
}
function camposRegistrados(){

	if($("#ltxt_pflPoE :selected").text()=="PM INT" || $("#ltxt_pflPoE :selected").text()=="PM EXT"){
	$(".ocultar").removeClass("empresa");
	}
	else{
	$(".ocultar").addClass("empresa");
	}
	
}