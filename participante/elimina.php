<?php
session_start();
require_once '../conexion.php';
$IdEntPoE = $_POST['IdEntPoE'];
$query = "update tblentpoe set EstEntPoE = 0 where IdEntPoE = $IdEntPoE";
$res = mysql_query($query,$conexion);
if(!$res){
	$_SESSION['mensajeError'] = "Error: ".mysql_error();
}else{
	$_SESSION['mensajeInfo'] = "Se a eliminano la persona o empresa correctamente";
}
header("Location: ../");