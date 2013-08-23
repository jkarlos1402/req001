<?php
session_start();
include("../conexion.php");
//Obtiene las variables enviadas por el formulario
$IdEntUsu=$_POST['IdEntUsu'];
$NomEntUsu=$_POST['NomEntUsu'];
$PwdEntUsu=$_POST['PwdEntUsu'];
$PflEntUsu=$_POST['PflEntUsu'];
//Crea y ejecuta el query para la inserción de los datos
$query = "UPDATE tblentusu SET NomEntUsu='$NomEntUsu',PwdEntUsu='$PwdEntUsu',PflEntUsu='$PflEntUsu' where IdEntUsu = $IdEntUsu";				
$res = mysql_query($query,$conexion); 
if(!$res){
	echo "Error: ".mysql_error();
}else{
    echo "true";
}

?>
