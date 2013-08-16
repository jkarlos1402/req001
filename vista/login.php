<?php
session_start();
if(ISSET($_SESSION["k_username"])){
echo '<SCRIPT LANGUAGE="javascript">
            location.href = "../vista/home.php";
            </SCRIPT>';
}
?>
<!DOCTYPE html>
<hmtl lang="es">
    <head>
        <meta charset="utf-8">
    </head>
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/funciones.js"></script>
    <script type="text/javascript" src="../js/loginFunciones.js"></script>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
    <script>
        $(window).load(cargaCaracteristicas());
    </script>
    <body>
        <div>
            <div style="left:37%; top:60%; position:fixed;">
                <img src="images/upgenia.png">
            </div>
            <div>
                <div class="ui-widget-overlay"></div>
                <div class="ui-widget-shadow ui-corner-all" style="width: 26.7%; height: 33.5%; position: absolute; left: 37%; top: 25%;"></div>
            </div>
            <div class="ui-widget ui-widget-content ui-corner-all" style="position: absolute; width: 25%; height: 30%;left: 37%; top: 25%; padding: 10px;">
                <div align="center">
                    <h3 class="encabezado ui-corner-all">Bienvenido</h3>
                    <form action="../login/verificaLogin.php" id="formLogin" name="formLogin" method="post" target="_top">
                        <table>
                            <tr><td>Usuario:</td><td><input type="text" id="NomEntUsu" name="NomEntUsu" placeholder="Ingrese su nombre"></td></tr>
                            <tr><td>Contraseña:</td><td><input type="password" id="PwdEntUsu" name="PwdEntUsu" placeholder="Ingrese su password"></td></tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Ingresar">
                                </td>
                            </tr>
                        </table>
                    </form>
                    <div id="error" style="top:20%">
                    </div>
                </div>
            </div>    
        </div>
    </body>
</html>