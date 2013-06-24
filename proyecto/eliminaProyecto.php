<?php
session_start();
require_once '../conexion.php';
$IdEntPry = $_POST['IdEntPry'];
$query = "update tblentpry set EstEntPry = 0 where IdEntPry = $IdEntPry";
$res = mysql_query($query,$conexion);
if(!$res){
	$_SESSION['mensajeError'] = "Error: ".mysql_error();
}else{
	$_SESSION['mensajeInfo'] = "Se eliminó el proyecto correctamente";
}
header("Location: ../");