<?php
require_once("../conexion.php");
$idPoEs = Array();
$idPoEs = $_POST['idPoE'];
echo "<h3>Reporte de estado de cuenta por empresa(s)</h3>"
     ;
for($i = 0; $i < count($idPoEs);$i ++){
    $qry="SELECT cue.IdEntCue,cue.NumEntCue,poe.NomEntPoE FROM tblentcue cue
            JOIN tblentpoe poe ON cue.IdEntPoE = poe.IdEntPoE
            WHERE poe.IdEntPoE=".$idPoEs[$i];
    $rescue=mysql_query($qry);
    while($cuenta=  mysql_fetch_array($rescue)){
    $query = "
        SELECT cli.NomEntCli,pry.NomEntPry,pag.CtoEntPag,pag.FecEntPagRal,pag.SalEntPag,mov.DscEntMov FROM tblentcli cli 
            JOIN tblentpry pry ON cli.IdEntCli = pry.IdEntCli
            RIGHT JOIN tblentpag pag ON pry.IdEntPry = pag.IdEntPry
            JOIN tblentmov mov ON pag.IdEntMov = mov.IdEntMov
        WHERE pag.IdEntCue =".$cuenta['IdEntCue']."
        ORDER BY pry.NomEntPry";
    $res = mysql_query($query);
    $cont = 1;
    echo '   <h4>Nombre: '.$cuenta['NomEntPoE'].'</h4>
            <h4>No. de cuenta: '.$cuenta['NumEntCue'].'</h4>
            <table width="100%">
                <tr>
                    <td align="left">
                        <b>Información de pagos</b>
                    </td>
                    
                </tr>
            </table>
            <table width="100%" cellpading="0" cellspacing="0">
                <thead>
                    <tr class="encabezado">
                        <th>
                            No.<br/>Pago
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Proyecto
                        </th>
                        <th>
                            Concepto
                        </th>
                        <th>
                            Fecha de cobro
                        </th>
                        <th>
                            Movimiento de cobro
                        </th>
                        <th>
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>';
    $pagosTot=0.00;
    $gastosTot=0.00;
    $disprTot=0.00;
    $dispoTot=0.00;
    while($pago = mysql_fetch_array($res)){
        echo '
                    <tr align="center">
                        <td>
                            '.$cont.'
                        </td>
                        <td>
                            '.$pago['NomEntCli'].'
                        </td>
                        <td>
                            '.$pago['NomEntPry'].'
                        </td>
                        <td>
                            '.$pago['CtoEntPag'].'
                        </td>
                        <td>';
                    if($pago['FecEntPagRal']!= null){
                        echo $pago['FecEntPagRal'];
                    }else{
                        echo $pago['FecEntPagPrg'];
                    }
                    echo'</td>
                        <td>
                            '.$pago['DscEntMov'].'
                        </td>
                        <td>'/*;
                    if($pago['MonEntPagRal']!= null){
                        echo "$".$pago['MonEntPagRal'];
                    }else{
                        echo "$".((float)$pago['MonEntPagPrg']*(1.16));
                    }     
                    echo*/
                            .$pago['SalEntPag'].'</td>
                    </tr>
                    ';
            
        $cont++;
        $pagosTot=$pagosTot+$pago['SalEntPag'];
    }
    echo '</tbody>
          <tfoot>
            <tr align="center">
                <td colspan="5">
                </td>
                <td>
                Monto total:
                </td>
                <td>
                $'.$pagosTot.'
                </td>
            </tr>
          </tfoot>
        </table>';
    
    $query = "
        SELECT cli.NomEntCli, pry.NomEntPry, gas.DesEntGas,gas.FecEntGas,gas.MonEntGas FROM tblentcli cli
            JOIN tblentpry pry ON cli.IdEntCli = pry.IdEntCli
            RIGHT JOIN tblentgas gas ON pry.IdEntPry = gas.IdEntPry
        WHERE gas.IdEntCue =".$cuenta['IdEntCue']."
        ORDER BY pry.NomEntPry";
    $res = mysql_query($query);
    $cont = 1;
    echo '<table width="100%" style="margin-top:35px;">
                <tr>
                    <td align="left">
                        <b>Información de gastos</b>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpading="0" cellspacing="0">
                <thead>
                    <tr class="encabezado">
                        <th>
                            No.<br/>Gasto
                        </th>
                        <th>
                            Cliente
                        </th>
                        <th>
                            Proyecto
                        </th>
                        <th>
                            Concepto
                        </th>
                        <th>
                            Fecha de gasto
                        </th>
                        <th>
                            Monto de gasto
                        </th>
                    </tr>
                </thead>
                <tbody>';
    while($gasto = mysql_fetch_array($res)){
        
        echo '
                    <tr align="center">
                        <td>
                            '.$cont.'
                        </td>
                        <td>
                            '.$gasto['NomEntCli'].'
                        </td>
                        <td>
                            '.$gasto['NomEntPry'].'
                        </td>
                        <td>
                            '.$gasto['DesEntGas'].'
                        </td>
                        <td>
                            '.$gasto['FecEntGas'].'
                        </td>
                        <td>
                            $'.$gasto['MonEntGas'].'
                        </td>
                    </tr>
                    ';
        $cont++;
        $gastosTot=$gastosTot+$gasto['MonEntGas'];
    }
    echo '</tbody>
        </tbody>
          <tfoot>
            <tr align="center">
                <td colspan="4">
                </td>
                <td>
                Monto total:
                </td>
                <td>
                $'.$gastosTot.'
                </td>
            </tr>
          </tfoot>
        </table>';
    
    $qr="SELECT pry.NomEntPry, pag.CtoEntPag, dis.FecMovDspPag, dis.MonDspPag, dest.DscDesPag FROM tblentpry pry
                JOIN tblentpag pag ON pry.IdEntPry = pag.IdEntPry
                JOIN tbldsppag dis ON dis.IdEntPag = pag.IdEntPag
                JOIN tbldespag dest ON dest.IdDesPag = dis.IdDesPag
        WHERE dis.IdEntCue =".$cuenta['IdEntCue']." AND dest.DscDesPag NOT LIKE '%QUEDARSELOS%' AND dest.DscDesPag NOT LIKE '%PERMANENCIA%'
        ORDER BY pry.NomEntPry
";
    $resdisp=  mysql_query($qr);
    
    echo '<table width="100%" style="margin-top:35px;">
                <tr>
                    <td align="left">
                        <b>Información de dispersiones realizadas</b>
                    </td>
                    
                </tr>
            </table>
            <table width="100%" cellpading="0" cellspacing="0">
                <thead>
                    <tr class="encabezado">
                        <th>
                            No.
                        </th>
                        <th>
                            Proyecto
                        </th>
                        <th>
                            Pago
                        </th>
                        <th>
                            Fecha de movimiento
                        </th>
                        <th>
                            Movimiento
                        </th>
                        <th>
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>';
    $cont=1;
      while($disp = mysql_fetch_array($resdisp)){
        
        echo '
                    <tr align="center">
                        <td>
                            '.$cont.'
                        </td>
                        <td>
                            '.$disp['NomEntPry'].'
                        </td>
                        <td>
                            '.$disp['CtoEntPag'].'
                        </td>
                        <td>
                            '.$disp['FecMovDspPag'].'
                        </td>
                        <td>
                            '.$disp['DscDesPag'].'
                        </td>
                        <td>
                            $'.$disp['MonDspPag'].'
                        </td>
                        
                    </tr>
                    ';
        $cont++;
        $disprTot=$disprTot+$disp['MonDspPag'];
    }  
      echo '</tbody>
        </tbody>
          <tfoot>
            <tr align="center">
                <td colspan="4">
                </td>
                <td>
                Monto total:
                </td>
                <td>
                $'.$disprTot.'
                </td>
            </tr>
          </tfoot>
        </table>';
    
      $q="SELECT pry.NomEntPry, pag.CtoEntPag, dis.FecMovDspPag, dis.MonDspPag, dest.DscDesPag FROM tblentpry pry
            JOIN tblentpag pag ON pry.IdEntPry = pag.IdEntPry
            JOIN tbldsppag dis ON dis.IdEntPag = pag.IdEntPag
            JOIN tbldespag dest ON dest.IdDesPag = dis.IdDesPag
          WHERE dis.IdEntCue = ".$cuenta['IdEntCue']." AND (dest.DscDesPag LIKE '%QUEDARSELOS%' OR dest.DscDesPag LIKE '%PERMANENCIA%')
          ORDER BY pry.NomEntPry";
      $resdispo=  mysql_query($q);
      
      echo '<table width="100%" style="margin-top:35px;">
                <tr>
                    <td align="left">
                        <b>Información de dispersiones obtenidas</b>
                    </td>
                    
                </tr>
            </table>
            <table width="100%" cellpading="0" cellspacing="0">
                <thead>
                    <tr class="encabezado">
                        <th>
                            No.
                        </th>
                        <th>
                            Proyecto
                        </th>
                        <th>
                            Pago
                        </th>
                        <th>
                            Fecha de movimiento
                        </th>
                        <th>
                            Movimiento de cobro
                        </th>
                        <th>
                            Monto
                        </th>
                    </tr>
                </thead>
                <tbody>';
      $cont=1;
      while($dispo = mysql_fetch_array($resdispo)){
        
        echo '
                    <tr align="center">
                        <td>
                            '.$cont.'
                        </td>
                        <td>
                            '.$dispo['NomEntPry'].'
                        </td>
                        <td>
                            '.$dispo['CtoEntPag'].'
                        </td>
                        <td>
                            '.$dispo['FecMovDspPag'].'
                        </td>
                        <td>
                            '.$dispo['DscDesPag'].'
                        </td>
                        <td>
                            $'.$dispo['MonDspPag'].'
                        </td>
                        
                    </tr>
                    ';
        $cont++;
        $dispoTot=$dispoTot+$dispo['MonDspPag'];
    }  
        echo '</tbody>
        </tbody>
          <tfoot>
            <tr align="center">
                <td colspan="4">
                </td>
                <td>
                Monto total:
                </td>
                <td>
                $'.$dispoTot.'
                </td>
            </tr>
          </tfoot>
        </table>';
        
        $q = "SELECT sum(SalDspPag) totalEmpresa FROM bdupgenia.tbldsppag where PropMonDsp = 0 and IdEntCue = ".$cuenta['IdEntCue'];
        $q1 = "SELECT sum(SalDspPag) totalPersona FROM bdupgenia.tbldsppag where PropMonDsp = 1 and IdEntCue = ".$cuenta['IdEntCue'];
        $resTot = mysql_query($q1);
        $totalPersona = mysql_fetch_array($resTot);
        $resTot1 = mysql_query($q);
        $totalEmpresa = mysql_fetch_array($resTot1);
         echo '<table width="100%" style="margin-top:35px;">
                <tr>
                    <td align="left">
                        <b>Información de totales</b>
                    </td>                    
                </tr>
            </table>
            <table cellpading="0" cellspacing="0">        
                    <tr class="entrada">
                        <th class="encabezado">
                            Saldo Personal
                        </th>
                        <td>
                            $'.$totalPersona["totalPersona"].'
                        </td>                       
                    </tr>
                    <tr class="entrada">
                        <th class="encabezado">
                            Saldo Empresarial
                        </th>
                        <td>
                            $'.$totalEmpresa["totalEmpresa"].'
                        </td>  
                    </tr>
                </table>';
        
        $cobroTotal=$pagosTot+$dispoTot;
        $gastosTotales=$gastosTot+$disprTot;
        $saldoCuenta=$cobroTotal - $gastosTotales;
        echo '  <table style="margin-top:35px;">
                    <tr class="encabezado" align="center">
                        <td>Cobro total</td>
                        <td>Gastos totales</td>
                        <td>Saldo en cuenta</td>
                    </tr>
                    <tr align="center">
                        <td>$'.(float)$cobroTotal.'</td>
                        <td>$'.(float)$gastosTotales.'</td>
                        <td>$'.(float)$saldoCuenta.'</td>
                    </tr>
                </table>
            
        <hr style="box-shadow: 0px 0px 10px rgb(24, 6, 235);border-radius: 5px; margin-top: 20px;">';
    } //fin del while para cuentas   
}//fin del for para reporte
?>
