<?php
$IdEntPry=$_POST['IdEntPry'];
$IdEntCue=$_POST['IdEntCue'];
$DesEntGas=$_POST['concepto'];
$FecEntGas=$_POST['fecha'];
$MonEntGas=$_POST['monto'];
$i=0;
while($i<count($DesEntGas)){
echo $query = "INSERT INTO tblentgas VALUES ($IdEntCue,$IdEntPry,null,'$DesEntGas[$i]',$FecEntGas[$i],$MonEntGas[$i]);"."<br>";

$i++;
}

?>
