<?php
include("../conexion.php");
session_start();
$IdEntPoE=$_POST['PoE'];
$query="SELECT tblentcue.IdEntCue IdEntCue, tblentcue.NumEntCue NumEntCue, tblentcue.ClaEntCue ClaEntCue, tblentcue.IdEntSuc IdEntSuc, tblentsuc.SucEntSuc SucEntSuc, tblentsuc.IdEntBan IdEntBan, tblentban.NomEntBan NomEntBan
	FROM tblentban, tblentcue, tblentsuc
	WHERE tblentcue.IdEntSuc = tblentsuc.IdEntSuc
	AND tblentsuc.IdEntBan = tblentban.IdEntBan
	AND tblentcue.IdEntPoE =$IdEntPoE";

echo '
		<meta charset="utf-8">
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script src="../js/funcionesGastos.js" type="text/javascript"></script>
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">

		';

$result=mysql_query("$query",$conexion) or die (mysql_error());

echo '
    <table width="100%" class="ui-widget" border="1">
        <tr class="encabezado">
            <td align="center" colspan="5">
                DATOS DE CUENTA(S) BANCARIA(S)
            </td>
        </tr>
        <tr>
            <td></td>
            <td>BANCO</td>
            <td>SUCURSAL</td>
            <td>NO. CUENTA</td>
            <td>CLABE</td>
        </tr>';
        $i=0;
        while($cuenta =  mysql_fetch_array($result)){
        
   echo'<tr>
            <td><input type="radio" id="radio" name="radio" onclick="despliegaMovimientos('.$i.')"></td>
            <td><input type="text" id="NomEntBan'.$i.'" id="NomEntBan'.$i.'" value="'.$cuenta['NomEntBan'].'"></td>
            <td><input type="text" id="SucEntSuc'.$i.'" id="SucEntSuc'.$i.'" value="'.$cuenta['SucEntSuc'].'"></td>
            <td><input type="text" id="NumEntCue'.$i.'" id="NumEntCue'.$i.'" value="'.$cuenta['NumEntCue'].'"></td>
            <td><input type="text" id="ClaEntCue'.$i.'" id="ClaEntCue'.$i.'" value="'.$cuenta['ClaEntCue'].'"></td>
        </tr>';
        $i++;
        }
echo '</table>
      <div id="movimientos" style="margin-top:10px; visibility:hidden; display:none;">
        <table width="100%" class="ui-widget">
            <tr class="encabezado">
                <td align="center">MOVIMIENTOS DE CUENTA</td>
            </tr>
            <tr>
                <td>
                    No. de Cuenta: <input type="text" id="cuenta" name="cuenta" size="70"> <input type="button" id="agregar" value="Agregar" onclick="agregarMovimientos();">
                </td>
            </tr>
        </table>
        
        <div id="mov0" style="margin-top:5px; background-color:#eee;">
            <input type="text" class="index" value="0">
                <table width="100%" class="ui-widget">
                    <tr>
                        <td id="proyecto0">

                        </td>
                    </tr>
                </table>
                <div class="datosMov" style="visibility:hidden; display:none;">
                    <table class="ui-widget" width="100%" border="1">
                        <tr>
                            <td>Concepto</td>
                            <td>Fecha</td>
                            <td>Monto</td>
                        </tr>
                    </table>
                </div>
        </div>';  //Fin Mov0
        
 //Fin Movimientos
     echo' </div>
    ';

?>
