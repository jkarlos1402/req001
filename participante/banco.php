<?php
//**********************************************************************************************//
// Nombre: Regino Tabares       																//
// Nombre del módulo: Obtencíon de bancos 														//
// Función del módulo: Obtiene los bancos registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
session_start();
	$contador=$_POST['elegido'];
	
$query = "select * from tblentban";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select class='ui-corner-all'><option>No hay bancos registrados</option></select>";	
	}
	else
	{
$perfiles = '<select required name="banPoEmod'.$contador.'" id="banPoEmod'.$contador.'" class="ui-corner-all">';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntBan'].'">'.$renglon['NomEntBan'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;
