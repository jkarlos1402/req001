<?php
//**********************************************************************************************//
// Nombre: Regino Tabares     																	//
// Nombre del módulo: Obtencíon de los participantes    										//
// Función del módulo: Obtiene los participantes registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
$query = "select * from tblentmov";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select class='ui-corner-all'><option>No hay datos registrados</option></select>";	
	}
	else
	{
$perfiles = '<select name="IdEntMov" id="IdEntMov"  onchange=""><option value="0">Selecciona un movimiento</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntMov'].'">'.$renglon['DscEntMov'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;
