<?php
//**********************************************************************************************//
// Nombre: Regino Tabares       																//
// Nombre del módulo: Obtencíon de proyectos 														//
// Función del módulo: Obtiene los proyectos registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
session_start();
$IdEntPag = $_POST['IdEntPag'];	
$MonEntPagRal = $_POST['MonEntPagRal'];
$PorEntPagRal = $_POST['PorEntPagRal'];
$FecEntPagRal = date("Y-m-d",strtotime($_POST['FecEntPagRal']));
$IdEntMov = $_POST['IdEntMov'];
$IdEntCue = $_POST['IdEntCue'];
if(!isset($_POST['InfEntPag'])){
    $InfEntPag='';
}
else{
    $InfEntPag = $_POST['InfEntPag'];
}
$query = "select IdEntEst from tblentest where DscEntEst like 'EJECUTADO'";
		$res = mysql_query($query,$conexion);
		while($fila = mysql_fetch_array($res)){
			$estado = $fila['IdEntEst'];
		}
$query = "UPDATE tblentpag SET FecEntPagRal=(SELECT STR_TO_DATE('$FecEntPagRal','%Y-%m-%d' )), IdEntEst=$estado, MonEntPagRal = $MonEntPagRal, PorEntPagRal = $PorEntPagRal, IdEntMov =$IdEntMov, IdEntCue=$IdEntCue, InfEntPag='".$InfEntPag."' WHERE IdEntPag=$IdEntPag";
$res = mysql_query($query,$conexion);
echo "!Pago Registrado!";

