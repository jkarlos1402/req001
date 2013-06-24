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
$FecEntPagRal = $_POST['FecEntPagRal'];
$FecEntPagRal = date("Y-m-d",strtotime($_POST['FecEntPagRal']));
$query = "UPDATE tblentpag SET FecEntPagRal=(SELECT STR_TO_DATE('$FecEntPagRal','%Y-%m-%d' )) WHERE IdEntPag=$IdEntPag";
$res = mysql_query($query,$conexion);


