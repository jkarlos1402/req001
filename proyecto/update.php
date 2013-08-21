<?php
session_start();
require_once("../conexion.php");
//Recuperando información necesaria para actualizar el proyecto
$IdEntPry = $_POST['IdEntPry'];
$ltxt_nomPry = $_POST['ltxt_nomPry'];//nombre del proyecto
$ltxt_fecIni = date('Y-m-d',strtotime($_POST['ltxt_fecIni']));//fecha de inicio del proyecto
$ltxt_fecFin = date('Y-m-d',strtotime($_POST['ltxt_fecFin']));//fecha de término del proyecto
$lint_ctoPry = $_POST['lint_ctoPry'];//costo total sin iva del proyecto
$lint_cliePry = $_POST['lint_cliePry'];//identificador del cliente
$lint_pjeUni = $_POST['lint_pjeUni'];//Porcentaje asignado a la UAEMéx
$ltxt_dscPry = $_POST['ltxt_dscPry'];//Descripción del proyecto
if(isset($_POST['lbool_ivaPry']) && $_POST['lbool_ivaPry'] == "on"){
	$lbool_ivaPry = 1;//Indica si se aplicará iva al costo
}else{
	$lbool_ivaPry = 0;
}
$query = "update tblentpry set NomEntPry ='$ltxt_nomPry',FecIniPry= '$ltxt_fecIni',FecTerPry='$ltxt_fecFin',PreEntPry='$lint_ctoPry',IdEntCli='$lint_cliePry',PjeEntPry='$lint_pjeUni',DscEntPry='$ltxt_dscPry',IVAEntPry='$lbool_ivaPry' where IdEntPry = $IdEntPry";
$res = mysql_query($query,$conexion) or die (mysql_error());
if(!$res){
	$_SESSION['mensajeError']="Error: 1 ".mysql_error();
}
$i = 0;
$totFases = $_POST['totFases'];
$ultimaFase = 0;
while(isset($_POST['ltxt_ctoFas'.$i])){
	//recuperando información necesario para agregar fase o entregable
	$ltxt_ctoFas = $_POST['ltxt_ctoFas'.$i];
	$ltxt_fecEnt = date('Y-m-d',strtotime($_POST['ltxt_fecEnt'.$i]));
	if($i < $totFases ){
		$IdEntEtr = $_POST['IdEntEtr'.$i];
		//query para actualizar los registros existentes en la tabla tblentetr
		$query = "update tblentetr set CtoEntEtr = '$ltxt_ctoFas',FecPrgEtr = '$ltxt_fecEnt' where IdEntEtr = $IdEntEtr";
		$res = mysql_query($query,$conexion) or die (mysql_error());
		if(!$res){
			$_SESSION['mensajeError']="Error: 2 ".mysql_error();
		}
		$ultimaFase = $IdEntEtr;
	}else{
		//query para dar de alta el muevo registro en la tabla tblentetr
		$query = "insert into tblentetr (CtoEntEtr,FecPrgEtr,IdEntPry) values ('$ltxt_ctoFas','$ltxt_fecEnt','$IdEntPry')";
		$res = mysql_query($query,$conexion);//se almacena el registro en la bd
		if(!$res){
			$_SESSION['mensajeError']="Error: 3 ".mysql_error();
		}
	}
	$i++;
}
if(($i-1) < $totFases){
	$query = "delete from tblentetr where IdEntEtr > $ultimaFase and IdEntPry = $IdEntPry";
	$res = mysql_query($query,$conexion);
	if(!$res){
		$_SESSION['mensajeError']="Error: 4 ".mysql_error();
	}
}
$i = 0;
$totPagos = $_POST['totPagos'];
$ultimoIdPago = 0;
while(isset($_POST['lint_pjePag'.$i])){
	//recuperando información necesaria para agregar pago
	$ltxt_ctoPag = $_POST['ltxt_ctoPag'.$i];
	$lint_pjePag = $_POST['lint_pjePag'.$i];//porcentaje del consto del proyecto sin IVA
	$lint_subPag = $_POST['lint_totPag'.$i];//monto del pago sin IVA
	$ltxt_fecPag = date('Y-m-d',strtotime($_POST['ltxt_fecPag'.$i]));//fecha programada para realizar el pago
	$fechaProgramada = explode ("-", $ltxt_fecPag);
	$fechaHoy = explode("-",date("Y-m-d"));
	$diasProgramada = gregoriantojd($fechaProgramada[1],$fechaProgramada[2],$fechaProgramada[0]); 
	$diasHoy = gregoriantojd($fechaHoy[1],$fechaHoy[2],$fechaHoy[0]);
	$resta = $diasProgramada - $diasHoy;
	if($resta > 3){
		$query = "select IdEntEst from tblentest where DscEntEst like 'PLANEADO'";//query para obtener el id del estado	
	}
	if($resta <= 3 && $resta >= 0){
		$query = "select IdEntEst from tblentest where DscEntEst like 'PROXIMO A EJECUTAR'";//query para obtener el id del estado
	}
	if($resta < 0){
		$query = "select IdEntEst from tblentest where DscEntEst like 'DESFASADO'";//query para obtener el id del estado
	}
	$res = mysql_query($query,$conexion) or die(mysql_error());//se busca el id del estado
	while($fila = mysql_fetch_array($res)){
		$lint_idEst = $fila['IdEntEst'];//id del estado correspondiente
	}
	if($i < $totPagos){
		$IdEntPag = $_POST['IdEntPag'.$i];
		$query = "select FecEntPagRal from tblentpag where IdEntPag = $IdEntPag limit 1";
		$res = mysql_query($query,$conexion);
		$pago = mysql_fetch_array($res);
		if($pago['FecEntPagRal']==""){
			$query = "update tblentpag set FecEntPagPrg = '$ltxt_fecPag',PorEntPagPrg = '$lint_pjePag',MonEntPagPrg = '$lint_subPag',CtoEntPag = '$ltxt_ctoPag',IdEntEst = '$lint_idEst' where IdEntPag = $IdEntPag";
		}else{
			$query = "update tblentpag set FecEntPagPrg = '$ltxt_fecPag',PorEntPagPrg = '$lint_pjePag',MonEntPagPrg = '$lint_subPag',CtoEntPag = '$ltxt_ctoPag' where IdEntPag = $IdEntPag";
		}
		$ultimoIdPago = $IdEntPag;
		$res = mysql_query($query,$conexion);//se almacena el registro en la bd
		if(!$res){
			$_SESSION['mensajeError']="Error: 5 ".mysql_error();
		}
	}else{
		//query para ingresar el nuevo registro de pago tabla tblentpag
		$query = "insert into tblentpag (FecEntPagPrg,PorEntPagPrg,MonEntPagPrg,CtoEntPag,IdEntPry,IdEntEst) values ('$ltxt_fecPag','$lint_pjePag','$lint_subPag','$ltxt_ctoPag','$IdEntPry','$lint_idEst')";
		$res = mysql_query($query,$conexion);//se agrega nuevo registro de pago
		if(!$res){
		 	$_SESSION['mensajeError']="Error: 6 ".mysql_error();
		}
	}
	$i++; 
}//fin del while isset 
if(($i-1) < $totPagos){
	$query = "delete from tbldsppag where IdEntPag in (select IdEntPag from tblentpag where IdEntPag > $ultimoIdPago)";
	$res = mysql_query($query,$conexion);
	if(!$res){
		$_SESSION['mensajeError']="Error: 7 ".mysql_error();
	}
	$query = "delete from tblentpag where IdEntPag > $ultimoIdPago and IdEntPry = $IdEntPry";
	$res = mysql_query($query,$conexion);
	if(!$res){
		$_SESSION['mensajeError']="Error: 8 ".mysql_error();
	}
}
//se coloca mensaje de éxito en la operación
$_SESSION['mensajeInfo']= "Se actualizó correctamente el proyecto";
header("Location: ../");