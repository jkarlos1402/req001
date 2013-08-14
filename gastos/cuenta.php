<?php
include("../conexion.php");
session_start();
$IdEntCue=$_POST['IdEntCue'];
  
$query = "SELECT SalActEntCue FROM tblentcue WHERE IdEntCue = $IdEntCue";
$result = mysql_query($query,$conexion) or die (mysql_error());
$saldo = mysql_fetch_array($result);
echo $saldo[0];
?>