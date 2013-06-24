<!DOCTYPE html>
<hmtl lang="es">
<head>
<meta charset="utf-8">
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/participanteFunciones.js"></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<?php session_start(); ?>
<script type="text/javascript">
//************************************//
//Nombre: Regino Tabares
//Nombre del mÃ³dulo: cargarParticipante()
//Funcion del mÃ³dulo: Llamar a "participante.php" para consultar los participantes ya registrados y ponerlos en un SELECT sin recargar la pÃ¡gina
//Fecha:10/05/03
//*************************************
$(document).ready(function(){
	creaBarra();
	cargarParticipante();
});	

function cargarParticipante(){
	var url = "../participante/participante.php";
	$.post(url,{},function(responseText){
		$("#part").html(responseText);
		eliminaBarra();
	});
}
</script>
</head>
<body>

	<h2 align="center" class="encabezado ui-corner-all">CONSULTA DE EMPRESAS Y PERSONAS FÍSICAS</h2>
	<br>
    <div align="center" id="div_cra"> 
	<table>
    <tr>
    <td id="part">
    </td>	
  	</tr>

  	</table>     
    
  <div id="datos">
  </div>

    </div>
<div id="progressbar" style="visibility:hidden; display:none;"><div class="progress-label" >Buscando...</div></div>
</body>
</html>