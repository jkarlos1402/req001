<?php

include("../conexion.php");
session_start();
	
	
$query = "select * from tblentpry where EstEntPry = 1";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0)
	{
	$perfiles = "<select><option>No hay proyectos registrados</option></select>";	
	}
	else
	{

            $perfiles = '<label>Proyecto: </label><select required name="IdEntPry" id="IdEntPry0" style="width:100%;"><option value="0">Selecciona un proyecto</option>';
            while($renglon = mysql_fetch_array($res)){
                    $perfiles = $perfiles.'<option value="'.$renglon['IdEntPry'].'">'.$renglon['NomEntPry'].'</option>';
                    }
                    $perfiles = $perfiles."</select>";
                }
        echo $perfiles; 

?>
