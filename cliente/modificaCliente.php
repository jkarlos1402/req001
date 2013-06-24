<?php

	include("../conexion.php");
session_start();
$cliente=$_POST['IdEntCli'];
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
	

	if($NomEntCli == null){
		echo "Error.";	
	}
	else
	{
		$query = "UPDATE `tblentcli` SET NomEntCli='$NomEntCli', DirEntCli='$DirEntCli', TelEntCli='$TelEntCli',Nom1CtoCli='$Nom1CtoCli', Dir1CtoCli='$Dir1CtoCli', Tel1CtoCli='$Tel1CtoCli',Ext1CtoCli='$Ext1CtoCli',Nom2CtoCli='$Nom2CtoCli', Dir2CtoCli='$Dir2CtoCli', Tel2CtoCli='$Tel2CtoCli',Ext2CtoCli='$Ext2CtoCli',Nom3CtoCli='$Nom3CtoCli', Dir3CtoCli='$Dir3CtoCli', Tel3CtoCli='$Tel3CtoCli',Ext3CtoCli='$Ext3CtoCli' WHERE IdEntCli=$cliente";
		$res= mysql_query($query,$conexion); 
		if(!$res)
			$_SESSION['mensajeError'] = "Error ".mysql_error();
		$_SESSION['mensajeInfo'] = "Modificación Registrada!";
		header("Location: ../");
	}

