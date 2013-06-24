<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$padre = $_POST['padre'];
$hijo = $_POST['hijo'];
$query = "select * from tblorgpag";
		
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0) //Si no hay registros envia un aviso 
	{
	$perfiles = "<select><option>No hay origenes</option></select>";	
	}
	else // Si si hay registros imprime los resultados
	{
$perfiles = '<select name="IdOrgPag'.$padre.$hijo.'" id="IdOrgPag'.$padre.$hijo.'" onchange="agregaOrigen(this.value)"><option>Selecciona</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
}
$perfiles = $perfiles."<option value='otros'>OTRO...</option></select>";
	}
echo $perfiles;