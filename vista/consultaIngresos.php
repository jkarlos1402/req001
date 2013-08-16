<?php 
session_start(); 
if(!ISSET($_SESSION["k_username"])){
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';	
}
if ($_SESSION["k_perfil"] == "USU") {
    header("HTTP/1.0 404 Not Found");
    die();
}
?>

<script type="text/javascript">

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: cargarProyecto()
//Funcion del módulo: Llamar a "proyecto.php" para consultar los proyectos ya registrados y ponerlos en un SELECT sin recargar la página
//Fecha:13/05/03
//*************************************
    $(document).ready(function() {
        creaBarra();
        cargarProyecto();
    });

    function cargarProyecto() {
        var url = "../ingresos/proyecto.php";
        $.post(url, {}, function(responseText) {
            $("#proyecto").html(responseText);
            eliminaBarra();
        });
    }

</script>
<h2 align="center" class="encabezado">REGISTRO Y DISPERSIÓN DE PAGOS</h2>
<br>
<div align="center" id="div_cra"> 
    <table>
        <tr>
            <td id="proyecto">

            </td>	
        </tr>
    </table>     
    <div id="datos">


    </div>
</div>
<div id="progressbar" style="visibility:hidden; display:none;"><div class="progress-label" >Buscando...</div></div>
