<?php
include("../conexion.php");
session_start();
$IdEntCue=$_POST['IdEntCue'];
echo '
		<meta charset="utf-8">
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script src="../js/funcionesGastos.js" type="text/javascript"></script>
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/estilos.css">

		';
$query =  "SELECT * FROM tblentgas WHERE IdEntCue = $IdEntCue";
$res = mysql_query($query,$conexion);
//$resultado=  mysql_fetch_array($res);
if(mysql_num_rows($res) == 0){


echo'<div class="mov" id="mov0" style="margin-top:5px; background-color:#eee;">
            <form id="form0">
            <input type="hidden" name="IdEntCue" id="cuentax">
            <input type="hidden" class="index" value="0">
                <table width="100%" class="ui-widget">
                    <tr>
                        <td id="proyecto0">

                        </td>
                    </tr>
                </table>
                <div class="datosMov" >
                    <table class="ui-widget" width="100%">
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
                            <td>$<input class="montoTotal" type="text" id="montoTotal" style="width:90%" name="montoTotal" value="0.00"/></td>
                        </tr>
                        
                    </table>
                </div>
            </form>   
        </div>
         ';
}
else{
    $i=0;
    while($resultado=  mysql_fetch_array($res)){
       //REVISAR DESPLIEGUE DE LOS DATOS REGISTRADOS -------------------------------------------------------------------------
        
    echo'<div class="mov" id="mov'.$i.'" style="margin-top:5px; background-color:#eee;">
            <form id="form'.$i.'">
            <input type="hidden" name="IdEntCue" id="cuentax">
            <input type="hidden" class="index" value="0">
                <table width="100%" class="ui-widget">
                    <tr>
                        <td id="proyecto'.$i.'">

                        </td>
                    </tr>
                </table>
                <div class="datosMov" >
                    <table class="ui-widget" width="100%">
                        <tr align="center">
                            <td>CONCEPTO</td>
                            <td>FECHA</td>
                            <td>MONTO</td>
                            <td><li class="agrega" id="agrega'.$i.'" onclick="agregaCampos('.$i.');"></li><li class="elimina" style="visibility:hidden; display:none;" id="elimina'.$i.'" onclick="eliminaCampos('.$i.');"></li></td>
                        </tr>
                        <tr class="campos" id="campos'.$i.'">
                            <td width="45%"><input type="text" id="concepto0" name="concepto[]" style="width:100%;"/></td>
                            <td width="25%"><input type="fecha" id="fecha00" name="fecha[]" style="width:100%;"/></td>
                            <td width="25%">$<input class="monto" type="text" id="monto0" name="monto[]" style="width:90%;" onchange="sumaGastos(0)"/></td>
                            <td><input type="hidden" class="indexCampos" value="0"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">TOTAL DE GASTOS</td>
                            <td>$<input class="montoTotal" type="text" id="montoTotal" style="width:90%" name="montoTotal" value="0.00"/></td>
                        </tr>
                        
                    </table>
                </div>
            </form>   
        </div>
         ';
    $i++;
    }
}
?>
