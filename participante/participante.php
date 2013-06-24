<?php
//**********************************************************************************************//
// Nombre: Regino Tabares     																	//
// Nombre del módulo: Obtencíon de los participantes    										//
// Función del módulo: Obtiene los participantes registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
$query = "select * from tblentpoe where EstEntPoE = 1";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select class='ui-corner-all'><option>No hay personas físicas o empresas registradas</option></select>";	
	}
	else
	{
$perfiles = '<select name="PoE" id="PoE" style="width:550px;" onchange="mostrarInfoPoE(this.value);" class="ui-corner-all"><option value="0">Selecciona un cliente</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;
