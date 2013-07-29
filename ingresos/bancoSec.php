<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$IdEntPoE = $_POST['IdEntPoE'];
$padre = $_POST['padre'];
$hijo = $_POST['hijo'];
$hijosec = $_POST['hijosec'];
$IdEntCue = $_POST['IdEntCue'];
if($IdEntCue != -1){
    $query = "select IdEntSuc from tblentcue where IdEntCue = $IdEntCue limit 1";
    $res = mysql_query($query);
    $sucursal = mysql_fetch_array($res);
    $query = "select IdEntBan from tblentsuc where IdEntSuc =".$sucursal['IdEntSuc']." limit 1";
    $res = mysql_query($query);
    $IdEntBan = mysql_fetch_array($res);
}else{
    $IdEntBan['IdEntBan'] = -1;
}
$query = "select tblentban.IdEntBan, tblentban.NomEntBan
			from tblentban, tblentsuc, tblentcue
			where tblentban.IdEntBan = tblentsuc.IdEntBan AND 
				  tblentsuc.IdEntSuc = tblentcue.IdEntSuc AND
				  tblentcue.IdEntPoE = $IdEntPoE";
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0) //Si no hay registros envia un aviso 
	{
	$perfiles = "<select><option>No hay banco registrados</option></select>";	
	}
	else // Si si hay registros imprime los resultados
	{
$perfiles = '<select name="IdEntBan_'.$padre.'_'.$hijo.'[]" id="IdEntBan_'.$padre.'_'.$hijo.'_'.$hijosec.'_" onchange="consultaCuentaSec('.$IdEntPoE.',this.value,'.$padre.','.$hijo.','.$hijosec.',-1);">
				<option value="-1">Selecciona</option>';
while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdEntBan'].'"';
        if($IdEntBan['IdEntBan'] == $renglon['IdEntBan']){
            $perfiles = $perfiles." selected='selected'";
        }
        $perfiles = $perfiles.'>'.$renglon['NomEntBan'].'</option>';
}
$perfiles = $perfiles."</select>";
	}
echo $perfiles;