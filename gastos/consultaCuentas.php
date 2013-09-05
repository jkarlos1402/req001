    <?php
include("../conexion.php");
session_start();
$IdEntPoE=$_POST['PoE'];
$query="SELECT tblentcue.IdEntCue IdEntCue, tblentcue.NumEntCue NumEntCue, tblentcue.ClaEntCue ClaEntCue, tblentcue.IdEntSuc IdEntSuc, tblentsuc.SucEntSuc SucEntSuc, tblentsuc.IdEntBan IdEntBan, tblentban.NomEntBan NomEntBan
	FROM tblentban, tblentcue, tblentsuc
	WHERE tblentcue.IdEntSuc = tblentsuc.IdEntSuc
	AND tblentsuc.IdEntBan = tblentban.IdEntBan
	AND tblentcue.IdEntPoE =$IdEntPoE";
$result=mysql_query("$query",$conexion) or die (mysql_error());


echo '<script src="../js/funcionesGastos.js" type="text/javascript"></script>';
echo '
    <table width="100%" class="ui-widget" >
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
            <td><input type="radio" id="radio" name="radio" onclick="despliegaMovimientos('.$i.');">
            <input type="hidden" id="IdEntCue'.$i.'" name="IdEntCue'.$i.'" value="'.$cuenta['IdEntCue'].'"/></td>
            <td><input type="text" id="NomEntBan'.$i.'" id="NomEntBan'.$i.'" value="'.$cuenta['NomEntBan'].'" readonly></td>
            <td><input type="text" id="SucEntSuc'.$i.'" id="SucEntSuc'.$i.'" value="'.$cuenta['SucEntSuc'].'" readonly></td>
            <td><input type="text" id="NumEntCue'.$i.'" id="NumEntCue'.$i.'" value="'.$cuenta['NumEntCue'].'" readonly></td>
            <td><input type="text" id="ClaEntCue'.$i.'" id="ClaEntCue'.$i.'" value="'.$cuenta['ClaEntCue'].'" readonly></td>
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
                    No. de Cuenta: <input type="text" id="cuenta" name="cuenta" size="70" readonly>
                    <input type="button" id="agregar" value="Agregar" onclick="agregarMovimientos();">
                    <input type="button" id="eliminar" value="Eliminar" style="visibility:hidden; display:none;" onclick="eliminarMovimientos();">
                </td>
            </tr>
        </table>
        <div class="mov" id="mov0" style="margin-top:5px; background-color:#eee;">
            <form id="form0">
            <input type="hidden" name="IdEntCue" id="cuentax">
            <input type="hidden" class="index" value="0">
                <table width="100%" class="ui-widget">
                    <tr>
                        <td id="proyecto0">

                        </td>
                    </tr>
                </table>
                <div class="movRegistrados">
                </div>';
                if($_SESSION['k_perfil']!="USU"){
                    
                echo'<div class="datosMov" style="visibility:hidden; display:none;">
                    <table class="ui-widget" width="100%" >
                        <tr>
                            <td colspan="4"><center>GASTOS NUEVOS</center></td>
                        </tr>
                        <tr align="center">
                            <td>CONCEPTO</td>
                            <td>FECHA</td>
                            <td>MONTO</td>
                            <td><li class="agrega" id="agrega0" onclick="agregaCampos(0);"></li><li class="elimina" style="visibility:hidden; display:none;" id="elimina0" onclick="eliminaCampos(0);"></li></td>
                        </tr>
                        <tr class="campos" id="campos0">
                            <td width="45%"><input type="text" id="concepto0" name="concepto[]" style="width:100%;"/></td>
                            <td width="25%"><input type="fecha" id="fecha00" name="fecha[]" style="width:100%;"/></td>
                            <td width="25%">$<input class="monto" type="text" id="monto0" name="monto[]" style="width:90%;" onchange="sumaGastos(0)"/></td>
                            <td><input type="hidden" class="indexCampos" value="0"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">TOTAL DE GASTOS</td>
                            <td>$<input class="montoTotal" type="text" id="montoTotal" style="width:90%" name="montoTotal" value="0.00" readonly/></td>
                        </tr>
                        
                    </table>
                </div>';
                }                
                echo'
            </form>   
        </div>
         ';  //Fin Mov0
     echo '
                    <table width="100%" class="ui-widget">
                        <tr>
                            <td align="right">SALDO EN CUENTA</td>
                            <td>$<input type="text" id="saldoSingastos" name="saldoSingastos" readonly/></td>
                        </tr>
                        <tr>
                            <td align="right">TOTAL DE GASTOS</td>
                            <td>$<input type="text" id="totalGastos" name="totalGastos" readonly/></td>
                        </tr>
                        <tr>
                            <td align="right">SALDO EN CUENTA DESPUES DE GASTOS</td>
                            <td>$<input type="text" id="saldoCongastos" name="saldoCongastos" readonly/></td>
                        </tr>
                        <tr>
                            <td align="right">';
                            if($_SESSION['k_perfil']!="USU"){
                            echo '<input type="button" id="enviar" onclick="guardarGastos(0);" value="Guardar"/>';
                            }
                            echo '
                            </td>
                        </tr>
                    </table>
         ';   
 //Fin Movimientos
     echo' </div>
         <div id="log">
         </div>
         
    ';

?>
