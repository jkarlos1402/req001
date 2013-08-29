<?php
//**********************************************************************************************//
// Nombre: Regino Tabares       																//
// Nombre del módulo: Obtencíon de proyectos 														//
// Función del módulo: Obtiene los proyectos registrados y los coloca en un select para su uso		//
// Fecha: 10/05/2013																			//
//**********************************************************************************************//
include("../conexion.php");
session_start();
$IdEntPag = $_POST['IdEntPag'];	
$MonEntPagRal = $_POST['MonEntPagRal'];
$PorEntPagRal = $_POST['PorEntPagRal'];
$FecEntPagRal = date("Y-m-d",strtotime($_POST['FecEntPagRal']));
$IdEntMov = $_POST['IdEntMov'];
$IdEntCue = $_POST['IdEntCue'];
if(!isset($_POST['InfEntPag'])){
    $InfEntPag='';
}
else{
    $InfEntPag = $_POST['InfEntPag'];
}
$query = "select IdEntEst from tblentest where DscEntEst like 'EJECUTADO'";
		$res = mysql_query($query,$conexion);
		while($fila = mysql_fetch_array($res)){
			$estado = $fila['IdEntEst'];
		}
$q="SELECT pry.PjeEntPry FROM tblentpag pag
        JOIN tblentpry pry ON pag.IdEntPry = pry.IdEntPry
    WHERE pag.IdEntPag = $IdEntPag";
$res=mysql_query($q);
$pje=  mysql_fetch_array($res);
$SalEntPag = $MonEntPagRal;
$SalEntPag-=(((float)$pje[0]*$MonEntPagRal)/100);
$qry = "SELECT SUM(SalDspPag) FROM tbldsppag WHERE IdEntPag =$IdEntPag";
$res = mysql_query($qry);
$suma = mysql_fetch_array($res);
$SalEntPag -= (float)$suma[0];
$query = "UPDATE tblentpag SET FecEntPagRal=(SELECT STR_TO_DATE('$FecEntPagRal','%Y-%m-%d' )), IdEntEst=$estado, MonEntPagRal = $MonEntPagRal, PorEntPagRal = $PorEntPagRal, IdEntMov =$IdEntMov, IdEntCue=$IdEntCue, InfEntPag='".$InfEntPag."', SalEntPag=$SalEntPag WHERE IdEntPag=$IdEntPag";
$res = mysql_query($query,$conexion) or die(mysql_error());

$que="select temp.IdEntCue,sum(saldo_cuenta) saldo_cuenta from (SELECT c.IdEntCue,
(SELECT IFNULL(sum(p.SalDspPag),0.00) from tbldsppag p where p.IdEntCue = c.IdEntCue) saldo_cuenta
from tblentcue c group by c.IdEntCue
union
select cuenta.IdEntCue,
(select IFNULL(sum(pago.SalEntPag),0.00) from tblentpag pago where pago.IdEntCue = cuenta.IdEntCue) saldo_cuenta
from tblentcue cuenta group by cuenta.IdEntCue
union
select cuenta1.IdEntCue,
(select IFNULL(sum(gasto.MonEntGas)*-1,0.00) from tblentgas gasto where gasto.IdEntCue = cuenta1.IdEntCue) saldo_cuenta
from tblentcue cuenta1 group by cuenta1.IdEntCue
) temp group by temp.IdEntCue";

$res = mysql_query($que) or die(mysql_error());
    while($saldo = mysql_fetch_array($res)){
        $query = "UPDATE tblentcue SET SalEntCue = ".$saldo['saldo_cuenta']." WHERE IdEntCue=".$saldo['IdEntCue']."";
        mysql_query($query) or die(mysql_error());
    }

echo "!Pago Registrado!";

