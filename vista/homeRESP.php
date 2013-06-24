<?php 
$ban;
session_start(); 
//header("Cache-control: private"); //para no perder formularios al dar back
if(!ISSET($_SESSION["k_username"])){
	echo '<SCRIPT LANGUAGE="javascript">
            location.href = "../vista/login.php";
            </SCRIPT>';	

}
//echo $_SESSION["k_username"]."_".$_SESSION["k_perfil"];

//echo '<br><a href="../login/logout.php">Cerrar Sesion</a>';
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
<link rel="stylesheet" type="text/css" href="css/estilos.css">
<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
<div class="ui-buttonset">
<button id="ident"><?php echo $_SESSION["k_username"] ?></button>
<button id="select">Cerrar Sesión</button>
</div>
<?php

if($_SESSION["k_perfil"]=="ADM"){
	$ban="ADM";
echo '<ul class="ui-corner-all ui-widget ui-widget-content" style="position:absolute; width:auto;">
		<li class="ui-menu-item" id="consulta">Consultar Usuarios</li>
		</ul>

<div id="consultarUsuarios" title="Usuarios Registrados">
  <div id="datosUsuario">
  </div>
  <div>
  <input type="button" id="registra" value="Nuevo Usuario">
  </div>
</div>
<div id="registrarUsuarios" title="Nuevo Usuario">
	<div id="dialog-form"> 
	  <form action=""../usuario/alta.php" id="formRegUsu" name="formRegUsu" method="post" target="_top">
	  <table border="1" width="100%" class="ui-corner-all">
	  	<tr>
		<td>
		Nombre
		</td>
		<td>
		<input type="text" name="NomEntUsu" id="NomEntUsu" class="text ui-widget-content ui-corner-all requerido" />
		</td>
		</tr>
		<tr>
		<td>
		Password
		</td>
		<td>
		<input type="text" name="PwdEntUsu" id="PwdEntUsu" value="" class="text ui-widget-content ui-corner-all requerido" />
		</td>
		</tr>
		<tr>
		<td>
		Perfil
		</td>
		<td>
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
		<div id="errorReg" style="visibility:hidden; display:none;">
	  		<div class="ui-widget">
            	<div class="ui-state-error ui-corner-all">
                <p>
                <span class="ui-icon ui-icon-alert" style="float: left;"></span>
                <strong>Error</strong>
                </p>
                </div>
            </div>
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
</div>
';
}
else{
$ban="USU";
}

?>
</div>
<table width="100%">
<tr id ="contenedor">
<td>
	<ul id="mnuindex">
		<li><a href="../" style="text-decoration:none" class="inicio">Inicio</a></li>
		<li>Clientes
			<ul class="submenu">
            <?php
				if($ban!="USU") 
		 echo '<li onClick="cambiaHtml(\'registroCliente.php\')">Agregar</li>';
			?>  
			  <li onClick="cambiaHtml('consultaCliente.php')">Consultar / Modificar</li>
			</ul>
		</li>
		<li>Proyectos
        	<ul class="submenu">
            <?php
				if($ban!="USU") 
			echo'<li onClick="cambiaHtml(\'registroProy.php\')">Agregar</li>';
			?>	
				<li onClick="cambiaHtml('consultaProyecto.php')">Consultar</li>
            <?php
				if($ban!="USU")     
            echo'<li onclick="cambiaHtml(\'consultaIngresos.php\')">Ingresos</li>';
			?>	
			</ul>
		</li>
		<li>Participantes
			<ul class="submenu">
            <?php
				if($ban!="USU") 
			echo'<li onClick="cambiaHtml(\'registroPart.php\')">Agregar</li>';
			?>	
				<li onClick="cambiaHtml('consultaParticipante.php')">Consultar / Modificar</li>
			</ul>
		</li>
		<li>Reportes
		</li>
	</ul>
</td>
</tr>
<tr  >
<td id="workbench" class="classname">
<article class="homeobj">
<img src="images/upgenia.png" style="margin-top: 100px;"><br />
<article class="mensaje"><?php if(isset($_SESSION['mensajeError'])){ echo $_SESSION['mensajeError'];unset($_SESSION['mensajeError']);}else{if(isset($_SESSION['mensajeInfo'])){echo $_SESSION['mensajeInfo'];unset($_SESSION['mensajeInfo']);}}?></article>
</article>
</td>
</tr>
</table>
</body>
</html>
