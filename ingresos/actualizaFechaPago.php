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
$FecEntPagRal = $_POST['FecEntPagRal'];
$query = "select IdEntEst from tblentest where DscEntEst like 'EJECUTADO'";
		$res = mysql_query($query,$conexion);
		while($fila = mysql_fetch_array($res)){
			$estado = $fila['IdEntEst'];
		}
$query = "UPDATE tblentpag SET FecEntPagRal=(SELECT STR_TO_DATE('$fecha','%Y-%m-%d' )), IdEntEst=$estado, MonEntPagRal = $MonEntPagRal WHERE IdEntPag=$IdEntPag";
echo $query;
//$res = mysql_query($query,$conexion);


