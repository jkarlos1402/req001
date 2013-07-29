<?php
include("../conexion.php");
$IdEntPago = $_POST['IdEntPag'];//id del pago a registrar dispersiones
$numeroPago = $_POST['numerodePago'];//indice de pago a registratr dispersiones
$totalDispersiones = count($_POST['IdEntPoE_'.$numeroPago.'_0']);//numero de dispersiones en el pago
$totalDispersionesSecundarias = Array();//numero de dispersiones secundarias por cada dispersion
if(isset($_POST['idDispersion'])){
    $idDispersiones = $_POST['idDispersion'];
    $numeroDispersionesEnBase = count($idDispersiones);
}else{
    $numeroDispersionesEnBase = 0;
}
if(isset($_POST['idDispersion'])){
    $dispersionesEnBase = $_POST['idDispersion'];
}
foreach($_POST['numeroDeDispersion'] as $indice){
    if(isset($_POST['IdEntPoE_'.$numeroPago.'_'.$indice])){
        $totalDispersionesSecundarias[] = count($_POST['IdEntPoE_'.$numeroPago.'_'.$indice]);
    }else{
        $totalDispersionesSecundarias[]=0;
    }
}
if($totalDispersiones < $numeroDispersionesEnBase){
    $query = "delete from tbldsppag where IdDspPag > ".$dispersionesEnBase[($totalDispersiones-1)]." and (PadDspPag IS NULL OR PadDspPag > ".$dispersionesEnBase[($totalDispersiones-1)].")";
    $res = mysql_query($query);
}
for($i = 0; $i < $totalDispersiones; $i++){
    if($i < $numeroDispersionesEnBase){
        if($_POST['IdEntCue_'.$numeroPago.'_0'][$i]!== "-1"){
            $query = "update tbldsppag set FecMovDspPag = '".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',MonDspPag = ".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",IdOrgPag = ".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",IdDesPag = ".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",IdEntPag = ".$IdEntPago.",IdEntPoE = ".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",SalDspPag = ".$_POST['saldoDispersion'][$i].",IdEntCue = ".$_POST['IdEntCue_'.$numeroPago.'_0'][$i]." where IdDspPag = ".$dispersionesEnBase[$i];
        }else{
            $query = "update tbldsppag set FecMovDspPag = '".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',MonDspPag = ".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",IdOrgPag = ".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",IdDesPag = ".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",IdEntPag = ".$IdEntPago.",IdEntPoE = ".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",SalDspPag = ".$_POST['saldoDispersion'][$i].",IdEntCue = null where IdDspPag = ".$dispersionesEnBase[$i];
        }
        $res = mysql_query($query);
        $idPadre = $idDispersiones[$i];
    }else{
        if($_POST['IdEntCue_'.$numeroPago.'_0'][$i]!== "-1"){
            $query = "insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag,IdEntCue) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",".$_POST['saldoDispersion'][$i].",".$_POST['IdEntCue_'.$numeroPago.'_0'][$i].")";
        }else{
            $query = "insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",".$_POST['saldoDispersion'][$i].")";
        }
        $res = mysql_query($query);
        $idPadre = mysql_insert_id();
    }
    if(isset($dispersionesEnBase) && $i < count($dispersionesEnBase)){
        $query = "delete from tbldsppag where PadDspPag = ".$dispersionesEnBase[$i];
        $res = mysql_query($query);
    }
    for($j = 0;$j < $totalDispersionesSecundarias[$i];$j++){
        if($_POST['IdEntCue_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j] !=="-1"){
            $query="insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag,IdEntCue,PadDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j]))."',".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdOrgPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdDesPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdEntCue_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$idPadre.")";
        }else{
            $query="insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag,PadDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j]))."',".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdOrgPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdDesPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$idPadre.")";
        }
        $res = mysql_query($query);
    }
    
}
echo "Se han registrado las dipersiones para el pago";
?>