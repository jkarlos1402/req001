<?php
include("../conexion.php");
$IdEntPoE=$_POST['IdEntPoE'];
$FecMovDspPag=$_POST['FecMovDspPag'];
$IdOrgPag=$_POST['IdOrgPag'];
$IdEntBan=$_POST['IdEntBan'];
$IdEntCue=$_POST['IdEntCue'];
$MonDspPag=$_POST['MonDspPag'];
$IdDesPag=$_POST['IdDesPag'];
$IdEntPag = $_POST['IdEntPag'];
$padre = $_POST['padre'];
$query = "INSERT INTO tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntCue,IdEntPag,PadDspPag) values ((SELECT STR_TO_DATE('$FecMovDspPag','%Y-%m-%d' )),$MonDspPag,$IdOrgPag,$IdDesPag,$IdEntCue,$IdEntPag,$padre)";
echo $padre;
$res = mysql_query($query,$conexion);
