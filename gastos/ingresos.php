<?php
include("../conexion.php");
session_start();
$IdEntCue = $_POST['IdEntCue'];
//echo $IdEntCue;
$query = "SELECT SUM(SalDspPag) FROM tbldsppag WHERE IdEntCue =$IdEntCue";
$result = mysql_query($query);
$saldo = mysql_fetch_array($result);
echo $saldo[0];
?>
