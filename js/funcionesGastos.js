$(function() {
    $("input[type=button],input[type=submit]").button(); 
    $(".agrega").button({icons: {primary: "ui-icon-plusthick"},text: false});
    $(".elimina").button({icons: {primary: "ui-icon-trash"},text: false});
    var url = "../gastos/proyectos.php";
    $.post(url,{},function(responseText){
        $("#proyecto0").html(responseText);
    });
});
function creaBarra(){
	$( "#progressbar" ).progressbar({
      	value: false,
	});
	$("#progressbar").css("visibility","visible");
	$("#progressbar").css("display","");
	$(".progress-label").css("visibility","visible");
	$(".progress-label").css("display","");
}

function eliminaBarra(){
	$("#progressbar").progressbar("destroy");
	$(".progress-label").css("visibility","hidden");
	$(".progress-label").css("display","none");
}

function mostrarInfoPoE(IdEntPoE){   
	$("#datos").html("");
	if(IdEntPoE != 0){
		creaBarra();
		var url = "../gastos/consultaCuentas.php";
		$.post(url,{PoE:IdEntPoE},function(responseText){
			$("#datos").html(responseText);
			eliminaBarra();
                        
                        
                       
		});
	}
}

var select;
function despliegaMovimientos(index){
   
    var cuenta = $("#NomEntBan"+index).val()+"-"+$("#SucEntSuc"+index).val()+"-"+$("#NumEntCue"+index).val();
    var IdEntCue=$("#IdEntCue"+index).val();
    $("#cuentax").val(IdEntCue);
    //$("#ingresos").val($("#IdEntCue"+index));
    index = parseInt($("#movimientos").find(".index:last").val())+1;
    for(i=1;i<=index;i++){
        $("#mov"+i).html("");
        
    }
    for(i=1;i<=indexCampos;i++){
        $("#mov0").find("#campos"+i).remove();
    }
    $("#mov0").find(".montoTotal:last").val("0.00");
    $("#campos0").find("input").val("");
     $("#campos0").find(".index:last").val("0");
  $("#campos0").find(".indexCampos:last").val("0");
    $("#totalGeneral").val("0.00");
    $("#cuenta").val(cuenta);
    $("#movimientos").css("visibility","visible");
    $("#movimientos").css("display","");
    
    
    
    var url2 = "../gastos/gastosRegistrados.php";
    $.post(url2,{IdEntCue:IdEntCue},function(responseText){
       $("#datosGastos").html(responseText); 
    });
    
    
    
    var url = "../gastos/ingresos.php";
    $.post(url,{IdEntCue:IdEntCue},function(responseText){
        $("#ingresos").val(responseText);
    });
    
    var url="../gastos/cuenta.php";
    $.post(url,{IdEntCue:IdEntCue},function(responseText){
        $("#saldo").val(responseText);
    });
    $("#IdEntPry0").prop("selectedIndex",0);
    $(".movRegistrados").html('');
    $(".datosMov").css("visibility","hidden");
    $(".datosMov").css("display","none");
    $("#ui-datepicker-div").remove();
    $("input[type=fecha]").datepicker();
    $("input[type=fecha]").datepicker("option","dateFormat","dd-mm-yy");
    $("#agregar").button("disable");
    select = $("#mov0").find("#IdEntPry0").clone();
}

var cuenta;
var index;

function agregarMovimientos(){
    
  index = parseInt($("#movimientos").find(".index:last").val())+1;
  //$("#IdEntPry0").attr("name","IdEntPry"+index);
  $("#fecha00").attr("id","fecha"+index+"0");
  $("#form0").attr("id","form"+index);
  $("#agrega0").attr("id","agrega"+index);
  $("#elimina0").attr("id","elimina"+index);
  var newElem =$("#mov0").clone().attr('id', 'mov'+index);
  newElem.find(".movRegistrados").html('').next("div").css({"visibility":"hidden","display":"none"});
  if(indiceSelect!=null){
      select.find("option:eq("+indiceSelect+")").css({"display":"none"}).removeClass("visible");
      select.removeAttr("disabled");///////////////////////////////////////aqui me quede!!!!!!!!!!!
      var newSelect = select.clone();
     // alert(select.html());
      newElem.find("#IdEntPry0").replaceWith(newSelect);
      //newElem.find("#IdEntPry0 option:eq("+indiceSelect+")").remove();
  }
  //$("#IdEntPry"+index).attr("name","IdEntPry0");
  $("#agrega"+index).attr("id","agrega0");
  $("#elimina"+index).attr("id","elimina0")
  $("#fecha"+index+"0").attr("id","fecha00");
  $("#form"+index).attr("id","form0");
  $("#mov"+(index-1)).after(newElem);
  $("#movimientos").find(".index:last").val(index);
  for(i=1;i<=indexCampos;i++){
        $("#mov"+index).find("#campos"+i).remove();
    }

  
  $("#mov"+index).find("input[type=text]").val("");  
  $("#mov"+index).find(".index:last").val(index);
  $("#mov"+index).find(".indexCampos:last").val("0");
  $("#mov"+index).find("#montoTotal").val("");
  $("#mov"+index).find("#fecha"+index+"0").removeClass("hasDatepicker").datepicker().val("");
  $("#mov"+index).find(".agrega:last").attr('onclick','agregaCampos('+index+')');
  $("#mov"+index).find(".elimina:last").attr('onclick','eliminaCampos('+index+')');
  $("#mov"+index).find("#monto0").attr('onchange','sumaGastos('+index+')');
  if(index>0){
      $("#eliminar").css("visibility","visible");
      $("#eliminar").css("display","");
  }
  $("#agregar").button("disable");
  indiceSelect = -1;
}

var indexCampos;
function agregaCampos(indice){
   
    indexCampos = parseInt($("#mov"+indice).find(".indexCampos:last").val())+1;
    
    //Cambia ID
    $("#mov"+indice).find("#concepto0").attr('id','concepto'+indexCampos);
                                    $("#mov"+indice).find("#fecha"+indice+"0").attr('id','fecha'+indice+""+indexCampos);
    $("#mov"+indice).find("#monto0").attr('id','monto'+indexCampos);
    //Clona Renglon
    var newTr =$("#mov"+indice).find("#campos0").clone().attr('id','campos'+indexCampos);
    //Regresa Id anterior
    $("#mov"+indice).find("#concepto"+indexCampos).attr('id','concepto0');
                                     $("#mov"+indice).find("#fecha"+indice+""+indexCampos).attr('id','fecha'+indice+"0");
    $("#mov"+indice).find("#monto"+indexCampos).attr('id','monto0');
    //Inserta Renglon
    $("#mov"+indice).find(".campos:last").after(newTr);
    //Borra atributos anteriores
    $("#mov"+indice).find("#concepto"+indexCampos).val("");
    $("#mov"+indice).find("#monto"+indexCampos).val("");
    $("#mov"+indice).find("#fecha"+indice+""+indexCampos).removeClass("hasDatepicker").datepicker().val("");
    $("#mov"+indice).find(".indexCampos:last").val(indexCampos);
    if(indexCampos >0){
        $("#elimina"+indice).css("visibility","visible");
        $("#elimina"+indice).css("display","");
    }
        
}

function eliminaCampos(indice){
    
    if($("#mov"+indice).find(".campos:last").attr('id')=='campos1'){
        $("#elimina"+indice).css("visibility","hidden");
        $("#elimina"+indice).css("display","none");
    }
    $("#mov"+indice).find(".campos:last").remove();
    sumaGastos(indice);
}

function eliminarMovimientos(){    
    if($("#movimientos").find(".mov:last").attr("id")=='mov1'){
        $("#eliminar").css("visibility","hidden");
        $("#eliminar").css("display","none");
    }
    $("#movimientos").find(".mov:last").remove();
    sumaTotal();
    saldoCuenta();
    select.find("option:eq("+indiceSelect+")").css({"display":""}).addClass("visible");
    $("#agregar").button("enable");
    indiceSelect = -1;
}


function sumaGastos(indice){
    var suma=0;
 $("#mov"+indice).find(".monto").each(function(){
     suma=suma+parseFloat($(this).val());
 });
 if(isNaN(suma))
        suma="0.00";
 $("#mov"+indice).find("#montoTotal").val(suma.toFixed(2));    
 sumaTotal();
 saldoCuenta();
}

function sumaTotal(){
 var sumaTotal=0;
 $("#movimientos").find(".montoTotal").each(function(){
     sumaTotal=sumaTotal+parseFloat($(this).val());
 });
 $("#movimientos").find("#totalGeneral").val(sumaTotal.toFixed(2));
}

function saldoCuenta(){
 var saldo = parseFloat($("#ingresos").val()-$("#totalGeneral").val());
 $("#saldo").val(saldo.toFixed(2));
}

function guardarGastos(){
    var lim=$("#movimientos").find(".index:last").val();
    if(validaCampos(lim)){
         $("#movimientos").find("select").removeAttr("disabled");
        var url="../gastos/gastos.php";
        for(i=0;i<=lim;i++){

            $.post(url,$("#form"+i).serialize(),function(responseText){
                $("#log").html("<p><strong>"+responseText+"</strong></p>").addClass("ui-widget ui-state-highlight ui-corner-all").css({"width":"250px","position":"absolute","margin-left":"500px","margin-top":"-150px","text-align": "center"}).show( "puff", 1000 ).delay(2000).hide( "puff", 1000 );

            });
        }
    
        var cuenta=$("#cuentax").val();
        var saldo = $("#saldo").val();
        var url ="../gastos/estadoCuenta.php";
        $.post(url,{cuenta:cuenta,saldo:saldo},function(responseText){
                /*$("#log").html(responseText);*/
        });
        
    }
}
var indiceSelect;

function despliegaRegistrados(IdEntPry){
    var gastosRegistrados=0.00;
    var IdEntCue = $("#cuentax").val();
    var url="../gastos/gastosRegistrados.php";
    $.post(url,{IdEntPry:$(IdEntPry).val(),IdEntCue:IdEntCue},function(reponseText){
        $(IdEntPry).parents("table").next("div").html(reponseText).next("div").css({"visibility":"visible","display":""});
        indiceSelect=$(IdEntPry).prop("selectedIndex");
        //$(IdEntPry).parents("div").find(".movRegistrados:first").html(reponseText);
        $(".elimina").button({icons: {primary: "ui-icon-trash"},text: false});
        $(IdEntPry).parents("table").next("div").find(".monto").each(
            function(){
                gastosRegistrados=gastosRegistrados+eval($(this).val());
            });
            $(IdEntPry).parents("table").next("div").next("div").find("#montoTotal").val(gastosRegistrados.toFixed(2));
                    
        //$(".datosMov").css("visibility","visible");
        //$(".datosMov").css("display","");
    });
    $(IdEntPry).attr("disabled","disabled");
    if(select.find(".visible").size() > 2){
        $("#agregar").button("enable");
    }
}

var k;
var estado;
function validaCampos(indice){
estado =  true;
    for(k=0 ;k<=indice;k++){
    $("#mov"+k).find("select,input").each(function(){
        if($(this).val()===''||$(this).prop("selectedIndex")===0){
            
            $(this).focus().css("background-color","#FFB7B7");
            estado = false;
            
        }
        else{
            $(this).css("background-color","#FFFFFF");
            
        }
    });
    }
 return estado;
}

