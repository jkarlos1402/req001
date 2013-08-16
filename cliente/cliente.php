<?php

include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$query = "select * from tblentcli where EstEntCli=1";
$res = mysql_query($query, $conexion) or die(mysql_error());

if (mysql_num_rows($res) == 0) { //Si no hay registros envia un aviso 
    $perfiles = "<select><option>No hay clientes registrados</option></select>";
} else { // Si si hay registros imprime los resultados
    $perfiles = '<select name="clientes" id="clientes" onchange="mostrarInfoCliente(this.value);"><option value="-1">Selecciona un cliente</option>';
    while ($renglon = mysql_fetch_array($res)) {
        $perfiles = $perfiles . '<option value="' . $renglon['IdEntCli'] . '">' . $renglon['NomEntCli'] . '</option>';
    }
    $perfiles = $perfiles . "</select>";
}
echo $perfiles;