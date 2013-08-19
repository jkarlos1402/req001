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
                        <b>Información de pago</b>
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
                    <tr class="entrada'.($cont%2).'" align="center">
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
                            Cliente
                        </td>
                        <td>';
                    if($pago['MonEntPagRal']!= null){
                        echo "$".$pago['MonEntPagRal'];
                    }else{
                        echo "$".((float)$pago['MonEntPagPrg']*(1.16));
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
                                $'.((float)$pago['MonEntPagPrg']*(1.16)).'
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
            $query = "select * from tbldsppag where IdEntPag =".$pago['IdEntPag'];
            $res2 = mysql_query($query);
              echo '<h3>Dispersión de pagos</h3>
              <table width="100%">
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
                            Monto de<br/>acción
                        </th>
                        <th>
                            Gasto o<br/>dispersión
                        </th>
                        <th>
                            Saldo
                        </th>
                    </tr>
                </thead>
                <tbody>';
              $contDisp = 1;
              while($dispersion = mysql_fetch_array($res2)){
                  echo '<tr>
                            <td>
                                '.$contDisp.'
                            </td>
                            <td>
                                '.$dispersion['DscOrgPag'].'
                            </td>
                            <td>
                                '.$dispersion['DscDesPag'].'
                            </td>
                            <td>
                                '.$dispersion['MonDspPag'].'
                            </td>
                            <td>
                                '.$dispersion['FecMovDspPag'].'
                            </td>
                      </tr>';
                  $contDisp++;
              }
            echo'</tbody>
            </table>
            <hr/>';
        $cont++;
    }
}//fin del for para reporte
?>
