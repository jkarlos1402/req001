 <?php
//**********************************************************************************************//
// Nombre: Regino Tabares																		//
// Nombre del módulo: Modificacion de Participantes 												//
// Función del módulo: Realiza las modificacioners en los datos correspondientes						//
// Fecha: 08/05/2013																			//
//**********************************************************************************************//
	include("../conexion.php");
	session_start();
	$co=0;
	$IdEntPoE=$_POST['IdEntPoE'];
	$NomEntPoE=$_POST['ltxt_nomPoE'];
	$DirEntPoE=$_POST['ltxt_dirPoE'];
	$RFCEntPoE=$_POST['ltxt_RFCPoE'];
	$GroEntPoE=$_POST['ltxt_girPoE'];
	$TelEntPoE=$_POST['ltxt_telPoE'];
	$ExtEntPoE=$_POST['ltxt_extPoE'];
	$IdEntPfl=$_POST['ltxt_pflPoE'];
	$NomCtoPoE=$_POST['ltxt_nomCtoPoE'];
	$TelCtoPoE=$_POST['ltxt_telCtoPoE'];
	$ExtCtoPoE=$_POST['ltxt_extCtoPoE'];
	$EmailCtoPoE=$_POST['ltxt_emailCtoPoE'];
	$bandera = $_POST['totalCuentas'];

	//Query para realizar la modificacion de los datos generales de las empresas 
	$query = "UPDATE tblentpoe set NomEntPoE='$NomEntPoE', DirEntPoE='$DirEntPoE', RFCEntPoE='$RFCEntPoE', GroEntPoE='$GroEntPoE', TelEntPoE='$TelEntPoE', ExtEntPoE='$ExtEntPoE', IdEntPfl=$IdEntPfl, NomCtoPoE='$NomCtoPoE', TelCtoPoE='$TelCtoPoE', ExtCtoPoE='$ExtCtoPoE', EmailCtoPoE='$EmailCtoPoE' where IdEntPoE=$IdEntPoE";
	//echo $query;
	mysql_query($query,$conexion);
	
	
	while(isset($_POST['lint_banPoE'.$co])){
		
		if($co < $bandera)
		{
				
				$query3 = "select IdEntSuc from tblentsuc where SucEntSuc =".$_POST['lint_sucPoE'.$co]." and IdEntBan =".$_POST['lint_banPoE'.$co]."";
				$larr_suc = mysql_query($query3,$conexion);
				if(mysql_num_rows($larr_suc) == 0){ //Si no existe la sucursal de un banco entonces se agrega una nueva sucursal

				$query4 = "insert into tblentsuc (IdEntSuc,SucEntSuc,IdEntBan) values (null,'".$_POST['lint_sucPoE'.$co]."',".$_POST['lint_banPoE'.$co].")";
				mysql_query($query4,$conexion) or die (mysql_error());//se agrega la sucursal
				$lint_ideSuc = mysql_insert_id();//se obtiene el id de la sucursal registrada
				}
				else
				{
					
					while($renglon = mysql_fetch_array($larr_suc))
					{
						$lint_ideSuc = $renglon['IdEntSuc'];
					}
				}
			
		
		$query2 = "UPDATE tblentcue set NumEntCue =".$_POST['lint_ctaPoE'.$co].", ClaEntCue='".$_POST['ltxt_cbePoE'.$co]."', IdEntSuc = $lint_ideSuc where IdEntCue =".$_POST['IdEntCue'.$co];

		mysql_query($query2,$conexion);
		}
		else
		{
		$query3 = "select IdEntSuc from tblentsuc where SucEntSuc =".$_POST['lint_sucPoE'.$co]." and IdEntBan =".$_POST['lint_banPoE'.$co]."";
				$larr_suc = mysql_query($query3,$conexion);
				if(mysql_num_rows($larr_suc) == 0){
					//Si no existe la sucursal de un banco entonces se agrega una nueva sucursal
				$query4 = "insert into tblentsuc (IdEntSuc,SucEntSuc,IdEntBan) values (null,'".$_POST['lint_sucPoE'.$co]."',".$_POST['lint_banPoE'.$co].")";
				mysql_query($query4,$conexion) or die (mysql_error());//se agrega la sucursal
				$lint_ideSuc = mysql_insert_id();//se obtiene el id de la sucursal registrada
				}
				else
				{
					
					while($renglon = mysql_fetch_array($larr_suc))
					{
						$lint_ideSuc = $renglon['IdEntSuc'];
					}
				}
			
			
		$query2 = "INSERT INTO tblentcue (NumEntCue,ClaEntCue,IdEntPoE,IdEntSuc) values(".$_POST['lint_ctaPoE'.$co].",'".$_POST['ltxt_cbePoE'.$co]."',".$IdEntPoE.",$lint_ideSuc)";
		mysql_query($query2,$conexion);
		}
		
		$co++;
		
	}
	
	
	/*if($NomEntCli == null){
		echo "Error.";	
	}
	else
	{
		$query = "UPDATE `tblentcli` SET NomEntCli='$NomEntCli', DirEntCli='$DirEntCli', TelEntCli='$TelEntCli' WHERE IdEntCli=$cliente";
		mysql_query($query); 
		echo"
		<p>Guardando cambios</p>
		<p>REDIRECCIONANDO</p>
		<p>... Espere ... </p>
		<meta http-equiv='Refresh' content='1;url=../vista/consultaCliente.html' />";
	}*/
$_SESSION['mensajeInfo'] = "Participate actualizado correctamente";
header("Location: ../");