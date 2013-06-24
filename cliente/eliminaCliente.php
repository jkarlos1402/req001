<?php
session_start();
include("../conexion.php");
$IdEntCli=$_POST['IdEntCli'];
$query = "UPDATE tblentcli SET EstEntCli = 0 WHERE IdEntCli=$IdEntCli";
$res= mysql_query($query,$conexion); 
$query = "UPDATE tblentpry SET EstEntPry = 0 WHERE IdEntCli=$IdEntCli";
$res= mysql_query($query,$conexion);
if(!$res)
	$_SESSION['mensajeError'] = "Error ".mysql_error();
$_SESSION['mensajeInfo'] = "¡Se ha eliminado el cliente!";
header("Location: ../");
?>