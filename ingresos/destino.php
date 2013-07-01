<?php
include("../conexion.php");
//Crea y ejecuta la consulta para saber los clientes registrados
$padre = $_POST['padre'];
$hijo = $_POST['hijo'];
$query = "select * from tbldespag";
		
$res = mysql_query($query,$conexion);

if (mysql_num_rows($res) == 0){ //Si no hay registros envia un aviso 
    $perfiles = "<select><option>No hay destinos</option></select>";	
}else{ // Si si hay registros imprime los resultados	
    $perfiles = '<select name="IdDesPag_'.$padre.'_0[]" class="destinoDis" id="IdDesPag_'.$padre.'_'.$hijo.'_0_" onchange="agregaDestino(this.value,'.$padre.','.$hijo.',0);"><option>Selecciona</option>';
    while($renglon = mysql_fetch_array($res)){
	$perfiles = $perfiles.'<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
    }
    $perfiles = $perfiles."<option value='otros'>OTRO...</option></select>";
}
echo $perfiles;
