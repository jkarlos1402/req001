<?php
session_start();
require_once '../conexion.php';
if(isset($_POST['IdEntEtr'])){
	$IdEntEtr = $_POST['IdEntEtr'];
	$query = "delete from tblentetr where IdEntEtr = $IdEntEtr";
	$res = mysql_query($query,$conexion);
}