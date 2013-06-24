<!DOCTYPE html>
<hmtl lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script src="../js/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../js/funciones.js" type="text/javascript"></script>
<?php session_start(); ?>

<script type="text/javascript">

//************************************//
//Nombre: Regino Tabares
//Nombre del módulo: cargarProyecto()
//Funcion del módulo: Llamar a "proyecto.php" para consultar los proyectos ya registrados y ponerlos en un SELECT sin recargar la página
//Fecha:13/05/03
//*************************************
$(document).ready(function(){
	creaBarra();
	cargarProyecto();
});
	
function cargarProyecto(){
	var url = "../ingresos/proyecto.php";
	$.post(url,{},function(responseText){
		$("#proyecto").html(responseText);
		eliminaBarra();
	});
}

</script>

</head>
<body>

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
</body>
</html>