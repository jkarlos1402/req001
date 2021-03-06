function muestraFiltro(select){
    if($(select).val() === '-1'){
        $("#menuIzq").html("");
        $("#resultadoReporte").html("");
    }
    if($(select).val() === '1'){
        $("#menuIzq").html("");
        $("#resultadoReporte").html("");
        var url = "../reporte/proyectos.php";
        $.post(url,{},function (responseText){
           $("#menuIzq").html(responseText); 
           $("#btnRep").button();
           $("#btnRep").click(function(){
               if($("#lint_idPry").val() !== null){
                    $("#mensaje").html("").removeClass("ui-state-error ui-corner-all");
                    var url1 = "../reporte/reporteProyecto.php";
                    $.post(url1,{idPry:$("#lint_idPry").val()},function(data){
                       $("#resultadoReporte").html(data);                      
                       $("table tfoot td").nextAll("td").css({"border":"solid 1px","cellpading":"0px"});
                    });
               }else{
                   $("#mensaje").html("<span>Seleccione por lo menos un proyecto</span>").
                           css({"color":"#cd0a0a","width": "231px","padding": "12px","margin-top": "31px"}).
                           addClass("ui-state-error ui-corner-all");
               }
           });
        });
    }
    
    if($(select).val() === '2'){
        $("#menuIzq").html("");
        $("#resultadoReporte").html("");
        var url = "../reporte/clientes.php";
        $.post(url,{},function (responseText){
           $("#menuIzq").html(responseText); 
           $("#btnRep").button();
           $("#btnRep").click(function(){
               if($("#lint_idCli").val() !== null){
                    $("#mensaje").html("").removeClass("ui-state-error ui-corner-all");
                    var url1 = "../reporte/reporteClientes.php";
                    $.post(url1,{IdEntCli:$("#lint_idCli").val()},function(data){
                       $("#resultadoReporte").html(data);                      
                       $("table tfoot td").nextAll("td").css({"border":"solid 1px","cellpading":"0px"});
                    });
               }else{
                   $("#mensaje").html("<span>Seleccione por lo menos un cliente</span>").
                           css({"color":"#cd0a0a","width": "231px","padding": "12px","margin-top": "31px"}).
                           addClass("ui-state-error ui-corner-all");
               }
           });
        });
    }
    
    if($(select).val() === '3'){
        $("#menuIzq").html("");
        $("#resultadoReporte").html("");
        var url = "../reporte/empresas.php";
        $.post(url,{},function (responseText){
           $("#menuIzq").html(responseText); 
           $("#btnRep").button();
           $("#btnRep").click(function(){
               if($("#lint_idPoE").val() !== null){
                    $("#mensaje").html("").removeClass("ui-state-error ui-corner-all");
                    var url1 = "../reporte/reporteEmpresas.php";
                    $.post(url1,{idPoE:$("#lint_idPoE").val()},function(data){
                       $("#resultadoReporte").html(data);                      
                       $("table tfoot td").nextAll("td").css({"border":"solid 1px","cellpading":"0px"});
                    });
               }else{
                   $("#mensaje").html("<span>Seleccione por lo menos una empresa</span>").
                           css({"color":"#cd0a0a","width": "231px","padding": "12px","margin-top": "31px"}).
                           addClass("ui-state-error ui-corner-all");
               }
           });
        });
    }
}
