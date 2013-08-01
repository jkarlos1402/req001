<?php
include("../conexion.php");
session_start();
//Obtiene las variables enviadas por el formulario
$IdEntCli = $_POST['IdEntCli'];

//Se crea y se ejecuta la consulta 
$consulta = "SELECT * FROM tblentcli
	 WHERE IdEntCli='$IdEntCli' limit 1";

$resultado = mysql_query("$consulta", $conexion) or die(mysql_error());
if (mysql_num_rows($resultado) == 0) {
    echo '<p>No se encontrarón resultados</p>';
} else {
    echo '
        <form id="formModificaCli" method="post" action="../cliente/modificaCliente.php" target="_top">
        <div id="accordion">
        <h3><label>Datos generales de identificación</label></h3>
        <div>
        <table border="0" width="100%">
        <tr class="encabezado">
        <td>Nombre del Cliente</td>
        <td>Dirección del Cliente</td>
        <td>Telefono del Cliente</td>
        </tr>';
    $row = mysql_fetch_array($resultado);
    echo '<tr>
<td>

       <input name="NomEntCli" type="text" id="NomEntCli" size="50" placeholder="Nombre del cliente" disabled value="' . $row['NomEntCli'] . '" class="requerido" />	
	   <input type="IdEntCli" type="text" style="visibility:hidden; display:none;" name="IdEntCli" value="' . $IdEntCli . '"/>
        
</td>



<td>
<input name="DirEntCli" type="text" id="DirEntCli" size="50" placeholder="Dirección del Cliente"  disabled value="' . $row['DirEntCli'] . '" class="requerido" />	

</td>



<td>

<input name="TelEntCli" type="text" id="TelEntCli" placeholder="Telefono del Cliente"  disabled value=' . $row['TelEntCli'] . ' class="requerido" />
 
</td></tr>';
echo '
</table>
</div>
<h3><label>Datos de contacto 1</label></h3>
<div>
<table border="0" width="100%">
<tr class="encabezado">
<td>Nombre del Cliente</td>
<td>Dirección del Cliente</td>
<td>Telefono del Cliente</td>
</tr>
<tr>
<td>
<input name="Nom1CtoCli" type="text" id="Nom1CtoCli" size="50" placeholder="Nombre del contacto" disabled value="' . $row['Nom1CtoCli'] . '"/>	
</td>
<td>
<input name="Dir1CtoCli" type="text" id="Dir1CtoCli" size="50" placeholder="Dirección del contacto"  disabled value="' . $row['Dir1CtoCli'] . '"/>	
</td>
<td>
<input name="Tel1CtoCli" type="text" id="Tel1CtoCli" size="10" placeholder="Telefono del contacto"  disabled value="' . $row['Tel1CtoCli'] . '"/>
<label>Ext:</label>
<input name="Ext1CtoCli" type="text" id="Ext1CtoCli" size="4" disabled value="' . $row['Ext1CtoCli'] . '"/>
</td></tr>
</table>
</div>
<h3><label>Datos de contacto 2</label></h3>
<div>
<table border="0" width="100%">
<tr class="encabezado">
<td>Nombre del Cliente</td>
<td>Dirección del Cliente</td>
<td>Telefono del Cliente</td>
</tr>
<tr>
<td>
<input name="Nom2CtoCli" type="text" id="Nom2CtoCli" size="50" placeholder="Nombre del contacto" disabled value="' . $row['Nom2CtoCli'] . '"/>	
</td>
<td>
<input name="Dir2CtoCli" type="text" id="Dir2CtoCli" size="50" placeholder="Dirección del contacto"  disabled value="' . $row['Dir2CtoCli'] . '"/>	
</td>
<td>
<input name="Tel2CtoCli" type="text" id="Tel2CtoCli" size="10" placeholder="Telefono del contacto"  disabled value="' . $row['Tel2CtoCli'] . '"/>
<label>Ext:</label>
<input name="Ext2CtoCli" type="text" id="Ext2CtoCli" size="4" disabled value="' . $row['Ext2CtoCli'] . '"/>
</td></tr>
</table>
</div>
<h3><label>Datos de contacto 3</label></h3>
<div>
<table border="0" width="100%">
<tr class="encabezado">
<td>Nombre del Cliente</td>
<td>Dirección del Cliente</td>
<td>Telefono del Cliente</td>
</tr>
<tr>
<td>
<input name="Nom3CtoCli" type="text" id="Nom3CtoCli" size="50" placeholder="Nombre del contacto" disabled value="' . $row['Nom3CtoCli'] . '"/>	
</td>
<td>
<input name="Dir3CtoCli" type="text" id="Dir3CtoCli" size="50" placeholder="Dirección del contacto"  disabled value="' . $row['Dir3CtoCli'] . '"/>	
</td>
<td>
<input name="Tel3CtoCli" type="text" id="Tel3CtoCli" size="10" placeholder="Telefono del contacto"  disabled value="' . $row['Tel3CtoCli'] . '"/>
<label>Ext:</label>
<input name="Ext3CtoCli" type="text" id="Ext3CtoCli" size="4" disabled value="' . $row['Ext3CtoCli'] . '"/>
</td></tr>
</table>
</div>
</div>';
if ($_SESSION['k_perfil'] != "USU") {
    echo'	
<table width="100%">
<tr>
  <td align="right">
  <div id="botonesME">
   <input type="button" value="Modificar" id="Modificar" name="Modificar" onClick="modificaCliente();" />
   <input type="button" value="Eliminar" id="Eliminar" name="Eliminar" onclick="eliminaCliente();">
   </div>
  <div id="botonG" style="visibility:hidden; display:none;">
   <input type="submit" value="Guardar" id="Guardar" name="Guardar">
    <input type="button" value="Eliminar" id="Eliminar" name="Eliminar" onclick="eliminaCliente();">
  </div> 
 </td> 
</tr>
</table>
</form>
<form id="formElimina" method="post" action="../cliente/eliminaCliente.php" target="_top">
<input type="hidden" name="IdEntCli" value="' . $IdEntCli . '" />
</form>';
}
}			                                        
                  
                    
    
