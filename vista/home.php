<?php 
$ban;
session_start(); 
if(!ISSET($_SESSION["k_username"])){
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Administraci&oacute;n y control de pagos</title>
    <script type="text/javascript" src="../js/lib_fun.js"></script>
    <script src="../js/jquery.js" type="text/javascript"></script>
    <script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
    <script type="text/javascript" src="../js/funciones.js"></script>

    <link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css"/>
    <link href="../vista/css/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div>
    <?php
echo '<div>
        <div>
            <button id="ident">'.$_SESSION["k_username"].'</button>
            <button id="select">Cerrar Sesión</button>
        </div>';
if($_SESSION["k_perfil"]=="ADM"){
    $ban="ADM";
echo '  <ul style="position:absolute; width:auto;">
            <li class="ui-menu-item" id="consulta"><a href="#">Consultar Usuarios</a></li>
        </ul>
    </div>           
    <div id="consultarUsuarios" title="Usuarios Registrados">
        <div id="datosUsuario">
        </div>
        <div>
            <table width="100%">
                <tr>
                    <td>
                        <input type="button" id="registra" value="Nuevo Usuario">
                    </td>
                    <td>
                        <div id="mensajeConsulta"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div id="registrarUsuarios" title="Nuevo Usuario">
        <div id="dialog-form"> 
            <form action=""../usuario/alta.php" id="formRegUsu" name="formRegUsu" method="post" target="_top">
                <table width="100%" class="ui-corner-all">
                    <tr>
                        <td colspan="2">
                            <label for="NomEntUsu" style="margin-left: 9px;">Nombre:</label>
                            <input type="text" name="NomEntUsu" id="NomEntUsu" class="text ui-widget-content ui-corner-all requerido" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="PwdEntUsu">Password:</label>
                            <input type="password" name="PwdEntUsu" id="PwdEntUsu" class="ui-widget-content ui-corner-all requerido" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <label for="PflEntUsu" style="margin-left: 25px;">Perfil:</label>
                            <select id="PflEntUsu" name="PflEntUsu" class="requerido">
                                <option value=""></option>
                                <option value="ADM">Administrador</option>
                                <option value="USU">Usuario</option>
                            </select>
                        </td>                   
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Crear usuario" />
                        </td>
                        <td id="mensaje">
                            <div id="errorReg">                               
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <div id="modificarUsuarios" title="Modificar usuario">
        <div id="datosMod">
        </div>
    </div>';
}else{
    $ban="USU";
    echo '</div>';
}

?>
</div>
    <div style="position: absolute; right:5px; margin-top: -40px;">
        <img src="images/upgenia_head.png" width="50%" style="float: right;"></img>
    </div>
    
<script type="text/javascript">
    $(window).load(cargaCaracteristicas());
     $( document ).tooltip();
</script>
<div align="center">
    <table width="1325px">
        <tr id ="contenedor">
            <td align="center">
                <div>
                    <div>
                        <button id="inicio">Inicio</button>
                        <button id="clientes">Clientes</button>
                        <button id="proyectos">Proyectos</button>
                        <button id="participantes">Participantes</button>
                        <button id="reportes" onclick="cambiaHtml('reportesView.php');">Reportes</button>
                    </div>
                    <ul style="width: 150px;text-align: left;position: absolute;">
                    <?php if($ban != "USU"){ ?>
                        <li onClick="cambiaHtml('registroCliente.php');"><a href="#"><span class="ui-icon ui-icon-plus"></span>Agregar</a></li>
                    <?php } ?>
                        <li onClick="cambiaHtml('consultaCliente.php');"><a href="#"><span class="ui-icon ui-icon-wrench"></span>Consultar</a></li>
                    </ul>
                    <ul style="width: 150px;text-align: left;position: absolute;">
                    <?php if($ban != "USU"){ ?>
                        <li onClick="cambiaHtml('registroProy.php');"><a href="#"><span class="ui-icon ui-icon-plus"></span>Agregar</a></li>
                    <?php } ?>
                        <li onClick="cambiaHtml('consultaProyecto.php');"><a href="#"><span class="ui-icon ui-icon-wrench"></span>Consultar</a></li>
                    <?php if($ban != "USU"){ ?>
                        <li onclick="cambiaHtml('consultaIngresos.php')"><a href="#"><span class="ui-icon ui-icon-cart"></span>Ingresos</a></li>
                    <?php } ?>
                    </ul>
                    <ul style="width: 150px;text-align: left;position: absolute;">
                    <?php if($ban != "USU"){ ?>
                        <li onClick="cambiaHtml('registroPart.php');"><a href="#"><span class="ui-icon ui-icon-plus"></span>Agregar</a></li>
                    <?php } ?>
                        <li onClick="cambiaHtml('consultaParticipante.php');"><a href="#"><span class="ui-icon ui-icon-wrench"></span>Consultar</a></li>
                        <li onClick="cambiaHtml('registroGastos.php');"><a href="#"><span class="ui-icon ui-icon-cart"></span>Gastos</a></li>
                    </ul>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="classname" align="center"> 
                <div id="workbench" style="margin-top: 41px;">               
                    <img src="images/upgenia.png" style="margin-top: 160px;"/><br />
                    <article class="mensaje"><?php if(isset($_SESSION['mensajeError'])){ echo $_SESSION['mensajeError'];unset($_SESSION['mensajeError']);}else{if(isset($_SESSION['mensajeInfo'])){echo $_SESSION['mensajeInfo'];unset($_SESSION['mensajeInfo']);}}?></article>                          
                </div>               
            </td>
        </tr>
    </table>
</div>
    
</body>
</html>
