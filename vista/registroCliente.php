<?php
session_start();

if(!ISSET($_SESSION["k_username"])){
	echo '<SCRIPT LANGUAGE="javascript">
            location.href = "../vista/login.php";
            </SCRIPT>';	
}
if($_SESSION["k_perfil"]=="USU"){
header("HTTP/1.0 404 Not Found");
die();
}
?>

<!DOCTYPE html>
<hmtl lang="es">
<head>
<meta charset="utf-8">
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
</head>
<body>
	<form class="form" name="Reg_Cli" id="Reg_Cli" method="POST" action="../cliente/altaCliente.php" target="_top">
    <div align="center" id="div_cra"> 
	<table width="100%">
    <tr>
    	<td align="center">
        <h3><label>REGISTRO DE CLIENTES</label></h3>	
        </td>
    </tr>
    </table>
    <div id="accordion">
    	<h3><label>Datos generales de identificación</label></h3>
        <div>
        	<table>
            <tr class="campos">
                <td >Nombre del cliente:</td>
                <td >
                <input name="NomEntCli" type="text" id="NomEntCli" value="" size="50" placeholder="Nombre del cliente" class="requerido">
               </td>
            </tr>
            <tr>
                <td>  Dirección:</td>
                <td>
                  <input name="DirEntCli" type="text" id="DirEntCli" placeholder="Dirección del Cliente" size="50" maxlength="75" class="requerido"/>
                </td>
            </tr>
            <tr>
                <td>Teléfono: </td>
                <td>
                <input name="TelEntCli" type="text" id="TelEntCli" placeholder="Telefono del Cliente" class="requerido" />
               </td>
            </tr>
            </table>
           <!--
           	REALIZAR EL ACORDEON E INSERTAR LOS NUEVOS REGISTROS EN LA BASE DE DATOS
           --> 
        </div>
        <h3><label>Información de contacto 1</label></h3>
        <div>
        <table>
        <tr>
            <td>Nombre del Contacto: </td>
            <td>
            <input name="Nom1CtoCli" type="text" id="Nom1CtoCli" placeholder="Nombre del Contacto " />
           </td>
        </tr>
        <tr>
            <td> Dirección del Contacto:</td>
            <td>
              <input name="Dir1CtoCli" type="text" id="Dir1CtoCli" placeholder="Dirección del Contacto" size="50" maxlength="75" />
            </td>
        </tr>
        <tr>
            <td>Teléfono del Contacto: </td>
            <td>
            <input name="Tel1CtoCli" type="text" id="Tel1CtoCli" placeholder="Telefono del Contacto" />
           </td>
           <td><label>Ext:</label><input type="text" name="Ext1CtoCli"></td>
        </tr>
        </table>
        </div>
        <h3><label>Información de contacto 2</label></h3>
        <div>
        <table>
        <tr>
            <td>Nombre del Contacto: </td>
            <td>
            <input name="Nom2CtoCli" type="text" id="Nom2CtoCli" placeholder="Nombre del Contacto " />
           </td>
        </tr>
        <tr>
            <td> Dirección del Contacto:</td>
            <td>
              <input name="Dir2CtoCli" type="text" id="Dir2CtoCli" placeholder="Dirección del Contacto" size="50" maxlength="75" />
            </td>
        </tr>
        <tr>
            <td>Teléfono del Contacto: </td>
            <td>
            <input name="Tel2CtoCli" type="text" id="Tel2CtoCli" placeholder="Telefono del Contacto" />
           </td>
            <td><label>Ext:</label><input type="text" name="Ext2CtoCli"></td>
        </tr>
        </table>
        </div>
        <h3><label>Información de contacto 3</label></h3>
        <div>
        <table>
        <tr>
            <td>Nombre del Contacto: </td>
            <td>
            <input name="Nom3CtoCli" type="text" id="Nom3CtoCli" placeholder="Nombre del Contacto " />
           </td>
        </tr>
        <tr>
            <td> Dirección del Contacto:</td>
            <td>
              <input name="Dir3CtoCli" type="text" id="Dir3CtoCli" placeholder="Dirección del Contacto" size="50" maxlength="75" />
            </td>
        </tr>
        <tr>
            <td>Teléfono del Contacto: </td>
            <td>
            <input name="Tel3CtoCli" type="text" id="Tel3CtoCli" placeholder="Telefono del Contacto" />
           </td>
            <td><label>Ext:</label><input type="text" name="Ext3CtoCli"></td>
        </tr>
        </table>
        </div>
    </div>
    <table>
    <tr>
      <td colspan="2" align="right" > <input type="submit" value="Enviar" ></td>
    </tr>
    </table>
</form>
</body>
</html>