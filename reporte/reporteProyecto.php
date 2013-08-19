<?php
$idPrys = Array();
$idPrys = $_POST['idPry'];
echo "<h3>Reporte General de pagos</h3>";
for($i = 0; $i < count($idPrys);$i ++){
    $query = "SELECT * from tblentpag pago
	join tblentpry proy on pago.IdEntPry = proy.IdEntPry
	join tblentcli cliente on cliente.IdEntCli = proy.IdEntCli
    where pago.IdEntPry =".$idPrys[$i];
    $res = mysql_query($query);
    $pago = mysql_fetch_array($res);
    echo '<table width="100%">
            <tr>
                <td align="left">
                    <b>Información de pago</b>
                </td>
            </tr>
        </table>
        <table width="100%">
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
                <tr>
                    <td>
                        '.$i.'
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
                    echo $pago['MonEntPagRal'];
                }else{
                    echo ((float)$pago['MonEntPagPrg']*(1.16));
                }     
                echo'</td>
                    <td>
                        '.$pago['PjeEntPry'].'
                    </td>
                    <td>';
                if($pago['MonEntPagRal']!= null){
                    echo ($pago['MonEntPagRal']-(((float)$pago['PjeEntPry']*$pago['MonEntPagRal'])/100));
                }else{
                    echo '0.00';
                }     
                echo'</td>
                </tr>
            </tbody>
          </table>';
}//fin del for para reporte
?>
