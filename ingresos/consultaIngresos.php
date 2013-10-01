<?php
 //**********************************************************************************************//
// Nombre: Regino Tabares																		//
// Nombre del módulo: Consulta de Proyectos 												//
// Función del módulo: Obtiene los Proyectos registrados y sus datos						//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
 include("../conexion.php");

session_start();
//Consulta 1 Para obtener los datos de la empresa
$IdEntPry=$_POST['IdEntPry'];
$consulta="SELECT * 
    FROM tblentpag, tblentest
    WHERE tblentpag.IdEntEst = tblentest.IdEntEst
    AND tblentpag.IdEntPry =$IdEntPry ORDER BY tblentpag.IdEntEst DESC";

$consulta2= "SELECT *
    FROM tblentcli, tblentpry where tblentcli.IdEntCli = tblentpry.IdEntCli and IdEntPry=$IdEntPry";
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());
$resultadocliente=mysql_query("$consulta2",$conexion) or die (mysql_error());
$color;
$total=0;;
$totalporc=0;
$totalporcral=0;
$alerta='false';
$suma=0;
$pagoi=0;
$cuenta=0;
$cuentavalidar=0;


 //******************************************************************************************************//
// Nombre: Regino Tabares																				//
// Nombre del módulo: diasEntreFechas 																	 //
// Función del módulo: Obtener la diferencia de dias entre la fecha programada y la actual para          //
//						determinar el estatus del pago.
//						Si la diferencia es mayor a 5 no se hace cambio al estatus						//
//						Si la diferencia es menor a 3 se actualiza el estado a 3 -> "Próximo a ejecutar" //
//						Si la diferencia es negativa se actualiza al estado a 4 -> "Desfazado"			//		
// Fecha: 13/05/2013																			//
//**********************************************************************************************//	
function diasEntreFechas($fechainicio, $fechafin,$id){
    if(((strtotime($fechafin)-strtotime($fechainicio))/86400)>3){
        $qact="UPDATE tblentpag set IdEntEst=(select IdEntEst from tblentest where DscEntEst like 'PLANEADO') where IdEntPag=$id";
        //echo "<br>".$qact;
        $ejec=mysql_query("$qact");
    }
    if(((strtotime($fechafin)-strtotime($fechainicio))/86400)<=3){
        $qact="UPDATE tblentpag set IdEntEst=(select IdEntEst from tblentest where DscEntEst like 'PROXIMO A EJECUTAR') where IdEntPag=$id";
        //echo "<br>".$qact;
        $ejec=mysql_query("$qact");
    }
    if(((strtotime($fechafin)-strtotime($fechainicio))/86400)<0){
        $qact="UPDATE tblentpag set IdEntEst=(select IdEntEst from tblentest where DscEntEst like 'DESFASADO') where IdEntPag=$id";
        //echo "<br>".$qact;
        $ejec=mysql_query("$qact");
    }
}

 //******************************************************************************************************//
// Nombre: Regino Tabares																				//
// Nombre del módulo: colorEstatus																	 //
// Función del módulo: Obtiene el estado de pago y dependiendo de el se asigna un color para el semáforo //
// Fecha: 13/05/2013																			//
//**********************************************************************************************//		
function colorEstatus($id){	
    $query = "select DscEntEst from tblentest where IdEntEst = $id";
    $res = mysql_query($query);
    while($fila = mysql_fetch_array($res)){
        $estado = $fila['DscEntEst'];
    }
    if($estado=="EJECUTADO"){
        //$color="bgcolor='#0080FF'";
        $color="bgcolor='#5EBA67'"; // VERDE
    }
    if($estado=="PLANEADO"){
        $color="bgcolor='#5DA1E5'"; // AZUL
        //$color="bgcolor='#00D615'";
    }
    if($estado=="PROXIMO A EJECUTAR"){
        $color="bgcolor='#DFD96B'";
    }
    if($estado=="DESFASADO"){
        $color="bgcolor='#DA3E3E'";
    }
    return $color;	
}

while($renglon = mysql_fetch_array($resultadocliente)){
    if($renglon['IVAEntPry']==1){
        $auxiva=1;	
        $iva = $renglon['PreEntPry'] * .16;
        $totalpry=$renglon['PreEntPry']+$iva;
        $totalpry = round($totalpry,2);
    }
    else{
        $auxiva=0;
        $iva=0;
        $totalpry=$renglon['PreEntPry']+$iva;
        $totalpry = round($totalpry,2);
    }
    echo '<label>Cliente: <b>'.$renglon['NomEntCli'].'</b></label>';
   $factor=$renglon['PjeEntPry'];
}

echo '<form name="formulario" id="formulario" method="post" action="../ingresos/registroDispersion.php">
	<table CellSpacing="3">
            <tr class="encabezado">
                <td colspan="14"><h2 align="center">ESTATUS DE PAGOS</h2></td>
                <input type="hidden" name="IdEntPry" id="IdEntPry" value="'.$IdEntPry.'"/>
            </tr>
            <tr align="center">
                <td colspan="2"></td><td>No.</td><td>Concepto</td><td>Porcentaje (%)<br>Programado</td><td>Monto $<br>Programado</td><td>Fecha Programada</td><td>Porcentaje (%)<br>Pagado</td><td>Monto Pagado $</td><td>Fecha de cobro</td><td>Origen de Cobro</td><td>Programar dispersión</td><td>Consultar</td>
            </tr>';
$cont = 1;
while($renglon = mysql_fetch_array($resultado)){		
    if($renglon['FecEntPagRal'] == Null){
        diasEntreFechas(date("d-m-Y"),$renglon['FecEntPagPrg'],$renglon['IdEntPag']);
    }
}
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());					
while($renglon = mysql_fetch_array($resultado)){						
    echo '  <tr align="center">
                <td></td>
                <td><input type="checkbox" id="pago'.$cont.'" name="pago['.$cont.']" value="'.$renglon['IdEntPag'].'"></td>
                <td>'.$cont.'</td>
                <td>'.$renglon['CtoEntPag'].'</td>
                <td>'.round($renglon['PorEntPagPrg'],3).'%</td>';
    if($auxiva==1){											//COMPRUEBA SI HAY IVA EN EL PROJECTO
        //$iva =$renglon['MonEntPagPrg'] * .16;				// SI LO HAY HACE EL CÁLCULO PARA SACAR EL IVA
        $total =$total +($renglon['MonEntPagPrg']); 	// LO SUMA AL TOTAL
        $totalporc = $totalporc + $renglon['PorEntPagPrg'];

        //$pagoi=$renglon['MonEntPagPrg']+$iva; 
        //$pagoi=round($pagoi,2);
        echo '  <td>$'.$renglon['MonEntPagPrg'].'</td>';			//IMPRIME EL VALOR CON IVA
    }else{
        //$pagoi=$renglon['MonEntPagPrg'];
        //$pagoi=round($pagoi,2);
        echo '  <td>$'.$renglon['MonEntPagPrg'].'</td>';			
    }														
    echo '      <td>'.date('d-m-Y',strtotime($renglon['FecEntPagPrg'])).'</td>
                <td id="porreal'.$cont.'">';
    $totalporcral = $totalporcral+$renglon['PorEntPagRal'];
    if($renglon['FecEntPagRal'] == Null){
    }else{
        echo round($renglon['PorEntPagRal'],3)."%";
    }
    echo '      </td>
                <td id="montoreal'.$cont.'">$';
    if($renglon['FecEntPagRal'] == Null){
            $cuentavalidar=$cuentavalidar+$pagoi;
    }else{
        echo $renglon['MonEntPagRal'];
        $cuenta=$cuenta+round($renglon['MonEntPagRal'],2);
        $cuentavalidar=$cuentavalidar+$cuenta;
        if(($renglon['MonEntPagRal']!=$renglon['MonEntPagPrg'])&&$renglon['MonEntPagRal']!=null){
            $alerta='true';
        }else{
            if ($alerta!='true')
            $alerta='false';	
        }
    }
    echo '      </td>
                <td id="est'.$cont.'" '.colorEstatus($renglon['IdEntEst']).'>
                    <div id="div'.$cont.'">
                        <table width="100%">
                            <tr align="center">';
    if($renglon['FecEntPagRal'] == Null){
        echo '                  <td><input type="button" value="Registrar Pago" id="registra'.$cont.'" name="registra'.$cont.'" onclick="registraPago('.$renglon['IdEntPag'].','.$cont.','.$renglon['MonEntPagPrg'].')"></td>';								
    //echo '<input type="fecha" name="date'.$cont.'" id="date'.$cont.'" placeholder="Ingresa fecha" onchange="actualizarFecha('.$renglon['IdEntPag'].',this.value,'.$cont.');"/>';	
    }else{
        echo '                  <td id="fec'.$cont.'">'.date('d-m-Y',strtotime($renglon['FecEntPagRal'])).'</td>
                                <td><img src="../vista/images/config.gif" title="Modificar Fecha" onclick="verificaPass('.$renglon['IdEntPag'].','.$cont.');"  width="25" align="right"></td>';
    }
    echo '                  </tr>
                        </table>
                    </div>
                    <div id="divoculto'.$cont.'" style="visibility:hidden; display:none;">
                        Fecha Registrada
                    </div>		
                </td>
                <td>Cliente</td>
                <td><input type="button" onclick="programaDisp('.$cont.')" value="Programar"></td>
                <td><input type="button" onclick="consultaDisp('.$renglon['IdEntPag'].','.$cont.')" value="Consultar"></td>
            </tr>';
    $cont++;	
}
echo '      <tr align="center">
                <td></td>
                <td></td>
                <td></td>
                <td>Factor Intermediario</td>
                <td>'.(int)$factor.'%</td>
            </tr>
            <tr align="center" class="registro">
                <td colspan="4"></td>
                <td>Total<br>Proyecto</td>
                <td>$'.$totalpry.'</td>
                <td><input type="text" style="visibility:hidden; display:none;" name="renglones" id="renglones" value="'.$cont.'">
                        Total<br>Pagado</td>
                <td id="porcreal">'.round($totalporcral,3).'%</td>
                <td id="totreal">$'.round($cuenta,2).'</td>
                <td><input type="button" onclick="programaSel()" value="Programar Seleccionados"></td>
                <td><input type="button" onclick="consultaSel('.$cont.');" value="Consultar Seleccionados"></td>
                <td><input type="button" onclick="selTodos('.$cont.',1)" value="Programar Todos"></td>
                <td><input type="button" onclick="selTodos('.$cont.',2)" value="Consultar Todos"></td>
            </tr>
            <tr>
                <td colspan="5">
                    <article id="alerta"></article>
                </td>
            </tr>
        </table>
    </form>
    <div id="errprue">
    </div>
    <div id="dialogregistro" title="Registrar Pago" style="display: none;">
        <table align="center" border="1">
            <tr align="center">
                <td>
                    Monto 
                    
                </td>
                <td>
                    Fecha de Pago
                </td>
                <td>
                    Movimiento de Cobro
                </td>
                <td>
                    Destinatario
                </td>
                <td>
                </td>
                <td>
                    Cuenta
                </td>
            </tr>
            <tr align="center">
                <td>
                    <input type="text" name="IdEntPagRal" id="IdEntPagRal" style="visibility:hidden; display:none">
                    $<input type="text" name="MonEntPagRal" id="MonEntPagRal"  size="15">
                </td>
                <td>
                    <input type="fechaPago" name="FecEntPagRal" id="FecEntPagRal" size="10"/>
                </td>
                <td id="movimientoPago">
                    
                </td>
                <td id="part">
                    
                </td>
                <td>
                <input type="button" id="nuevoPart" value="Registrar Participante" onclick="registroParticipante();"/>
                </td>
                <td id="cuenta">
                </td>
            </tr>
            <tr>
                <td>
                Nota:
                </td>
                <td colspan="5">
                <textarea cols="100" rows="2" id="info">
                </textarea>
                </td>
            </tr>
            <tr align="right">
                <td colspan="6">
                    <input type="button" value="Guardar" onclick="guardarPago();"/>
                </td>
            </tr>													
        </table>
        <div id="mensaje">
        </div>	
    </div>
    <div id="dialogmod" title="Modificar Fecha" style="display: none;">
        <table align="center" width="100%">
            <tr>
                <td>
                    <label for="FecEntPagRalM"> Fecha de Pago:</label>
                    <input type="fechaPagoM" name="FecEntPagRalM" id="FecEntPagRalM" size="10" class="ui-corner-all"/>
                </td>
                <td>                    
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <label for="passwd" style="margin-left: 17px;">Contraseña:</label>
                    <input type="password" name="passwd" id="passwd" size="10"/>
                    <input type="hidden" name="IdEntPagM" id="IdEntPagM">                   
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="button" value="Guardar" onclick="guardarFecha();"/></td>
            </tr>
        </table>
        <div id="mensajeM">
        </div>	
    </div>
   
    <div id="nuevoParticipante" title="Registrar Pago" style="display: none;">
        <script type="text/javascript" src="../js/participanteFunciones.js"></script>
            <form action="../participante/alta.php" method="post" name="formAddPoE" id="formAddPoENew" target="_top">
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
                                    <input type="hidden" id="bandera" name="bandera" value="1"/>
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
                            <input type="button" value="Guardar" onclick="enviaForm()";/>
                        </td>
                    </tr>
                </table>
            </form>
    </div>
    
    <script>
        enviaTotal('.$totalpry.','.$cuenta.','.$cuentavalidar.','.round($totalporcral,3).','.$alerta.');
        //cargaCaracteristicas();
        $("input[type=button],input[type=submit]").button();
    </script>';            	
?>
               
                

                   
                    
    

