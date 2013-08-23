<?php
session_start();
include("../conexion.php");
$IdEntUsu = $_POST['IdEntUsu'];
$query = "delete from tblentusu where IdEntUsu =".$IdEntUsu;
$res = mysql_query($query);
if($res){
    echo 'Se eliminó al usuario';
}
?>
