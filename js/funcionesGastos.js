$(function() {
    $("input[type=button],input[type=submit]").button();    
    
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

function despliegaMovimientos(index){
    var cuenta = $("#NomEntBan"+index).val()+"-"+$("#SucEntSuc"+index).val()+"-"+$("#NumEntCue"+index).val();

    $("#cuenta").val(cuenta);
    $("#movimientos").css("visibility","visible");
    $("#movimientos").css("display","");
}
var index;
function agregarMovimientos(){
  index = parseInt($("#movimientos").find(".index:last").val())+1;
  $("#IdEntPry0").attr("name","IdEntPry"+index);
  $("#IdEntPry0").attr("id","IdEntPry"+index);
  var newElem =$("#mov0").clone().attr('id', 'mov'+index);
   $("#IdEntPry"+index).attr("name","IdEntPry0");
  $("#IdEntPry"+index).attr("id","IdEntPry0");
  alert($("#movimientos").find(".datosMov:last").attr('class'));
  $("#mov"+(index-1)).after(newElem);
  $("#movimientos").find(".index:last").val(index);
}

