<?php
session_start();
include("../conexion.php");
//Obtiene las variables enviadas por el formulario
$NomEntUsu=$_POST['NomEntUsu'];
$PwdEntUsu=$_POST['PwdEntUsu'];
$PflEntUsu=$_POST['PflEntUsu'];
//Crea y ejecuta el query para la inserción de los datos
$query = "INSERT INTO tblentusu (NomEntUsu,PwdEntUsu,PflEntUsu) VALUES ('$NomEntUsu','$PwdEntUsu','$PflEntUsu')";				
$res = mysql_query($query,$conexion); 
if(!$res){
	echo "Error: ".mysql_error();
}
else
 echo "Usuario Registrado";

?>
