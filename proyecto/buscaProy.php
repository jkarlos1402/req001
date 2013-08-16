<?php
session_start();
require_once '../conexion.php';
$idProy = $_POST['IdEntPry'];
$query = "select * from tblentpry where IdEntPry = $idProy and EstEntPry = 1 limit 1";
$res = mysql_query($query,$conexion);
$proyecto = mysql_fetch_array($res);
if($proyecto['IVAEntPry'] != 0){
    $checked = "checked";
}else{ 
    $checked = "";
}
$ltxt_fecIniPry = date('d-m-Y',strtotime($proyecto['FecIniPry']));
$ltxt_fecTerPry = date('d-m-Y',strtotime($proyecto['FecTerPry']));
$formulario = '<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<form action="../proyecto/update.php" method="post" name="formSetPry" id="formSetPry" target="_top">
    <div align="center" >
        <table width="100%">
            <tr>
                <td align="center" class="encabezado">
                    <label>Actualización de proyectos</label>
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
                            <input type="text" name="ltxt_nomPry" id="ltxt_nomPry" size="70" value="'.$proyecto['NomEntPry'].'"/>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" id="listaClientes">
                            <script type="text/javascript">cargarClientes('.$proyecto['IdEntCli'].');</script>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label><b>Periodo:</b></label>
                        </td>
                        <td>
                            <label for="ltxt_fecIni">Fecha inicio</label>
                            <input type="fecha" name="ltxt_fecIni" id="ltxt_fecIni"/>
                            <script type="text/javascript">$("#ltxt_fecIni").datepicker("setDate","'.$ltxt_fecIniPry.'");</script> 
                        </td>
                        <td>
                            <label for="ltxt_fecFin">Fecha final</label>
                            <input name="ltxt_fecFin"  id="ltxt_fecFin" type="fecha"/>
                            <script type="text/javascript">
                                $("#ltxt_fecFin").datepicker("option","minDate", new Date($("#ltxt_fecIni").datepicker("getDate")));
                                $("#ltxt_fecFin").datepicker("setDate","'.$ltxt_fecTerPry.'");
                            </script>  
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <label for="ltxt_dscPry">Descripcion:</label><br />
                            <textarea name="ltxt_dscPry" id="ltxt_dscPry" cols="80" rows="8" title="Agregue una descripción del proyecto">'.$proyecto['DscEntPry'].'</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="lint_ctoPry2">Costo total: $</label>
                            <input type="text" name="lint_ctoPry" id="lint_ctoPry" placeholder="Costo sin IVA" value="'.$proyecto['PreEntPry'].'" disabled="disabled"/>
                            <input type="checkbox" name="lbool_ivaPry" id="lbool_iva" title="¿Se incluirá IVA?" '.$checked.' disabled="disabled"/>
                            <label for="lbool_iva">IVA</label>
                        </td>
                        <td>
                            <label for="lint_pjeUni">Porcentaje:</label>
                            <input type="text" name="lint_pjeUni" title="Porcentaje asignado a la UAEMéx" id="lint_pjeUni" value="'.$proyecto['PjeEntPry'].'" size="3"/>%
                        </td>
                    </tr>
                </table>
            </div>
            <h3><label>Fases o entregables</label></h3>
            <div>
                <table>
                    <tr>
                        <td>No.</td>
                        <td>Concepto</td>
                        <td>Fecha T&eacute;rmino</td>
                    </tr>';
$query = "select * from tblentetr where IdEntPry = $idProy";
$res = mysql_query($query,$conexion);
$contFase = 0;
while($fase = mysql_fetch_array($res)){
    $ltxt_fecPrgEtr = date('d-m-Y',strtotime($fase['FecPrgEtr']));
    $formulario .= '<tr id="fase'.$contFase.'" class="entrada'.($contFase%2).'">
                        <td>'.($contFase+1).'
                            <input type="hidden" id="IdEntEtr'.$contFase.'" name="IdEntEtr'.$contFase.'" value="'.$fase['IdEntEtr'].'"/>
                        </td>
                        <td>
                            <input type="text" id="ltxt_ctoFas'.$contFase.'" name="ltxt_ctoFas'.$contFase.'" size="60" value="'.$fase['CtoEntEtr'].'"/>
                        </td>
                        <td>
                            <input type="fechaEtr" id="ltxt_fecEnt'.$contFase.'" name="ltxt_fecEnt'.$contFase.'" value="'.$fase['FecPrgEtr'].'"/>
                            <script type="text/javascript">
                                $("#ltxt_fecEnt'.$contFase.'").datepicker("option","maxDate", new Date($("#ltxt_fecFin").datepicker("getDate")));';
                                if($contFase >0){
                                        $formulario.='$("#ltxt_fecEnt'.$contFase.'").datepicker("option","minDate", new Date($("#ltxt_fecEnt'.($contFase-1).'").datepicker("getDate")));';
                                }else{
                                        $formulario.='$("#ltxt_fecEnt'.$contFase.'").datepicker("option","minDate", new Date($("#ltxt_fecIni").datepicker("getDate")));';
                                }
                                $formulario.= '$("#ltxt_fecEnt'.$contFase.'").datepicker("setDate","'.$ltxt_fecPrgEtr.'");
                            </script>
                        </td>';
    if($contFase > 1){
        $formulario .= '    <script type="text/javascript">$("#boton'.($contFase-1).'").html("");</script>';
    }
    if($contFase > 0){
        $formulario .= '    <td id="boton'.$contFase.'"><a href="#" id="quitaFase" style="height: 20px;"></a></td>';
        $formulario .= '    <script type="text/javascript">$("#quitaFase").on("click",function(){quitarFase('.$contFase.');});</script>';	
    }
    $formulario .='     </tr>
                        <script type="text/javascript">
                            $("#quitaFase").button({icons: {primary: "ui-icon-trash"}});
                            $("input[type=fechaEtr]").change(function(e) {
                                for(var i = 1;i <= '.$contFase.';i++){
                                        $("#ltxt_fecEnt"+i).datepicker("option", "minDate", new Date($("#ltxt_fecEnt"+(i-1)).datepicker("getDate")));
                                }
                            });
                        </script>';
    $contFase++;
}
$formulario .= '        <tr>
                            <td colspan="3" align="right">
                                <input type="button" value="Agregar" onclick="agregaFase('.($contFase-1).')"/>
                            </td>
                        </tr>
                    </table>
                </div>
                <h3><label>Programaci&oacute;n de pagos</label></h3>
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
                        </tr>';
$query = "select * from tblentpag where IdEntPry = $idProy order by -FecEntPagRal DESC";
$res = mysql_query($query);
$contPago = 0;
$numPagos=mysql_num_rows($res);
while($pago = mysql_fetch_array($res)){
    if($pago['FecEntPagRal'] != ""){
        $PorEntPag = $pago['PorEntPagRal'];
        $disabled = 'disabled="disabled"';
    }else{
        $PorEntPag = $pago['PorEntPagPrg'];
        $disabled = '';
    }
    if($pago['FecEntPagRal']!=""){
        $fechaPago = $pago['FecEntPagRal'];
    }else{
        $fechaPago = $pago['FecEntPagPrg'];
    }
    $ltxt_fecEntPag = date('d-m-Y',strtotime($fechaPago));
    $formulario .='     <tr  class="entrada'.($contPago%2).'" id="pago'.$contPago.'">
                            <td>'.
                                ($contPago+1).'<input type="hidden" id="IdEntPag'.$contPago.'" name="IdEntPag'.$contPago.'" value="'.$pago['IdEntPag'].'" '.$disabled.'/>
                            </td>
                            <td>
                                <input type="text" name="ltxt_ctoPag'.$contPago.'" id="ltxt_ctoPag'.$contPago.'" size="50"  value="'.$pago['CtoEntPag'].'" '.$disabled.'/>
                            </td>
                            <td>
                                <input type="text" name="lint_pjePag'.$contPago.'" id="lint_pjePag'.$contPago.'" size="8" onblur="valida('."'pje',".$numPagos.');" value="'.$PorEntPag.'" '.$disabled.'/>
                            </td>
                            <td>
                                $<input type="text" name="lint_subPag'.$contPago.'" id="lint_subPag'.$contPago.'" size="10" value="'.$pago['MonEntPagRal'].'" '.$disabled.'  disabled="disabled"/>
                            </td>
                            <td>
                                $<input type="text" name="lint_ivaPag'.$contPago.'" id="lint_ivaPag'.$contPago.'" size="10" disabled="disabled"/>
                            </td>
                            <td>
                                $<input type="text" name="lint_totPag'.$contPago.'" id="lint_totPag'.$contPago.'" size="10" onblur="valida('."'totalP',".$numPagos.');" '.$disabled.'/>
                            </td>
                            <td>
                                <input type="fechaPag" name="ltxt_fecPag'.$contPago.'" id="ltxt_fecPag'.$contPago.'" '.$disabled.'/>
                                <script type="text/javascript">
                                    $("#ltxt_fecPag'.$contPago.'").datepicker("setDate","'.$ltxt_fecEntPag.'");
                                </script>
                            </td>';
    if($contPago>0 && $pago['FecEntPagRal'] == ""){
        $formulario.='      <script type="text/javascript">$("#botonP'.($contPago-1).'").html("");</script><td id="botonP'.$contPago.'"><a href="#" id="quitaPago" style="height: 20px;"></a></td><script type="text/javascript">$("#quitaPago").button({icons: {primary: "ui-icon-trash"}});
                                $("#quitaPago").on("click",function(click,ui){quitarPago('.($numPagos-1).');});
                            </script>';
    }
    $formulario.='      </tr>';
    $contPago++;
}
$formulario .= '        <script type="text/javascript">
                            $("#lbool_iva").on("change",function(change,ui){valida("pje",'.($numPagos-1).');});
                            $("#lint_ctoPry").on("blur",function(blur,ui){valida("pje",'.($numPagos-1).');});
                            valida("pje",'.($numPagos-1).');
                        </script>
                        <tr>
                            <td colspan="7" align="right">
                                <input type="button" name="botonAddPag" value="Agregar" onclick="agregaPago('.($numPagos-1).')"/>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center">
                                <article id ="info"></article>
                                <article id="error"></article>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <table width="100%">
                <tr>
                    <td class="encabezado" align="left">
                        <input name="botonEnviar" type="submit" value="Guardar" title="Guarda los cambios"/>
                    </td>
                    <td class="encabezado" align="right">
                        <input name="botonBorrar" type="button" value="Eliminar" onclick="eliminarProyecto();" title="Elimina lógicamente"/>
                    </td>
                </tr>
            </table>
        </div>
        <input type="hidden" name="IdEntPry" value="'.$idProy.'"/>
        <input type="hidden" id="totFases" name="totFases" value="'.$contFase.'"/>
        <input type="hidden" id="totPagos" name="totPagos" value="'.$contPago.'"/>
    </form>
    <form id="formElimina" method="post" target="_top" action="../proyecto/eliminaProyecto.php">
            <input type="hidden" name="IdEntPry" value="'.$idProy.'"/>
    </form>';

echo $formulario;