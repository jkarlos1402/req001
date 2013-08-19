function muestraFiltro(select){
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
                    });
               }else{
                   $("#mensaje").html("<span>Seleccione por lo menos un proyecto</span>").
                           css({"color":"#cd0a0a","width": "231px","padding": "12px","margin-top": "31px"}).
                           addClass("ui-state-error ui-corner-all");
               }
           });
        });
    }
}
