<?php
include ("../conexion.php");
$IdEntCli = $_POST['IdEntCli'];
foreach ($IdEntCli as $cliente){
    $query = "select * from tblentpry where IdEntCli = ".$cliente;
    $query1 ="select NomEntCli from tblentcli where IdEntCli = ".$cliente;
    $result1 = mysql_query($query1);
    $NomCli = mysql_fetch_array($result1);
    $result = mysql_query($query);
    if(mysql_num_rows($result) == 0){
        echo '<h3>No se han encontrado proyectos para '.$NomCli['NomEntCli'].'</h3>';
        exit();
    }
    while($proyecto = mysql_fetch_array($result)){
        echo '<table width="100%" cellpading="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="7">
                        <h3>Proyecto correspondiente a '.$NomCli['NomEntCli'].' </h3>
                    <th>
                </tr>
                <tr>
                    <th>
                        Proyecto
                    </th>
                    <th>
                        Descripción
                    </th>
                    <th>
                        Fecha de inicio
                    </th>
                    <th>
                        Fecha de término
                    </th>
                    <th>
                        IVA
                    </th>
                    <th>
                        Precio
                    </th>
                    <th>
                        Porcentaje<br/>
                        Intermediario
                    </th>
                </tr>
            </thead>
            <tbody>';
        echo '  <tr class="renglon">
                    <td>
                        '.$proyecto['NomEntPry'].'
                    </td>
                    <td>
                        '.$proyecto['DscEntPry'].'
                    </td>
                    <td align="center">
                        '.date('d-m-Y',strtotime($proyecto['FecIniPry'])).'
                    </td>
                    <td align="center">
                        '.date('d-m-Y',strtotime($proyecto['FecTerPry'])).'
                    </td>
                    <td align="center">';
        if($proyecto['IVAEntPry'] == 1){
            echo '      <span class="ui-icon ui-icon-check"></span>';
        }else{
            echo '      <span class="ui-icon ui-icon-close"></span>';
        }                
        echo '      </td>
                    <td align="center">';
                    if($proyecto['IVAEntPry'] == 0){
                        echo '$'.number_format($proyecto['PreEntPry'],2);
                    }else{
                        echo '$'.  number_format(((float)$proyecto['PreEntPry']*1.16),2);
                    }
                    echo'</td>
                    <td align="center">
                        '.$proyecto['PjeEntPry'].'%
                    </td>
                </tr>';    
                $query = "select * from tblentpag where IdEntPry = ".$proyecto['IdEntPry'];
                $result2 = mysql_query($query);
                echo '
            </tbody>
        </table>
        <table cellpading="0" cellspacing="0">
            <thead>
                <tr>
                    <th colspan="7">
                        <h3>Pagos establecidos<h3>
                    </th>
                </tr>
                <tr>
                    <th>
                        No.
                    </th>
                    <th>
                        Concepto
                    </th>
                    <th>
                        Monto acordado
                    </th>
                    <th>
                        Monto ejercido
                    </th>
                    <th>
                        Fecha acordada
                    </th>
                    <th>
                        Fecha ejercida
                    </th>
                </tr>
            </thead>
            <tbody>';
                $contadorPagos = 1;
                while($pago = mysql_fetch_array($result2)){
                    echo '<tr class="renglon">
                            <td align="center">
                                '.$contadorPagos.'
                            </td>
                            <td>
                                '.$pago['CtoEntPag'].'
                            </td>
                            <td>
                                $'.$pago['MonEntPagPrg'].'
                            </td>
                            <td>
                                $'.$pago['MonEntPagRal'].'
                            </td>
                            <td>
                                '.date('d-m-Y',strtotime($pago['FecEntPagPrg'])).'
                            </td>
                            <td>';
                    if($pago['FecEntPagRal']!= null)
                           echo     date('d-m-Y',strtotime($pago['FecEntPagRal']));
                            echo'</td>
                        </tr>';
                    $contadorPagos++;
                }
    }
    echo '  </tbody>
        </table>
        <hr style="box-shadow: 0px 0px 10px rgb(24, 6, 235);border-radius: 5px; margin-top: 20px;"/>';
}
//print_r($IdEntCli);
?>
