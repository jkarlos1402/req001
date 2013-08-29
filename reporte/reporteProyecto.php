<?php
require_once("../conexion.php");
$idPrys = Array();
$idPrys = $_POST['idPry'];
echo "<h3>Reporte General de pagos</h3>";
for($i = 0; $i < count($idPrys);$i ++){
    $query = "SELECT * from tblentpag pago
	join tblentpry proy on pago.IdEntPry = proy.IdEntPry
	join tblentcli cliente on cliente.IdEntCli = proy.IdEntCli
    where pago.IdEntPry =".$idPrys[$i];
    $res = mysql_query($query);
    $cont = 1;
    while($pago = mysql_fetch_array($res)){
        echo '<table width="100%">
                <tr>
                    <td align="left">
                        <h3>Información de pago</h3>
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
                            Origen
                        </th>
                        <th>
                            Monto de<br/>pago
                        </th>
                        <th>
                            Factor (%)<br/>Intermediario
                        </th>
                        <th>
                            Saldo
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="entrada" align="center">
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
                        echo date('d-m-Y',strtotime($pago['FecEntPagRal']));
                    }else{
                        echo date('d-m-Y',strtotime($pago['FecEntPagPrg']));;
                    }
                    echo'</td>
                        <td>
                            Cliente
                        </td>
                        <td>';
                    if($pago['MonEntPagRal']!= null){
                        echo "$".$pago['MonEntPagRal'];
                    }else{
                        echo "$".$pago['MonEntPagPrg'];
                    }     
                    echo'</td>
                        <td>
                            '.$pago['PjeEntPry'].'
                        </td>
                        <td>';
                    if($pago['MonEntPagRal']!= null){
                        echo "$".($pago['MonEntPagRal']-(((float)$pago['PjeEntPry']*$pago['MonEntPagRal'])/100));
                    }else{
                        echo '$0.00';
                    }     
                    echo'</td>
                    </tr>
                    <tr>
                        <td colspan="9">
                            <br/>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                            </td>
                            <td>
                                Pago acordado
                            </td>
                            <td>
                                $'.((float)$pago['MonEntPagPrg']).'
                            </td>
                            <td>
                                Pago ejercido
                            </td>
                            <td>
                                $'.(float)$pago['MonEntPagRal'].'
                            </td>
                        </tr>
                    </tfoot>
                </tbody>
              </table>';
            $query = "SELECT * FROM tbldsppag disp
join tblentpoe poe on disp.IdEntPoE = poe.IdEntPoE 
join tbldespag accion on accion.IdDesPag = disp.IdDesPag
where disp.IdEntPag = ".$pago['IdEntPag']." and disp.PadDspPag is null";
            $res2 = mysql_query($query);
              echo '<div style="text-align: left;"><h3>Dispersión de pagos</h3></div>
              <table width="100%" cellpading="0" cellspacing="0">
                <thead>
                    <tr class="encabezado">
                        <th>
                            No.
                        </th>
                        <th>
                            Origen
                        </th>
                        <th>
                            Destino
                        </th>
                        <th>
                            Monto
                        </th>
                        <th>
                            Fecha
                        </th>
                        <th>
                            Acción
                        </th>
                        <th>
                            Dispersión
                        </th>
                        <th>
                            Saldo
                        </th>
                    </tr>
                </thead>
                <tbody>';
              $contDisp = 1;
              if(mysql_num_rows($res2)>0){
                while($dispersion = mysql_fetch_array($res2)){
                    $query = "SELECT ifNULL(sum(MonDspPag),0.00) dispersion FROM tbldsppag where PadDspPag = ".$dispersion['IdDspPag'];
                    $res3 = mysql_query($query);
                    $dispersado = mysql_fetch_array($res3);
                    echo '<tr class="entrada">
                              <td>
                                  '.$cont.'.'.$contDisp.'
                              </td>
                              <td>
                                  Cliente
                              </td>
                              <td>
                                  '.$dispersion['NomEntPoE'].'
                              </td>
                              <td>
                                  '.$dispersion['MonDspPag'].'
                              </td>
                              <td>
                                  '.date('d-m-Y',strtotime($dispersion['FecMovDspPag'])).'
                              </td>
                              <td>
                                  '.$dispersion['DscDesPag'].'
                              </td>
                              <td>
                                  $'.$dispersado['dispersion'].'
                              </td>
                              <td>
                                  $'.$dispersion['SalDspPag'].'
                              </td>
                        </tr>';
                    $contDisp++;
                    $contDspSec = 1;
                    $query = "SELECT * FROM tbldsppag disp
                              join tblentpoe poe on disp.IdEntPoE = poe.IdEntPoE 
                              join tbldespag accion on accion.IdDesPag = disp.IdDesPag
                              where disp.PadDspPag = ".$dispersion['IdDspPag'];
                    $res4 = mysql_query($query);
                    while ($dispersionSec = mysql_fetch_array($res4)){
                        $query="SELECT disp.IdEntPoE,NomEntPoE FROM tbldsppag disp
                              join tblentpoe poe on poe.IdEntPoE = disp.IdEntPoE 
                              where IdDspPag = ".$dispersionSec['PadDspPag'];
                        $res5 = mysql_query($query);
                        $origen = mysql_fetch_array($res5);
                          echo '<tr class="entrada">
                              <td>
                                  '.$cont.'.'.$contDisp.'.'.$contDspSec.'
                              </td>
                              <td>
                                  '.$origen['NomEntPoE'].'
                              </td>
                              <td>
                                  '.$dispersionSec['NomEntPoE'].'
                              </td>
                              <td>
                                  '.$dispersionSec['MonDspPag'].'
                              </td>
                              <td>
                                  '.date('d-m-Y',strtotime($dispersionSec['FecMovDspPag'])).'
                              </td>
                              <td>
                                  '.$dispersionSec['DscDesPag'].'
                              </td>
                              <td>
                                  $0.00
                              </td>
                              <td>
                                  $'.$dispersionSec['SalDspPag'].'
                              </td>
                        </tr>';
                        $contDspSec++;
                    }
                }
              }else{
                  echo '<tr>
                            <td colspan="8" align="center">
                                No se han registrado dispersiones
                            </td>
                      </tr>';
              }
            echo'</tbody>
            </table>
            <hr/>';
        $cont++;
    }
    echo '<h3>Gastos realizados</h3>';
    $query = "SELECT poe.NomEntPoE,gas.DesEntGas,gas.FecEntGas,gas.MonEntGas 
                FROM tblentpry pry 
                RIGHT JOIN tblentgas gas ON pry.IdEntPry = gas.IdEntPry
                join tblentcue cuenta on cuenta.IdEntCue = gas.IdEntCue
                join tblentpoe poe on poe.IdEntPoE = cuenta.IdEntPoE
                WHERE pry.IdEntPry =".$idPrys[$i];
    $res = mysql_query($query);
    echo '<table width="100%" cellpading="0" cellspacing="0">
            <thead>
                <tr class="encabezado">
                    <th>
                        No.
                    </th>
                    <th>
                        Nombre del participante
                    </th>
                    <th>
                        Descripción del gasto
                    </th>
                    <th>
                        Fecha del gasto
                    </th>
                    <th>
                        Monto del gasto
                    </th>
                </tr>
            </thead>
            <tbody>';
    $contGasto = 1;
    $sumaGastos = 0;
    if(mysql_num_rows($res) > 0){
        while ($gasto = mysql_fetch_array($res)) {
            echo '<tr class="entrada" align="center">
                    <td>
                        '.$contGasto.'
                    </td>
                    <td>
                        '.$gasto['NomEntPoE'].'
                    </td>
                    <td>
                        '.$gasto['DesEntGas'].'
                    </td>
                    <td>
                        '.date('d-m-Y',strtotime($gasto['FecEntGas'])).'
                    </td>
                    <td>
                        $'.$gasto['MonEntGas'].'
                    </td>
                </tr>';
            $contGasto++;
            $sumaGastos += (float)$gasto['MonEntGas'];
            }
            echo '<tr align="center">
                    <td colspan="4" align="right">
                        Total de gastos:
                    </td>
                    <td>
                        <b>$'.$sumaGastos.'</b>
                    </td>
                </tr>';
        }else{
            echo '<tr>
                    <td colspan="5">
                        No hay gastos registrados para este proyecto
                    </td>
                </tr>';
    }
    echo'   </tbody>    
        </table>
        <hr style="box-shadow: 0px 0px 10px rgb(24, 6, 235);border-radius: 5px; margin-top: 20px;">';
}//fin del for para reporte
?>
