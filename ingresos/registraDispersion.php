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
$dispersionesEnBase = $_POST['idDispersion'];
foreach ($dispersionesEnBase as $idDispersion){
    echo 'Id dispersion: '.$idDispersion.'<br/>';
}
foreach($_POST['numeroDeDispersion'] as $indice){
    if(isset($_POST['IdEntPoE_'.$numeroPago.'_'.$indice]))
        $totalDispersionesSecundarias[] = count($_POST['IdEntPoE_'.$numeroPago.'_'.$indice]);
    else
        $totalDispersionesSecundarias[]=0;
}
for($i = 0; $i < $totalDispersiones; $i++){
    if($i < $numeroDispersionesEnBase){
        if($_POST['IdEntCue_'.$numeroPago.'_0'][$i]!== "-1"){
            $query = "update tbldsppag set FecMovDspPag = '".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',MonDspPag = ".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",IdOrgPag = ".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",IdDesPag = ".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",IdEntPag = ".$IdEntPago.",IdEntPoE = ".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",SalDspPag = ".$_POST['saldoDispersion'][$i].",IdEntCue = ".$_POST['IdEntCue_'.$numeroPago.'_0'][$i];
        }else{
            $query = "update tbldsppag set FecMovDspPag = '".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',MonDspPag = ".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",IdOrgPag = ".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",IdDesPag = ".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",IdEntPag = ".$IdEntPago.",IdEntPoE = ".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",SalDspPag = ".$_POST['saldoDispersion'][$i].",IdEntCue = null";
        }
        //$res = mysql_query($query);
        $idPadre = $idDispersiones[$i];
    }else{
        if($_POST['IdEntCue_'.$numeroPago.'_0'][$i]!== "-1"){
            $query = "insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag,IdEntCue) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",".$_POST['saldoDispersion'][$i].",".$_POST['IdEntCue_'.$numeroPago.'_0'][$i].")";
        }else{
            $query = "insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,SalDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_0'][$i]))."',".$_POST['MonDspPag_'.$numeroPago.'_0'][$i].",".$_POST['IdOrgPag_'.$numeroPago.'_0'][$i].",".$_POST['IdDesPag_'.$numeroPago.'_0'][$i].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_0'][$i].",".$_POST['saldoDispersion'][$i].")";
        }
        //$res = mysql_query($query);
        //$idPadre = mysql_insert_id();
    }
    echo $query."<br/>";
    for($j = 0;$j < $totalDispersionesSecundarias[$i];$j++){
        if($_POST['IdEntCue_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j] !=="-1"){
            $query="insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,IdEntCue,PadDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j]))."',".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdOrgPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdDesPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdEntCue_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$idPadre.")";
        }else{
            $query="insert into tbldsppag (FecMovDspPag,MonDspPag,IdOrgPag,IdDesPag,IdEntPag,IdEntPoE,PadDspPag) values('".date("Y-m-d",strtotime($_POST['FecMovDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j]))."',".$_POST['MonDspPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdOrgPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$_POST['IdDesPag_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$IdEntPago.",".$_POST['IdEntPoE_'.$numeroPago.'_'.$_POST['numeroDeDispersion'][$i]][$j].",".$idPadre.")";
        }
        echo $query."<br/>";
       // $res = mysql_query($query);
    }
    
}
echo "HECHO!!!";
?>