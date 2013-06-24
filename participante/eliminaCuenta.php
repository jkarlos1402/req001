<?php
session_start();
require_once '../conexion.php';
$IdEntCue = $_POST['IdEntCue'];
$query ="delete from tbldsppag where IdEntCue = $IdEntCue";
$res = mysql_query($query,$conexion);
$query = "delete from tblentcue where IdEntCue = $IdEntCue";
$res = mysql_query($query,$conexion);