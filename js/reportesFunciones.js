function muestraFiltro(select){
    if($(select).val() === '1'){
        var url = "../reporte/proyectos.php";
        $.post(url,{},function (responseText){
           $("#menuIzq").html(responseText); 
           $("#btnRep").button();
           $("#btnRep").click(function(){
                var url1 = "../reporte/reporteProyecto.php";
                $.post(url1,{idPry:$("#lint_idPry").val()},function(data){
                   alert("data"); 
                });
           });
        });
    }
}
