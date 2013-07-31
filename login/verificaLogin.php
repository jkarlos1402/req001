<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<?php 
session_start();
include("../conexion.php");
$NomEntUsu = $_POST['NomEntUsu'];
$PwdEntUsu = $_POST['PwdEntUsu'];
$query = "select * from tblentusu where NomEntUsu='$NomEntUsu'";
$res = mysql_query($query,$conexion);
if($row == mysql_fetch_array($res)){
        if($row["PwdEntUsu"] == $PwdEntUsu){
 
            $_SESSION["k_username"] = $row['NomEntUsu'];
			$_SESSION["k_perfil"]=$row['PflEntUsu'];
           
            //echo 'Bienvenido'.$_SESSION['k_username'].' <p>';
            //echo '<a href="index.php">Index</a></p>';
           
            //Elimina el siguiente comentario si quieres que re-dirigir autom&aacute;ticamente a index.php
           
            //Ingreso exitoso, ahora sera dirigido a la pagina principal.
            echo '<SCRIPT LANGUAGE="javascript">
            location.href = "../index.php";
            </SCRIPT>';
 
        }else{
            echo '<div class="ui-widget">
            	<div class="ui-state-error ui-corner-all" style="width:60%;">
                <p>
                <span class="ui-icon ui-icon-alert" style="float: left;"></span>
                <strong>Error:</strong>
                Password incorrecto
                </p>
                </div>
            </div>
			
			';
        }
    }else{
        echo '<div class="ui-widget">
            	<div class="ui-state-error ui-corner-all" style="width:60%;">
                <p>
                <span class="ui-icon ui-icon-alert" style="float: left;"></span>
                <strong>Error:</strong>
                Nombre de usuario incorrecto
                </p>
                </div>
            </div>';
    }
    mysql_free_result($res);

mysql_close();

?>