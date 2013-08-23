<?php
session_start();
if (!ISSET($_SESSION["k_username"])) {
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript" src="../js/funcionesGastos.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	creaBarra();
	cargarParticipante();});

//************************************//
//Nombre: Regino Tabares
//Nombre del mÃ³dulo: cargarClientes()
//Funcion del mÃ³dulo: Llamar a "cliente.php" para consultar los clientes ya registrados y ponerlos en un SELECT sin recargar la pÃ¡gina
//Fecha:10/05/03
//*************************************
function cargarParticipante(){
	var url = "../participante/participante.php";
	$.post(url,{},function(responseText){
		$("#part").html(responseText);
		eliminaBarra();
	});
}

</script>
<form class="form" method="POST" action="../cliente/modificaCliente.php" target="_top" id="formModificaCli">
	<h2 align="center" class="encabezado">REGISTRO DE GASTOS</h2>
	<br>
    
	
    <div align="center" id="div_cra"> 
	<table width="100%">
	<tr>
    <td align="center"> 
    <div id="part"></div>
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