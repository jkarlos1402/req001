<?php
session_start();
include("../conexion.php");
if(ISSET($_POST['IdEntUsu'])){
	$IdEntUsu = $_POST['IdEntUsu'];
	$query = "select * from tblentusu where IdEntUsu = $IdEntUsu";
	$res = mysql_query($query,$conexion);
	$renglon=mysql_fetch_array($res);
echo 
'<div id="dialog-form"> 
	  <form id="formModUsu" name="formModUsu" method="post" target="_top">
	  <table width="100%" class="ui-corner-all">
	  	<tr>
                    <td colspan="2">
                        <input type="hidden" name="IdEntUsu" id="IdEntUsu" value="'.$renglon['IdEntUsu'].'"/>
                        <label for="NomEntUsu" style="margin-left: 9px;">Nombre:</label>
                        <input type="text" name="NomEntUsu" id="NomEntUsu" value="'.$renglon['NomEntUsu'].'" class="text ui-widget-content ui-corner-all requerido" />
                    </td>
		</tr>
		<tr>
                    <td colspan="2">
                        <label for="PwdEntUsu">Password:</label>
                        <input type="text" name="PwdEntUsu" id="PwdEntUsu" value="'.$renglon['PwdEntUsu'].'" class="text ui-widget-content ui-corner-all requerido" />
                    </td>
		</tr>
		<tr>
                    <td colspan="2">
                        <label style="margin-left: 26px;">Perfil:</label>
                        <select id="PflEntUsu" name="PflEntUsu" class="requerido">
                            <option value=""></option>
                            <option value="ADM">Administrador</option>
                            <option value="USU">Usuario</option>
                        </select>
                    </td>                    
		</tr>
		<tr>
                    <td>
                    <input type="submit" value="Modificar usuario" />
                    </td>
                    <td id="mensajeMod">
                        <div id="errorMod">
                        </div>
                    </td>
		</tr>
	  </table>
	  </form>
	</div>';
}else{
    //Crea y ejecuta la consulta para saber los clientes registrados
    $query = "select * from tblentusu";
    $res = mysql_query($query,$conexion);

    if (mysql_num_rows($res) == 0){ //Si no hay registros envia un aviso 	
        $perfiles = "No hay clientes registrados";	
    }else {// Si si hay registros imprime los resultados	
        echo '<table align="center" width="100%">
                <tr class="encabezado ui-corner-all" align="center">
                    <td>
                        Nombre
                    </td>
                    <td>
                        Password
                    </td>
                    <td>
                        Perfil
                    </td>
                    <td>
                        Acción
                    </td>
                </tr>';
        $i = 0;
        while($renglon = mysql_fetch_array($res)){
            echo'<tr class="entrada'.($i%2).'">
                    <td>
                    '.$renglon['NomEntUsu'].'
                    </td>
                    <td>
                    '.$renglon['PwdEntUsu'].'
                    </td>
                    <td>
                    '.$renglon['PflEntUsu'].'
                    </td>
                    <td>
                        <li class="btnMod" title="Modificar usuario" onclick="modificaUsu('.$renglon['IdEntUsu'].');"></li>';
                if($_SESSION['k_username']!= $renglon['NomEntUsu']){
                    echo'<li class="btnDel" title="Eliminar usuario" onclick="eliminaUsu('.$renglon['IdEntUsu'].',this);"></li>';
                }
                echo'</td>
                </tr>';
            $i++;
        }
    }
    echo '</table>';
}
?>