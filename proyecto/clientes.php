<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Obtencíon de clientes 													//
// Función del módulo: Obtiene los clientes registrados y los coloca en un select para su uso	//
// Fecha: 09/05/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
$query = "select IdEntCli,NomEntCli from tblentcli where EstEntCli = 1";
$res = mysql_query($query,$conexion);//Se obtienen los clientes de la base de datos
if(isset($_GET['IdEntCli']))
	$IdEntCli = $_GET['IdEntCli'];
else $IdEntCli = "";
$clientes = '<label>Cliente:
		   <select id="lint_cliePry" name="lint_cliePry">
		   <option></option>';
while($cliente = mysql_fetch_array($res)){//Se forman las opciones del select
	if($IdEntCli == $cliente['IdEntCli'])
		$selected = "selected";
	else $selected = "";
	$clientes = $clientes.'<option value="'.$cliente['IdEntCli'].'" '.$selected.'>'.$cliente['NomEntCli'].'</option>';
}
$clientes = $clientes."</select></label>";
echo $clientes;//Regresa el select