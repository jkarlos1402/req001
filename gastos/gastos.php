<?php
include("../conexion.php");
session_start();

$IdEntPry=$_POST['IdEntPry'];
$IdEntCue=$_POST['IdEntCue'];
$DesEntGas=$_POST['concepto'];
$FecEntGas=$_POST['fecha'];
$MonEntGas=$_POST['monto'];

$lim = count($DesEntGas);
for($i=0;$i<$lim;$i++){  
echo $query = "INSERT INTO tblentgas VALUES ($IdEntCue,$IdEntPry,'$DesEntGas[$i]','".date("Y-m-d",strtotime($FecEntGas[$i]))."',$MonEntGas[$i])";
mysql_query($query,$conexion) or die (mysql_error());
}
?>
