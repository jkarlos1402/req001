<?php
session_start();
include("../conexion.php");
//Obtiene las variables enviadas por el formulario
$NomEntCli=$_POST['NomEntCli'];
$DirEntCli=$_POST['DirEntCli'];
$TelEntCli=$_POST['TelEntCli'];
$Nom1CtoCli=$_POST['Nom1CtoCli'];
$Dir1CtoCli=$_POST['Dir1CtoCli'];
$Tel1CtoCli=$_POST['Tel1CtoCli'];
$Ext1CtoCli=$_POST['Ext1CtoCli'];
$Nom2CtoCli=$_POST['Nom2CtoCli'];
$Dir2CtoCli=$_POST['Dir2CtoCli'];
$Tel2CtoCli=$_POST['Tel2CtoCli'];
$Ext2CtoCli=$_POST['Ext2CtoCli'];
$Nom3CtoCli=$_POST['Nom3CtoCli'];
$Dir3CtoCli=$_POST['Dir3CtoCli'];
$Tel3CtoCli=$_POST['Tel3CtoCli'];
$Ext3CtoCli=$_POST['Ext3CtoCli'];

//Crea y ejecuta el query para la inserción de los datos
$query = "INSERT INTO  tblentcli (  IdEntCli ,  NomEntCli ,  DirEntCli ,  TelEntCli , EstEntCli ,Nom1CtoCli,Dir1CtoCli,Tel1CtoCli,Ext1CtoCli,Nom2CtoCli,Dir2CtoCli,Tel2CtoCli,Ext2CtoCli,Nom3CtoCli,Dir3CtoCli,Tel3CtoCli,Ext3CtoCli) 
				VALUES ('',  '$NomEntCli',  '$DirEntCli',  '$TelEntCli', '1','$Nom1CtoCli','$Dir1CtoCli','$Tel1CtoCli','$Ext1CtoCli','$Nom2CtoCli','$Dir2CtoCli','$Tel2CtoCli','$Ext2CtoCli','$Nom3CtoCli','$Dir3CtoCli','$Tel3CtoCli','$Ext3CtoCli')";
$res = mysql_query($query,$conexion); 
if(!$res){
	$_SESSION['mensajeError'] = "Error: ".mysql_error();
}
$_SESSION['mensajeInfo'] = "Se agregó el cliente correctamente";
header("Location: ../");
?>
