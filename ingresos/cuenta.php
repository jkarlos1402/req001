<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$IdEntPoE = $_POST['IdEntPoE'];
$IdEntBan = $_POST['IdEntBan'];
$padre = $_POST['padre'];
$hijo = $_POST['hijo'];
if(isset($_POST['IdEntCue'])){
    $IdEntCue = $_POST['IdEntCue'];
}else{
    $IdEntCue = -1;
}
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
$perfiles = '<select name="IdEntCue_'.$padre.'_0[]" id="IdEntCue_'.$padre.'_'.$hijo.'_0_">
                <option value=""></option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntCue'].'"';
        if($renglon['IdEntCue']==$IdEntCue){
            $perfiles = $perfiles." selected='selected'";
        }
        $perfiles = $perfiles.'>'.$renglon['NumEntCue'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;