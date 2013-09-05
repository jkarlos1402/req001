<?php
include("../conexion.php");
session_start();

    $readonly='readonly';
$IdEntPry=$_POST['IdEntPry'];
$IdEntCue=$_POST['IdEntCue'];
/*echo '
		<meta charset="utf-8">
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script src="../js/funcionesGastos.js" type="text/javascript"></script>
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">

		';*/
$query =  "SELECT * FROM tblentgas WHERE IdEntPry = $IdEntPry AND IdEntCue = $IdEntCue ORDER BY FecEntGas DESC";
$res = mysql_query($query,$conexion);
//$resultado=  mysql_fetch_array($res);
if(mysql_num_rows($res) > 0){
echo '<div style="margin-top:5px;">
               
                    <table class="ui-widget" width="100%">
                        <tr>
                            <td colspan="4"><center>GASTOS REGISTRADOS</center></td>
                        </tr>
                        <tr align="center">
                            <td>CONCEPTO</td>
                            <td>FECHA</td>
                            <td>MONTO</td>
                            <td></td>
                        </tr>';    
    while($resultado=  mysql_fetch_array($res)){
    echo'               <tr>
                            <td width="45%"><input type="text" '.$readonly.' style="width:100%;" value="'.$resultado['DesEntGas'].'"/></td>
                            <td width="25%"><input type="fecha" '.$readonly.' style="width:100%;" value="'.date('d-m-Y',strtotime($resultado['FecEntGas'])).'"/></td>
                            <td width="25%">$<input type="text" '.$readonly.' style="width:90%;" value="'.$resultado['MonEntGas'].'"/></td>
                        </tr>';
    }
    
    echo '          </table> 
        </div>';

}
?>
