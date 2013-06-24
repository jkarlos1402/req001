<?php
session_start();
require_once '../conexion.php';
if(isset($_POST['IdEntPag'])){
	$IdEntPag = $_POST['IdEntPag'];
	$query = "delete from tbldsppag where IdEntPag = $IdEntPag";
	$res = mysql_query($query,$conexion);
	$query = "delete from tblentpag where IdEntPag = $IdEntPag";
	$res = mysql_query($query,$conexion);
}