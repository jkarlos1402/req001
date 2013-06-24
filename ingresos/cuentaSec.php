<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$IdEntPoE = $_POST['IdEntPoE'];
$IdEntBan = $_POST['IdEntBan'];
$padre = $_POST['padre'];
$hijo = $_POST['hijo'];
$hijosec=$_POST['hijosec'];
$query = "select tblentcue.IdEntCue, tblentcue.NumEntCue
			from tblentcue, tblentsuc
			where tblentsuc.IdEntBan =$IdEntBan AND tblentsuc.IdEntSuc = tblentcue.IdEntSuc and tblentcue.IdEntPoE = $IdEntPoE";
		
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0) //Si no hay registros envia un aviso 
	{
	$perfiles = "<select><option>No hay cuentas</option></select>";	
	}
	else // Si si hay registros imprime los resultados
	{
$perfiles = '<select name="IdEntCue_'.$padre.'_'.$hijo.'[]" id="IdEntCue_'.$padre.'_'.$hijo.'_'.$hijosec.'_">';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntCue'].'">'.$renglon['NumEntCue'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;