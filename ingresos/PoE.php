<?php
//**********************************************************************************************//
// Nombre: Regino Tabares     																	//
// Nombre del módulo: Obtencíon de los participantes    										//
// Función del módulo: Obtiene los participantes registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
$padre=$_POST['padre'];
$hijo=$_POST['hijo'];
$query = "select * from tblentpoe";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select class='ui-corner-all'><option>No hay personas físicas o empresas registradas</option></select>";	
	}
	else
	{
$perfiles = '<select name="IdEntPoE'.$padre.$hijo.'" id="IdEntPoE'.$padre.$hijo.'"  onchange="consultaBanco(this.value,'.$padre.','.$hijo.')"><option value="0">Selecciona un cliente</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;
