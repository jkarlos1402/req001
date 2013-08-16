function muestraFiltro(select){
    if($(select).val() === '1'){
        var url = "../reporte/proyectos.php";
        $.post(url,{},function (responseText){
           $("#menuIzq").html(responseText); 
           $("#btnRep").button();
        });
    }
}