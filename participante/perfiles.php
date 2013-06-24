<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Obtencíon de perfiles 													//
// Función del módulo: Obtiene los perfiles registrados y los coloca en un select para su uso	//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
$query = "select * from tblentpfl";
if(isset($_GET['id'])){
	$id = $_GET['id'];
	if($id != -1)
		$disabled = "disabled='disabled'";
	else
		$disabled = "";
}
$res = mysql_query($query,$conexion);//Se obtienen todos los perfiles
$perfiles = '<label for="ltxt_pflPoE">Perfil:</label>
			 <select name="ltxt_pflPoE" id="ltxt_pflPoE" onchange="mostrarCampos();" '.$disabled.'>
			 <option></option>';

while($renglon = mysql_fetch_array($res)){// se forma el elemento select
	if($renglon['IdEntPfl'] == $id)
		$selected = "selected = 'selected'";
	else
		$selected = "";
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntPfl'].'" '.$selected.'>'.$renglon['DscEntPfl'].'</option>';
}
$perfiles = $perfiles."</select>";

echo $perfiles;//se regresa a jquery el elemento select con los perfiles