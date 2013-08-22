<?php
session_start();
if (!ISSET($_SESSION["k_username"])) {
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';
}
if ($_SESSION["k_perfil"] == "USU") {
    header("HTTP/1.0 404 Not Found");
    die();
}
?>
<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<!--
//******************************************************************//
//																	//
// Nombre: Juan Carlos Piña Moreno									//
// Nombre del módulo: Formulario agregar proyectos					//
// Función del módulo: Formulario para recabar los datos necesarios //
//					   y registrar el nuevo proyecto				//
// Fecha: 09/05/2013												//
//																	//
//******************************************************************//
-->
<form action="../proyecto/alta.php" method="post" name="formAddPry" id="formAddPry" target="_top">
    <div align="center" >
        <table width="100%">
            <tr>
                <td align="center" class="encabezado">
                    <label>Programaci&oacute;n y registro de proyectos</label>
                </td>
            </tr>
        </table>
        <div id="proyecto">
            <h3>
                <label>Datos generales del proyecto</label>
            </h3>
            <div>
                <table>
                    <tr>
                        <td colspan="3">                            
                            <label for="ltxt_nomPry">Proyecto:</label>
                            <input type="text" name="ltxt_nomPry" id="ltxt_nomPry" size="70"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" id="listaClientes">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><b>Periodo:</b></label>
                        </td>
                        <td>
                            <label for="ltxt_fecIni">Fecha inicio</label>
                            <input type="fecha" name="ltxt_fecIni" id="ltxt_fecIni" />                                  
                        </td>
                        <td>
                            <label for="ltxt_fecFin">Fecha final</label>
                            <input name="ltxt_fecFin"  id="ltxt_fecFin" type="fecha"/>  
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label for="ltxt_dscPry">Descripcion:</label><br />
                            <textarea name="ltxt_dscPry" id="ltxt_dscPry" cols="80" rows="8" title="Agregue una descripción del proyecto"></textarea>
                        </td>
                    </tr>
                    <td colspan="2">
                        <label for="lint_ctoPry2">Costo total: $</label>
                        <input type="text" name="lint_ctoPry" id="lint_ctoPry" onblur="valida('totalP', 0)" placeholder="Costo sin IVA"/>
                        <input type="checkbox" name="lbool_ivaPry" id="lbool_iva" title="¿Se incluirá IVA?" onchange="valida('totalP', 0)"/>
                        <label for="lbool_iva">IVA</label></td>
                    <td>
                        <label for="lint_pjeUni">Porcentaje:</label>
                        <input type="text" name="lint_pjeUni" title="Porcentaje asignado al intermediario" id="lint_pjeUni" size="3"/>%
                    </td>
                    </tr>
                </table>
            </div>
            <h3>
                <label>Fases o entregables</label>
            </h3>
            <div>
                <table>
                    <tr>
                        <td>No.</td>
                        <td>Concepto</td>
                        <td>Fecha T&eacute;rmino</td>
                    </tr>
                    <tr id="fase0" class="entrada0">
                        <td>1</td>
                        <td><input type="text" id="ltxt_ctoFas0" name="ltxt_ctoFas0" size="60"/></td>
                        <td><input type="fechaEtr" id="ltxt_fecEnt0" name="ltxt_fecEnt0"/></td>
                    </tr>
                    <tr>
                        <td colspan="3" align="right">
                            <input type="button" value="Agregar" onclick="agregaFase(0)"/>
                        </td>
                    </tr>
                </table>
            </div>
            <h3>
                <label>Programaci&oacute;n de pagos</label>
            </h3>
            <div>
                <table width="100%">
                    <tr>
                        <td>No.</td>
                        <td>Concepto</td>
                        <td>(%)</td>
                        <td>Subtotal</td>
                        <td>IVA</td>
                        <td>Monto total</td>
                        <td>Fecha de pago</td>
                    </tr>
                    <tr  class="entrada0" id="pago0">
                        <td>1</td>
                        <td><input type="text" name="ltxt_ctoPag0" id="ltxt_ctoPag0" size="50" /></td>
                        <td><input type="text" name="lint_pjePag0" id="lint_pjePag0" size="8" onblur="valida('totalP', 0)"/></td>
                        <td>$<input type="text" name="lint_subPag0" id="lint_subPag0" size="10" disabled="disabled"/></td>
                        <td>$<input type="text" name="lint_ivaPag0" id="lint_ivaPag0" size="10" disabled="disabled"/></td>
                        <td>$<input type="text" name="lint_totPag0" id="lint_totPag0" size="10" onblur="valida('totalP', 0)"/></td>
                        <td><input type="fechaPag" name="ltxt_fecPag0" id="ltxt_fecPag0" /></td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right">
                            <input type="button" name="botonAddPag" value="Agregar" onclick="agregaPago(0)"/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td align="center">
                            <article id="error"></article>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <table width="100%">
            <tr>
                <td class="encabezado" align="left">
                    <input name="botonEnviar" type="submit" value="Guardar"/>
                </td>
            </tr>
        </table>
    </div>
</form>
