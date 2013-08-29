<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Obtencíon de proyectos													//
// Función del módulo: Obtiene los proyectos registrados y los coloca en un select para su uso	//
// Fecha: 15/08/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
$query = "select IdEntPoE,NomEntPoE from tblentpoe where EstEntPoE = 1";
$res = mysql_query($query,$conexion);//Se obtienen los clientes de la base de datos
if(isset($_GET['IdEntPry']))
	$IdEntCli = $_GET['IdEntPry'];
else $IdEntCli = "";
$clientes = '<table>
    <tr>
        <td>
            <h3>Selección de reporte por empresa(s) o persona(s) fisica(s)</h3>
        </td>
    </tr>
    <tr>
        <td align="left">
            <label for="lint_idPoE"><b>NOMBRE DE LAS EMPRESAS O PERSONAS FISICAS:</b></label>
            <select id="lint_idPoE" name="lint_idPoE" multiple style="margin-left: 9px;width: 333px;" size="15">';
while($cliente = mysql_fetch_array($res)){//Se forman las opciones del select
	if($IdEntCli == $cliente['IdEntPoE'])
		$selected = "selected";
	else $selected = "";
	$clientes = $clientes.'<option value="'.$cliente['IdEntPoE'].'" '.$selected.'>'.$cliente['NomEntPoE'].'</option>';
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