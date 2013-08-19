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
        $color="bgcolor='#00D615'"; // VERDE
    }
    if($estado=="PLANEADO"){
        $color="bgcolor='#0080FF'"; // AZUL
        //$color="bgcolor='#00D615'";
    }
    if($estado=="PROXIMO A EJECUTAR"){
        $color="bgcolor='#F5F103'";
    }
    if($estado=="DESFASADO"){
        $color="bgcolor='#FC0404'";
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
    echo '<label>Cliente: </label><input type=text value='.$renglon['NomEntCli'].'>';
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
        $iva =$renglon['MonEntPagPrg'] * .16;				// SI LO HAY HACE EL CÁLCULO PARA SACAR EL IVA
        $total =$total +($renglon['MonEntPagPrg']+$iva); 	// LO SUMA AL TOTAL
        $totalporc = $totalporc + $renglon['PorEntPagPrg'];

        $pagoi=$renglon['MonEntPagPrg']+$iva; 
        $pagoi=round($pagoi,2);
        echo '  <td>$'.$pagoi.'</td>';			//IMPRIME EL VALOR CON IVA
    }else{
        $pagoi=$renglon['MonEntPagPrg'];
        $pagoi=round($pagoi,2);
        echo '  <td>$'.$pagoi.'</td>';			
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
        echo round($renglon['MonEntPagRal'],2);
        $cuenta=$cuenta+round($renglon['MonEntPagRal'],2);
        $cuentavalidar=$cuentavalidar+$cuenta;
        if((round($renglon['MonEntPagRal'],1)>round($pagoi,1) || round($renglon['MonEntPagRal']<$pagoi,1))&&$renglon['MonEntPagRal']!=null){
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
        echo '                  <td><input type="button" value="Registrar Pago" id="registra'.$cont.'" name="registra'.$cont.'" onclick="registraPago('.$renglon['IdEntPag'].','.$cont.','.$pagoi.')"></td>';								
    //echo '<input type="fecha" name="date'.$cont.'" id="date'.$cont.'" placeholder="Ingresa fecha" onchange="actualizarFecha('.$renglon['IdEntPag'].',this.value,'.$cont.');"/>';	
    }else{
        echo '                  <td id="fec'.$cont.'">'.date('d-m-Y',strtotime($renglon['FecEntPagRal'])).'</td>
                                <td><img src="../vista/images/config.gif" title="Modificar Fecha" onclick="verificaPass('.$renglon['IdEntPag'].','.$cont.','.$pagoi.');"  width="25" align="right"></td>';
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
                <td><input type="button" onclick="" value="Consultar"></td>
            </tr>';
    $cont++;	
}
echo '      <tr align="center" class="registro">
                <td colspan="4"></td>
                <td>Total<br>Proyecto</td>
                <td>$'.$totalpry.'</td>
                <td><input type="text" style="visibility:hidden; display:none;" name="renglones" id="renglones" value="'.$cont.'">
                        Total<br>Pagado</td>
                <td id="porcreal">'.round($totalporcral,3).'%</td>
                <td id="totreal">$'.round($cuenta,2).'</td>
                <td><input type="button" onclick="programaSel()" value="Programar Seleccionados"></td>
                <td><input type="button" onclick="" value="Consultar Seleccionados"></td>
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
                <td>
                    <input type="button" value="Guardar" onclick="guardarPago();"/>
                </td>
                <td>
                </td>
            </tr>													
        </table>
        <div id="mensaje">
        </div>	
    </div>
    <div id="dialogmod" title="Modificar Fecha" style="display: none;">
        <table align="center" border="1">
            <tr align="center">
                <td>
                    Fecha de Pago
                </td>
                <td>
                </td>
            </tr>
            <tr align="center">
                <td>
                    <input type="hidden" name="IdEntPagM" id="IdEntPagM">
                    <input type="fechaPagoM" name="FecEntPagRalM" id="FecEntPagRalM" size="10"/>
                </td>
                <td>
                    <input type="button" value="Guardar" onclick="guardarFecha();"/>
                </td>
                <td>
                </td>
            </tr>													
        </table>
        <div id="mensajeM">
        </div>	
    </div>		
    <script>
        enviaTotal('.$totalpry.','.$cuenta.','.$cuentavalidar.','.round($totalporcral,3).','.$alerta.');
        //cargaCaracteristicas();
        $("input[type=button],input[type=submit]").button();
    </script>';            	
?>
               
                

                   
                    
    

