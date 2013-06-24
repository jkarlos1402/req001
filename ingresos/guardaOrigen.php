<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$origennuevo=$_POST['origennuevo'];

$query = "INSERT INTO tblorgpag (DscOrgPag) values ('$origennuevo')";
		
$res = mysql_query($query,$conexion);


echo "Nuevo origen registrado";