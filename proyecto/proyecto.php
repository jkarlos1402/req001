<?php
//**********************************************************************************************//
// Nombre: Regino Tabares       																//
// Nombre del módulo: Obtencíon de proyectos 														//
// Función del módulo: Obtiene los proyectos registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
session_start();
	
	
$query = "select * from tblentpry where EstEntPry = 1";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select><option>No hay proyectos registrados</option></select>";	
	}
	else
	{
$perfiles = '<label>Proyecto: </label><select required name="IdEntPry" id="IdEntPry" onchange="mostrarInfoProyecto(this.value)"><option value="0">Selecciona un proyecto</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntPry'].'">'.$renglon['NomEntPry'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;
/*
$querycliente="select * from tblentcli where IdEntCli =".$renglon['IdEntCli']."";
echo $querycliente;
$res2 = mysql_query($querycliente,$conexion);

while($renglon2 = mysql_fetch_array($res2)){
	echo '<br>Cliente: <input type=text value="'.$renglon2['NomEntCli'].'">';
	}
*/
