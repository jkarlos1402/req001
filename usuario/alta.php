<?php
session_start();
include("../conexion.php");
//Obtiene las variables enviadas por el formulario
$NomEntUsu=$_POST['NomEntUsu'];
$PwdEntUsu=$_POST['PwdEntUsu'];
$PflEntUsu=$_POST['PflEntUsu'];
//se busca que el usuario no exista
$query = "select NomEntUsu from tblentusu where NomEntUsu = '".$NomEntUsu."'";
$res = mysql_query($query,$conexion);
if(mysql_num_rows($res)==0){
    //Crea y ejecuta el query para la inserción de los datos
    $query = "INSERT INTO tblentusu (NomEntUsu,PwdEntUsu,PflEntUsu) VALUES ('$NomEntUsu','$PwdEntUsu','$PflEntUsu')";				
    $res = mysql_query($query); 
    echo 'true';
}else{
    echo "Error: nombre de usuario existente";
}
?>
