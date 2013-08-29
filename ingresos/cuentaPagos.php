<?php
//**********************************************************************************************//
// Nombre: Regino Tabares     																	//
// Nombre del módulo: Obtencíon de los participantes    										//
// Función del módulo: Obtiene los participantes registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
$IdEntPoE = $_POST['IdEntPoE'];
$query = "select * from tblentcue where IdEntPoE =".$IdEntPoE;
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select class='ui-corner-all'><option>No hay cuentas registradas</option></select>";	
	}
	else
	{
$perfiles = '<select name="IdEntCue" id="IdEntCue" onchange=""><option value="0">Selecciona una cuenta</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntCue'].'">'.$renglon['NumEntCue'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;

?>
