<?php
//**********************************************************************************************//
// Nombre: Juan Carlos Piña Moreno																//
// Nombre del módulo: Alta de empresas o personas 												//
// Función del módulo: Realiza las inserciones necesarias en la base de datos para				//
//                     dar de alta una nueva empresa o persona fisica dentro del corporativo	//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
require_once("../conexion.php");
session_start();
//recuperando los datos necesarios para los registros
$ltxt_nomPoE = $_POST['ltxt_nomPoE'];
$ltxt_dirPoE = $_POST['ltxt_dirPoE'];
$ltxt_RFCPoE = $_POST['ltxt_RFCPoE'];
$ltxt_telPoE = $_POST['ltxt_telPoE'];
$ltxt_extPoE = $_POST['ltxt_extPoE'];
$ltxt_pflPoE = $_POST['ltxt_pflPoE'];
$ltxt_girPoE = $_POST['ltxt_girPoE'];
$ltxt_nomCtoPoE = $_POST['ltxt_nomCtoPoE'];
$ltxt_telCtoPoE = $_POST['ltxt_telCtoPoE'];
$ltxt_extCtoPoE = $_POST['ltxt_extCtoPoE'];
$ltxt_emailCtoPoE = $_POST['ltxt_emailCtoPoE'];

//Agregando la persona o empresa
$query = "insert into tblentpoe (IdEntPoE,NomEntPoE,RFCEntPoE,DirEntPoE,IdEntPfl,GroEntPoE,TelEntPoE,ExtEntPoE,NomCtoPoE,TelCtoPoE,ExtCtoPoE,EmailCtoPoE) values (null,'$ltxt_nomPoE','$ltxt_RFCPoE','$ltxt_dirPoE','$ltxt_pflPoE','$ltxt_girPoE','$ltxt_telPoE','$ltxt_extPoE','$ltxt_nomCtoPoE','$ltxt_telCtoPoE','$ltxt_extCtoPoE','$ltxt_emailCtoPoE')";
mysql_query($query,$conexion) or die (mysql_error());
$lint_idePoE = mysql_insert_id();//se obtiene el id de la persona o empresa registrada

//Agregando la(s) sucursal(es) y cuentas
$contador = 0;
while(isset($_POST['lint_banPoE'.$contador])){
	$lint_banPoE = $_POST['lint_banPoE'.$contador];
	$lint_sucPoE = $_POST['lint_sucPoE'.$contador];
	$lint_ctaPoE = $_POST['lint_ctaPoE'.$contador];
	$ltxt_cbePoE = $_POST['ltxt_cbePoE'.$contador];
	$query = "select IdEntSuc from tblentsuc where SucEntSuc = $lint_sucPoE and IdEntBan = $lint_banPoE";
	$larr_suc = mysql_query($query,$conexion);
	if(mysql_num_rows($larr_suc) == 0){
		//Si no existe la sucursal de un banco entonces se agrega una nueva sucursal
		$query = "insert into tblentsuc (IdEntSuc,SucEntSuc,IdEntBan) values (null,'$lint_sucPoE',$lint_banPoE)";
		mysql_query($query,$conexion) or die (mysql_error());//se agrega la sucursal
		$lint_ideSuc = mysql_insert_id();//se obtiene el id de la sucursal registrada
	}else{
		while($renglon = mysql_fetch_array($larr_suc)){
			$lint_ideSuc = $renglon['IdEntSuc'];
		}
	}
	//Se agrega la cuenta correspondiente
	$query = "insert into tblentcue (IdEntCue,NumEntCue,ClaEntCue,IdEntSuc,IdEntPoE) values (null,'$lint_ctaPoE','$ltxt_cbePoE','$lint_ideSuc','$lint_idePoE')";
	mysql_query($query,$conexion) or die (mysql_error());
	$contador++;
}
$_SESSION['mensajeInfo'] = "Persona o empresa registrada correctamente";
if(mysql_error()!= '') $_SESSION['mensajeError'] = mysql_error();
header("Location: ../index.php");