<?php
session_start();
require_once("../conexion.php");
//Recuperando información necesaria para agregar proyecto
$ltxt_nomPry = $_POST['ltxt_nomPry'];//nombre del proyecto
$ltxt_fecIni =  date('Y-m-d',strtotime($_POST['ltxt_fecIni']));//fecha de inicio del proyecto
$ltxt_fecFin = date('Y-m-d',strtotime($_POST['ltxt_fecFin']));//fecha de término del proyecto
$lint_ctoPry = $_POST['lint_ctoPry'];//costo total sin iva del proyecto
$lint_cliePry = $_POST['lint_cliePry'];//identificador del cliente
$lint_pjeUni = $_POST['lint_pjeUni'];//Porcentaje asignado a la UAEMéx
$ltxt_dscPry = $_POST['ltxt_dscPry'];//Descripción del proyecto
if($_POST['lbool_ivaPry'] == "on"){
	$lbool_ivaPry = 1;//Indica si se aplicará iva al costo
}else{
	$lbool_ivaPry = 0;
}

//query para dar de alta en la tabla tblentpry
$query = "insert into tblentpry (NomEntPry,FecIniPry,FecTerPry,PreEntPry,IdEntCli,PjeEntPry,DscEntPry,IVAEntPry,EstEntPry) values ('$ltxt_nomPry','$ltxt_fecIni','$ltxt_fecFin','$lint_ctoPry','$lint_cliePry','$lint_pjeUni','$ltxt_dscPry','$lbool_ivaPry','1')";
$res = mysql_query($query,$conexion);//se almacena el proyecto en la bd
if(!$res){
	$_SESSION['mensajeError']="Error: ".mysql_error();
}
$lint_idProy = mysql_insert_id();//id del proyecto almacenado

$i = 0;
while(isset($_POST['ltxt_ctoFas'.$i])){
	//recuperando información necesario para agregar fase o entregable
	$ltxt_ctoFas = $_POST['ltxt_ctoFas'.$i];
	$ltxt_fecEnt =  date('Y-m-d',strtotime($_POST['ltxt_fecEnt'.$i]));
	
	//query para dar de alta el muevo registro en la tabla tblentetr
	$query = "insert into tblentetr (CtoEntEtr,FecPrgEtr,IdEntPry) values ('$ltxt_ctoFas','$ltxt_fecEnt','$lint_idProy')";
	$res = mysql_query($query,$conexion);//se almacena el registro en la bd
	if(!$res){
		$_SESSION['mensajeError']="Error: ".mysql_error();
	}
	$i++;
}
$i = 0;
while(isset($_POST['lint_pjePag'.$i])){
	//recuperando información necesaria para agregar pago
	$ltxt_ctoPag = $_POST['ltxt_ctoPag'.$i];
	$lint_pjePag = $_POST['lint_pjePag'.$i];//porcentaje del consto del proyecto sin IVA
	$lint_subPag = $_POST['lint_subPag'.$i];//monto del pago sin IVA
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
	//query para ingresar el nuevo registro de pago tabla tblentpag
	$query = "insert into tblentpag (FecEntPagPrg,PorEntPagPrg,MonEntPagPrg,CtoEntPag,IdEntPry,IdEntEst) values ('$ltxt_fecPag','$lint_pjePag','$lint_subPag','$ltxt_ctoPag','$lint_idProy','$lint_idEst')";
	echo $query;
	$res = mysql_query($query,$conexion);//se agrega nuevo registro de pago
	if(!$res){
		$_SESSION['mensajeError']="Error: ".mysql_error();
	}
	$i++; 
}//fin del while isset 
//se coloca mensaje de éxito en la operación
$_SESSION['mensajeInfo']= "Se agregó correctamente el nuevo proyecto";
header("Location: ../");