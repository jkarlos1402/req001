<?php
session_start();
if (!ISSET($_SESSION["k_username"])) {
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';
}
?>
<script type="text/javascript" src="../js/reportesFunciones.js"></script>
<table class="ui-widget" width="100%">
    <tr>
        <td align="center" colspan="2">
            <label for="tipoRep"><b>TIPO DE REPORTE</b></label>
            <select id="tipoRep" name="tipoRep" onchange="muestraFiltro(this);">
                <option value="-1"></option>
                <option value="1">PROYECTO</option>
                <option value="2">CLIENTE</option>
                <option value="3">EMPRESA O PERSONA FÍSICA</option>
            </select>
            <hr style="box-shadow: 0px 0px 10px black;border-radius: 5px; margin-top: 20px;"/>
        </td>
    </tr>
    <tr>
        <td style="vertical-align: top;">
            <div id="menuIzq" style="width: 350px; height: 340px; margin-top: 40px;border-right: dotted 1px; position: fixed;">
                
            </div> 
        </td>
        <td style="width: 935px; vertical-align: top;" align="center">
            <div id="resultadoReporte">                
            </div>
        </td>
    </tr>
</table>
