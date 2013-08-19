<?php
$idPrys = Array();
$idPrys = $_POST['idPry'];
echo "<h3>Reporte General de pagos</h3>";
for($i = 0; $i < count($idPrys);$i ++){
    $query = "SELECT * from tblentpag pago
	join tblentpry proy on pago.IdEntPry = proy.IdEntPry
	join tblentcli cliente on cliente.IdEntCli = proy.IdEntCli
    where pago.IdEntPry =".$idPrys[$i];
    echo '<table>
            <tr>
                <td align="right">
                    Información de pago
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
          </table>';
}//fin del for para reporte
?>
