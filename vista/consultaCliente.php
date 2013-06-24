<?php 
$ban=false;
session_start(); 
if(!ISSET($_SESSION["k_username"])){
header("HTTP/1.0 404 Not Found");
die();	
}
?>
<!DOCTYPE html>
<hmtl lang="es">
<head>
<meta charset="utf-8">
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(document).ready(function(){
	creaBarra();
	cargarClientes();});

//************************************//
//Nombre: Regino Tabares
//Nombre del mÃ³dulo: cargarClientes()
//Funcion del mÃ³dulo: Llamar a "cliente.php" para consultar los clientes ya registrados y ponerlos en un SELECT sin recargar la pÃ¡gina
//Fecha:10/05/03
//*************************************
function cargarClientes(){
	$("#datos").html("");
	var url = "../cliente/cliente.php";
	$.post(url,{},function(responseText){
		$("#clientes").html(responseText);
		eliminaBarra();
	});
	
}

</script>
</head>
<body>
<form class="form" method="POST" action="../cliente/modificaCliente.php" target="_top" id="formModificaCli">
	<h2 align="center" class="encabezado">CONSULTA DE CLIENTES</h2>
	<br>
    
	
    <div align="center" id="div_cra"> 
	<table>
	<tr>
    <td align="center"> 
    <div id="clientes"></div>
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
</body>
</html>