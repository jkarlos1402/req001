<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Obtencíon de bancos 														//
// Función del módulo: Obtiene los bancos registrados y los coloca en un select para su uso		//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
session_start();
if(isset($_GET['id'])){
	$id = $_GET['id'];
	if($id != -1){
		$disabled = "disabled='disabled'";
		$index = $_GET['index'];
	}
	else{
		$disabled = "";
		$index = 0;
	}
}else{
		$disabled = "";
		$index = 0;
		$id = -1;
}
$query = "select * from tblentban";//Se obtienen los bancos de la base de datos
$res = mysql_query($query,$conexion);
$bancos = '<label>Banco:
		   <select id="lint_banPoE'.$index.'" name="lint_banPoE'.$index.'" '.$disabled.'><option></option>';
while($banco = mysql_fetch_array($res)){//Se forman las opciones del select
	if($banco['IdEntBan'] == $id){
		$selected = "selected = 'selected'";
	}else
		$selected = "";
	$bancos = $bancos.'<option value="'.$banco['IdEntBan'].'" '.$selected.'>'.$banco['NomEntBan'].'</option>';
}
$bancos = $bancos."</select></label>";
echo $bancos;//Regresa el select