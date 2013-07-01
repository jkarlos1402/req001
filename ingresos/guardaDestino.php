<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$destinonuevo=$_POST['destinonuevo'];

$query = "INSERT INTO tbldespag (DscDesPag) values ('$destinonuevo')";
		
$res = mysql_query($query,$conexion);


echo mysql_insert_id();