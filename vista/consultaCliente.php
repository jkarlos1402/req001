<?php
$ban = false;
session_start();
if (!ISSET($_SESSION["k_username"])) {
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        creaBarra();
        cargarClientes();
    });

//************************************//
//Nombre: Regino Tabares
//Nombre del mÃ³dulo: cargarClientes()
//Funcion del mÃ³dulo: Llamar a "cliente.php" para consultar los clientes ya registrados y ponerlos en un SELECT sin recargar la pÃ¡gina
//Fecha:10/05/03
//*************************************
    function cargarClientes() {
        $("#datos").html("");
        var url = "../cliente/cliente.php";
        $.post(url, {}, function(responseText) {
            $("#listaClientes").html(responseText);
            eliminaBarra();
        });
    }

</script>
<form class="form" method="POST" action="../cliente/modificaCliente.php" target="_top" id="formModificaCli">
    <h2 align="center" class="encabezado">CONSULTA DE CLIENTES</h2>
    <br/>
    <div align="center" id="div_cra"> 
        <table>
            <tr>
                <td align="center"> 
                    <div id="listaClientes"></div>
                </td>	
            </tr>
            <tr>
                <td>
                    <div id="datos"></div>
                </td>
            </tr>
        </table>
    </div>
</form>
<div id="progressbar" style="visibility:hidden; display:none;"><div class="progress-label" >Buscando...</div></div>
