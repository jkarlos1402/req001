<?php
include("../conexion.php");

$IdEntPago = $_POST['IdEntPag'];
$numeroPago = $_POST['numerodePago'];
$totalDispersiones = count($_POST['IdEntPoE_'.$numeroPago.'_0']);
$totalDispersionesSecundarias = Array();
foreach($_POST['numeroDeDispersion'] as $indice){
    if(isset($_POST['IdEntPoE_'.$numeroPago.'_'.$indice]))
        $totalDispersionesSecundarias[] = count($_POST['IdEntPoE_'.$numeroPago.'_'.$indice]);
    else
        $totalDispersionesSecundarias[]=0;
}
$query = "insert into tbl"
//echo "total de dispersiones: ".count($_POST[])

/*$a=1;
$b=1;
$j=0;
$padre="";
$disptotales = $_POST['totdisp'];	
$pago = $_POST['pago'];
echo "<br>Disp totales=".$disptotales."<br>PAgo=".$_POST['pago']."<br>Id de pago=".$_POST['IdEntPag'];

for($i=1;$i<=$disptotales;$i++){
	echo "<br>for #".$i;
	while(ISSET($_POST['cve_'.$pago.'_'.$i.'_'.$j.'_'])){
		$caracter=explode("_",$_POST['cve_'.$pago.'_'.$i.'_'.$j.'_']);
		echo "<br>".$caracter[2];
			if($caracter[2]==0){
				$IdEntPoE=$_POST['IdEntPoE_'.$pago.'_'.$i.'_'.$j.'_'];
				$FecMovDspPag=$_POST['FecMovDspPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdOrgPag=$_POST['IdOrgPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntBan=$_POST['IdEntBan_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntCue=$_POST['IdEntCue_'.$pago.'_'.$i.'_'.$j.'_'];
				$MonDspPag=$_POST['MonDspPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdDesPag=$_POST['IdDesPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntPag =$_POST['IdEntPag'];
				$query = "INSERT INTO tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntCue,IdEntPag) values ((SELECT STR_TO_DATE('$FecMovDspPag','%Y-%m-%d' )),$MonDspPag,$IdOrgPag,$IdDesPag,$IdEntCue,$IdEntPag)";
				$res = mysql_query($query,$conexion);
				$padre = mysql_insert_id();
				echo "<br>".$query; 
			}
			else{
					if(ISSET($_POST['IdEntBan_'.$pago.'_'.$i.'_'.$j.'_'])){
						$IdEntPoE=$_POST['IdEntPoE_'.$pago.'_'.$i.'_'.$j.'_'];
				$FecMovDspPag=$_POST['FecMovDspPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdOrgPag=$_POST['IdOrgPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntBan=$_POST['IdEntBan_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntCue=$_POST['IdEntCue_'.$pago.'_'.$i.'_'.$j.'_'];
				$MonDspPag=$_POST['MonDspPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdDesPag=$_POST['IdDesPag_'.$pago.'_'.$i.'_'.$j.'_'];
				$IdEntPag =$_POST['IdEntPag'];
				
				$query = "INSERT INTO tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntCue,IdEntPag,PadDspPag) values ((SELECT STR_TO_DATE('$FecMovDspPag','%Y-%m-%d' )),$MonDspPag,$IdOrgPag,$IdDesPag,$IdEntCue,$IdEntPag,$padre)";
				$res = mysql_query($query,$conexion);
				echo "<br>".$query; 
					}
					else{
					}
				
				
			}
		$j++;
	}
	$j=0;
	
}
*/

/*
$IdEntPoE=$_POST['IdEntPoE'];
$FecMovDspPag=$_POST['FecMovDspPag'];
$IdOrgPag=$_POST['IdOrgPag'];
$IdEntBan=$_POST['IdEntBan'];
$IdEntCue=$_POST['IdEntCue'];
$MonDspPag=$_POST['MonDspPag'];
$IdDesPag=$_POST['IdDesPag'];
$IdEntPag = $_POST['IdEntPag'];
/*$query = "INSERT INTO tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntCue,IdEntPag) values ((SELECT STR_TO_DATE('$FecMovDspPag','%Y-%m-%d' )),$MonDspPag,$IdOrgPag,$IdDesPag,$IdEntCue,$IdEntPag)";
$res = mysql_query($query,$conexion);
echo mysql_insert_id();*/
?>