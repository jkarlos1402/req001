<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Obtencíon de proyectos													//
// Función del módulo: Obtiene los proyectos registrados y los coloca en un select para su uso	//
// Fecha: 15/08/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
$query = "select IdEntCli,NomEntCli from tblentcli where EstEntCli = 1";
$res = mysql_query($query,$conexion);//Se obtienen los clientes de la base de datos
if(isset($_GET['IdEntPry']))
	$IdEntCli = $_GET['IdEntPry'];
else $IdEntCli = "";
$clientes = '<table>
    <tr>
        <td>
            <h3>Selección de reporte por cliete(s)</h3>
        </td>
    </tr>
    <tr>
        <td align="left">
            <label for="lint_idCli"><b>NOMBRE DEL CLIENTE:</b></label>
            <select id="lint_idCli" name="lint_idCli" multiple style="margin-left: 9px;width: 333px;" size="15">';
while($cliente = mysql_fetch_array($res)){//Se forman las opciones del select
	if($IdEntCli == $cliente['IdEntCli'])
		$selected = "selected";
	else $selected = "";
	$clientes = $clientes.'<option value="'.$cliente['IdEntCli'].'" '.$selected.'>'.$cliente['NomEntCli'].'</option>';
}
$clientes = $clientes."</select>
        </td>
    </tr>
    <tr>
        <td align='left'>
            <input type='button' id='btnRep' value='Generar reporte'/>
        </td>
    </tr>
    <tr>
        <td align='center'>
           <div id='mensaje'>
           
           </div>
        </td>
    </tr>
</table>";
echo $clientes;//Regresa el select