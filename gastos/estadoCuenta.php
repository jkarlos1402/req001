<?php
include("../conexion.php");
session_start();
$IdEntCue = $_POST['cuenta'];
$SalEntCue = $_POST['saldo'];
$query = "UPDATE tblentcue SET SalActEntCue = $SalEntCue WHERE IdEntCue =$IdEntCue";

mysql_query($query,$conexion) or die (mysql_error());

?>
