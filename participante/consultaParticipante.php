<?php

//**********************************************************************************************//
// Nombre: Regino Tabares																		//
// Nombre del módulo: Consulta de Participantes 												//
// Función del módulo: Obtiene los Participantes registrados y sus datos						//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
$cont = 0;
session_start();


//Consulta 1 Para obtener los datos de la empresa
$IdEntPoE = $_POST['PoE'];
$consulta = "SELECT * FROM tblentpoe
	 WHERE IdEntPoE='$IdEntPoE' and EstEntPoE = 1 limit 1";

//Consulta 2 para obtener los resultados de sus cuentas bancarias y los datos del banco y sucursal 
$consulta2 = "SELECT tblentcue.IdEntCue IdEntCue, tblentcue.NumEntCue NumEntCue, tblentcue.ClaEntCue ClaEntCue, tblentcue.IdEntSuc IdEntSuc, tblentsuc.SucEntSuc SucEntSuc, tblentsuc.IdEntBan IdEntBan, tblentban.NomEntBan NomEntBan
	FROM tblentban, tblentcue, tblentsuc
	WHERE tblentcue.IdEntSuc = tblentsuc.IdEntSuc
	AND tblentsuc.IdEntBan = tblentban.IdEntBan
	AND tblentcue.IdEntPoE =$IdEntPoE";
$resultado = mysql_query("$consulta", $conexion) or die(mysql_error());
$poe = mysql_fetch_array($resultado);
$resultado2 = mysql_query("$consulta2", $conexion) or die(mysql_error());
if (mysql_num_rows($resultado) == 0) {
    echo '<p>No se encontrarón resultados</p>';
}else{
    echo'<script type="text/javascript" src="../js/participanteFunciones.js"></script>
    <form action="../participante/modificaParticipante.php" method="post" name="formAddPoE" id="formAddPoE" target="_top">
        <table width="100%" border="0">
            <tr class="encabezado">
                <td align="center"><label>Modificación de empresas y personas f&iacute;sicas</label></td>
            </tr>
        </table>
        <div id="participante">
            <h3><label>Datos generales de identificaci&oacute;n</label></h3>
            <div align="center">
                <table>
                    <tr>
                        <td colspan="4" align="justify" class="campos">
                            <input type="hidden" id="IdEntPoE" name="IdEntPoE" value="' . $poe['IdEntPoE'] . '"/>
                            <label for="ltxt_nomPoE">Nombre:</label>
                            <input type="text" name="ltxt_nomPoE" id="ltxt_nomPoE" size="50" value="' . $poe['NomEntPoE'] . '" disabled="disabled"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" align="justify" class="campos">
                            <label for="ltxt_dirPoE">Direcci&oacute;n:</label>
                            <input type="text" name="ltxt_dirPoE" id="ltxt_dirPoE" size="50" value="' . $poe['DirEntPoE'] . '" disabled="disabled"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="justify" class="campos">
                            <label for="ltxt_RFCPoE">RFC:</label>
                            <input type="text" name="ltxt_RFCPoE" id="ltxt_RFCPoE" size="13" style="text-transform:uppercase;" value="' . $poe['RFCEntPoE'] . '" disabled="disabled"/>
                        </td>
                        <td align="justify" class="campos">
                            <label for="ltxt_girPoE">Giro:</label>
                            <input type="text" name="ltxt_girPoE" id="ltxt_girPoE" size="20" class="nulo" value="' . $poe['GroEntPoE'] . '" disabled="disabled"/>
                        </td>
                        <td align="justify" class="campos">
                            <label for="ltxt_telPoE">Tel&eacute;fono:</label>
                            <input type="text" name="ltxt_telPoE" id="ltxt_telPoE" size="12" value="' . $poe['TelEntPoE'] . '" disabled="disabled"/>
                            <label for="ltxt_extCtoPoE">Ext.</label>
                            <input type="text" id="ltxt_extPoE" name="ltxt_extPoE" size="10" max="9999999999" class="nulo" value="' . $poe['ExtEntPoE'] . '" disabled="disabled"/>
                        </td>
                        <td id="perfil" class="campos">
                            <script type="text/javascript">
                                  cargarPerfiles(' . $poe['IdEntPfl'] . ');
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="campos ocultar empresa">
                            <label for="ltxt_nomCtoPoE">Nombre de contacto:</label>
                            <input type="text" id="ltxt_nomCtoPoE" name="ltxt_nomCtoPoE" size="60" maxlength="75" value="' . $poe['NomCtoPoE'] . '" disabled="disabled"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="campos ocultar empresa">
                            <label for="ltxt_telCtoPoE">Teléfono:</label>
                            <input type="text" id="ltxt_telCtoPoE" name="ltxt_telCtoPoE" size="13" maxlength="12" value="' . $poe['TelCtoPoE'] . '" disabled="disabled"/> 
                            <label for="ltxt_extCtoPoE">Ext.</label>
                            <input type="text" id="ltxt_extCtoPoE" name="ltxt_extCtoPoE" size="10" max="9999999999" class="nulo" value="' . $poe['ExtCtoPoE'] . '" disabled="disabled"/>
                        </td>
                            <td colspan="2" class="campos ocultar empresa" >
                            <label for="ltxt_emailCtoPoE">E-mail:</label>
                            <input type="text" id="ltxt_emailCtoPoE" name="ltxt_emailCtoPoE" size="30" maxlength="65" value="' . $poe['EmailCtoPoE'] . '" disabled="disabled"/>
                        </td>
                    </tr>
                </table>
            </div>
            <h3><label>Datos de cuenta(s) bancaria(s)</label></h3>
            <div align="center">
                <table>
                    <tr>
                        <td colspan="4" align="right" class=""><input type="button" id="botonAdd" value="Agregar" onclick="agregarCuenta(' . mysql_num_rows($resultado2) . ')" style="visibility: hidden; display: none;"/></td>
                    </tr>';
    $i = 0;
    while ($cuenta = mysql_fetch_array($resultado2)) {
        echo '      <tr  id="cuentas' . $i . '" class="entrada' . ($i % 2) . '">
                        <td id="banco' . $i . '" class="campos">
                            <script type="text/javascript">cargarBancos(' . $cuenta['IdEntBan'] . ',' . $i . ');</script>
                        </td>
                        <td class="campos"> 
                            <input type="hidden" id="IdEntCue' . $i . '" name="IdEntCue' . $i . '" value="' . $cuenta['IdEntCue'] . '"/>  
                            <label>Sucursal:
                            <input type="hidden" id="IdEntSuc' . $i . '" name="IdEntSuc' . $i . '" value="' . $cuenta['IdEntSuc'] . '" />
                            <input type="text" id="lint_sucPoE' . $i . '" size="10"  maxlength="10" name="lint_sucPoE' . $i . '" value="' . $cuenta['SucEntSuc'] . '" disabled="disabled"/></label>  
                        </td>
                        <td class="campos">  
                            <label>Cuenta:
                            <input type="text" id="lint_ctaPoE' . $i . '" size="17" maxlength="16" name="lint_ctaPoE' . $i . '" value="' . $cuenta['NumEntCue'] . '" disabled="disabled"/></label>
                        </td>
                        <td class="campos">
                            <label>CLABE:
                            <input type="text" id="ltxt_cbePoE' . $i . '" size="20" maxlength="18" name="ltxt_cbePoE' . $i . '" value="' . $cuenta['ClaEntCue'] . '" disabled="disabled"/></label>
                        </td>
                        <td id="termina' . $i . '" style="visibility: hidden; display: none;">';
        if ($i > 1)
            echo '          <script type="text/javascript">$("#termina' . ($i - 1) . '").html("");</script>';
        if ($i > 0)
            echo '          <a href="#" id="quitaCuenta">Eliminar</a>
                            <script type="text/javascript">
                                $("#quitaCuenta").button({icons: {primary: "ui-icon-trash"}});
                                $("#quitaCuenta").on("click",function(click,ui){quitarCuenta(' . $i . ');});
                            </script>';
        echo '          </td>
                    </tr>';
        $i++;
    }
    echo '      </table>
   </div>
   </div>';
    if ($_SESSION['k_perfil'] != "USU") {
        echo'   
   <table width="100%">
   <tr>
   <td class="encabezado">
   <input type="hidden" name="totalCuentas" id="totalCuentas" value="' . $i . '"/>
   <input type="button" value="Modificar" id="modificarPoE" onclick="habilitaCampos();">
   <input type="button" value="Eliminar" id="eliminarPoE" onclick="eliminaPoE();">
   <input type="submit" value="Guardar" style="visibility:hidden; display:none;"/>
   </td>
   </tr>
   </table>';
    }
    echo'   
</form>
<form id="formElimina" method="post" action="../participante/elimina.php" target="_top">
<input type="hidden" name="IdEntPoE" value="' . $IdEntPoE . '" />
</form>
';
}
?>                    



