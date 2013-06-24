<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/funciones.js"></script>
<?php
include("../conexion.php");
if(ISSET($_POST['IdEntUsu'])){
	$IdEntUsu = $_POST['IdEntUsu'];
	$query = "select * from tblentusu where IdEntUsu = $IdEntUsu";
	$res = mysql_query($query,$conexion);
	$renglon=mysql_fetch_array($res);
echo 
'<div id="dialog-form"> 
	  <form action=""../usuario/modifica.php" id="formModUsu" name="formModUsu" method="post" target="_top">
	  <table border="1" width="100%" class="ui-corner-all">
	  	<tr>
		<td>
		Nombre
		</td>
		<td>
		<input type="hidden" name="IdEntUsu" id="IdEntUsu" value="'.$renglon['IdEntUsu'].'"/>
		<input type="text" name="NomEntUsu" id="NomEntUsu" value="'.$renglon['NomEntUsu'].'" class="text ui-widget-content ui-corner-all requerido" />
		</td>
		</tr>
		<tr>
		<td>
		Password
		</td>
		<td>
		<input type="text" name="PwdEntUsu" id="PwdEntUsu" value="'.$renglon['PwdEntUsu'].'" class="text ui-widget-content ui-corner-all requerido" />
		</td>
		</tr>
		<tr>
		<td>
		Perfil
		</td>
		<td>
		<select id="PflEntUsu" name="PflEntUsu" class="requerido">
			<option value=""></option>
			<option value="ADM">Administrador</option>
			<option value="USU">Usuario</option>
		</select>
		</td>
		</tr>
		<tr>
		<td>
		<input type="submit" value="Modificar usuario" />
		</td>
		<td id="mensajeMod">
		<div id="errorMod" style="visibility:hidden; display:none;">
	  		<div class="ui-widget">
            	<div class="ui-state-error ui-corner-all">
                <p>
                <span class="ui-icon ui-icon-alert" style="float: left;"></span>
                <strong>Error</strong>
                </p>
                </div>
            </div>
      	</div>
		</td>
		</tr>
	  </table>
	  </form>
	</div>';
}
else{
//Crea y ejecuta la consulta para saber los clientes registrados
$query = "select * from tblentusu";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0) //Si no hay registros envia un aviso 
	{
	$perfiles = "No hay clientes registrados";	
	}
	else // Si si hay registros imprime los resultados
	{
echo '
<table align="center" width="100%">
<tr class="ui-widget-header ui-corner-all" align="center">
<td>
Nombre
</td>
<td>
Password
</td>
<td>
Perfil
</td>
</tr>';
while($renglon = mysql_fetch_array($res)){
echo'
<tr align="center">
<td>
'.$renglon['NomEntUsu'].'
</td>
<td>
'.$renglon['PwdEntUsu'].'
</td>
<td>
'.$renglon['PflEntUsu'].'
</td>
<td>
<input type="button" value="Modificar" onclick="modificaUsu('.$renglon['IdEntUsu'].');"/>
</td>
</tr>';
}
	}
echo '</table>';
}
?>