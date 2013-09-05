<?php
session_start(); 
if(!ISSET($_SESSION["k_username"])){
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';	
}
if(ISSET($_GET['IdEntPry'])){
echo '<script>mostrarInfoProyecto('.$_GET['IdEntPry'].');
            cargarProyecto();
            function cargarProyecto() {
                var url = "../proyecto/proyecto.php";
                $.post(url, {}, function(responseText) {
                    $("#listaProyecto").html(responseText);
                     $("#IdEntPry option[value='.$_GET['IdEntPry'].']").attr("selected",true);
                });
            }
           
        </script>';
}
else{
    echo '
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
                });
            }

            </script>
            ';
}
?>

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