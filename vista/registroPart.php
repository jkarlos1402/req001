<?php 
session_start(); 
if(!ISSET($_SESSION["k_username"])){
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';	
}
if ($_SESSION["k_perfil"] == "USU") {
    header("HTTP/1.0 404 Not Found");
    die();
}
?>
<!--
//******************************************************************//
//																	//
// Nombre: Juan Carlos Piña Moreno									//
// Nombre del módulo: Formulario agregar PoE (Personas o Empresas)	//
// Función del módulo: Formulario para recabar los datos necesarios //
//					   y registrar la nueva PoE						//
// Fecha: 07/05/2013												//
//																	//
//******************************************************************//
-->
<script type="text/javascript" src="../js/participanteFunciones.js"></script>
<form action="../participante/alta.php" method="post" name="formAddPoE" id="formAddPoE" target="_top">
    <table width="100%" border="0">
        <tr class="encabezado">
            <td align="center"><label>Registro de empresas y personas f&iacute;sicas</label></td>
        </tr>
    </table>
    <div id="participante">
        <h3><label>Datos generales de identificaci&oacute;n</label></h3>
        <div align="center">
            <table>
                <tr>
                    <td colspan="4" align="justify" class="campos">
                        <label for="ltxt_nomPoE">Nombre:</label>
                        <input type="text" name="ltxt_nomPoE" id="ltxt_nomPoE" size="50"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="justify" class="campos">
                        <label for="ltxt_dirPoE">Direcci&oacute;n:</label>
                        <input type="text" name="ltxt_dirPoE" id="ltxt_dirPoE" size="50"/>
                    </td>
                </tr>
                <tr>
                    <td align="justify" class="campos">
                        <label for="ltxt_RFCPoE">RFC:</label>
                        <input type="text" name="ltxt_RFCPoE" id="ltxt_RFCPoE" size="13" style="text-transform:uppercase;"/>
                    </td>
                    <td align="justify" class="campos">
                        <label for="ltxt_girPoE">Giro:</label>
                        <input type="text" name="ltxt_girPoE" id="ltxt_girPoE" size="20" class="nulo"/>
                    </td>
                    <td align="justify" class="campos">
                        <label for="ltxt_telPoE">Tel&eacute;fono:</label>
                        <input type="text" name="ltxt_telPoE" id="ltxt_telPoE" size="12"/>
                        <label for="ltxt_extCtoPoE">Ext.</label>
                        <input type="text" id="ltxt_extPoE" name="ltxt_extPoE" size="10" max="9999999999" class="nulo"/>
                    </td>
                    <td id="perfil" class="campos">
                        <script type="text/javascript">cargarPerfiles(-1);</script>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="campos ocultar empresa">
                        <label for="ltxt_nomCtoPoE">Nombre de contacto:</label>
                        <input type="text" id="ltxt_nomCtoPoE" name="ltxt_nomCtoPoE" size="60" maxlength="75"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="campos ocultar empresa">
                        <label for="ltxt_telCtoPoE">Teléfono:</label>
                        <input type="text" id="ltxt_telCtoPoE" name="ltxt_telCtoPoE" size="13" maxlength="12"/> 
                        <label for="ltxt_extCtoPoE">Ext.</label>
                        <input type="text" id="ltxt_extCtoPoE" name="ltxt_extCtoPoE" size="10" max="9999999999" class="nulo"/>
                    </td>
                    <td colspan="2" class="campos ocultar empresa" >
                        <label for="ltxt_emailCtoPoE">E-mail:</label>
                        <input type="text" id="ltxt_emailCtoPoE" name="ltxt_emailCtoPoE" size="30" maxlength="65"/>
                    </td>
                </tr>
            </table>
        </div>
        <h3><label>Datos de cuenta(s) bancaria(s)</label></h3>
        <div align="center">
            <table>
                <tr>
                    <td colspan="4" align="right" class=""><input type="button" id="botonAdd" value="Agregar" onclick="agregarCuenta(1)" /></td>
                </tr>
                <tr  id="cuentas0" class="entrada0">
                    <td id="banco0" class="campos">
                        <script type="text/javascript">cargarBancos("",0);</script>
                    </td>
                    <td class="campos">   
                        <label>Sucursal:
                        <input type="text" id="lint_sucPoE0" size="10"  maxlength="10" name="lint_sucPoE0" /></label>  
                    </td>
                    <td class="campos">  
                        <label>Cuenta:
                        <input type="text" id="lint_ctaPoE0" size="17" maxlength="16" name="lint_ctaPoE0" /></label>
                    </td>
                    <td class="campos">
                        <label>CLABE:
                        <input type="text" id="ltxt_cbePoE0" size="20" maxlength="18" name="ltxt_cbePoE0" /></label>
                    </td>
                    <td id="termina0">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <table width="100%">
        <tr>
            <td class="encabezado">
                <input type="submit" value="Guardar"/>
            </td>
        </tr>
    </table>
</form>
