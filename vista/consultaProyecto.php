<script>

    $(document).ready(function() {
        creaBarra();
        cargarProyecto();
    });

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: cargarProyecto()
//Funcion del módulo: Llamar a "proyecto.php" para consultar los proyectos ya registrados y ponerlos en un SELECT sin recargar la página
//Fecha:13/05/03
//*************************************
    function cargarProyecto() {
        var url = "../proyecto/proyecto.php";
        $.post(url, {}, function(responseText) {
            $("#listaProyecto").html(responseText);
            eliminaBarra();
            //cargaCaracteristicas();
        });
    }

</script>
<h2 align="center" class="encabezado">CONSULTA DE PROYECTOS</h2>
<br>
<div align="center" id="div_cra"> 
    <table>
        <tr>
            <td id="listaProyecto">
            </td>	
        </tr>
    </table>     
    <div id="datos">
    </div>
</div>
<div id="progressbar" style="visibility:hidden; display:none;"><div class="progress-label" >Buscando...</div></div>