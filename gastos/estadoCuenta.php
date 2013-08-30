<?php
include("../conexion.php");
session_start();
$IdEntCue = $_POST['cuenta'];
$SalEntCue = $_POST['saldo'];
$query = "UPDATE tblentcue SET SalEntCue = $SalEntCue WHERE IdEntCue =$IdEntCue";
echo $query;
mysql_query($query,$conexion) or die (mysql_error());

?>
