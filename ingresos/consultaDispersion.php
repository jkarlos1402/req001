<?php
include("../conexion.php");
		
$IdEntPry=$_POST['IdEntPry'];
$IdEntPag=$_POST['pago'];


/*echo '	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/funciones.js"></script>
		<link rel="stylesheet" type="text/css" href="../vista/css/estilos.css">
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">	
		';*/
//************************************
$consulta="SELECT * 
		FROM tblentpry, tblentcli WHERE tblentcli.IdEntCli = tblentpry.IdEntCli and tblentpry.IdEntPry=$IdEntPry";
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());


$consultaorig = "SELECT * 
		FROM tblorgpag;
		";
$resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());

//************************************
$consultaban = "SELECT * 
		FROM tblentban;
		";
$resultadoban=mysql_query("$consultaban",$conexion) or die (mysql_error());

$i=1;


echo '<h2 align="center" class="encabezado">CONSULTA DE DISPERSIÓN DE PAGOS</h2>
		<div align="center">';
		$renglon = mysql_fetch_array($resultado);
		echo '	<table>
					<tr>
						<td>
						Cliente
						</td>
						<td>
						'.$renglon['NomEntCli'].'
						</td>
					</tr>
					<tr>
						<td>
						Proyecto: 
						</td>
						<td>
						'.$renglon['NomEntPry'].'
						</td>
					</tr>
				</table>'; 
			echo'	<h2 align="center" class="encabezado">PROGRAMACIÓN DE PAGOS</h2>
			<div id="accordion">';
                                    
                                    for($i=1;$i<=count($IdEntPag);$i++){
                                    if(!isset($IdEntPag[$i])){
                                            break;
                                        }
                                        
                                        //************************************
                                        $consultadisp="SELECT MonEntPagRal,MonEntPagPrg,CtoEntPag,FecEntPagPrg,FecEntPagRal FROM tblentpag WHERE IdEntPag =$IdEntPag[$i]";
                                        $resultadodisp=mysql_query("$consultadisp",$conexion) or die (mysql_error());
                                        //************************************
					while($renglongeneral = mysql_fetch_array($resultadodisp))
					{
                                                
						if($renglongeneral['FecEntPagRal']!=null){
                                                    $monto =$renglongeneral['MonEntPagRal'];
                                                    $monto=(float)$monto-(($monto*$renglon['PjeEntPry'])/100);
                                                }else{
                                                    $monto =$renglongeneral['MonEntPagPrg'];
                                                    $monto=(float)$monto-(($monto*$renglon['PjeEntPry'])/100);
                                                      }
						echo '
							<h3>'.$renglongeneral['CtoEntPag'].'</h3>
							<div>
								<table cellpadding="3" align="center" width="100%">
									<tr align="center">
										<td>
											Pago
										</td>
										<td>
											Concepto
										</td>
										<td>
											Fecha Programada de Pago
										</td>
										<td>
											Fecha de Cobro
										</td>
										<td>
											Monto
										</td>
									</tr>
									<tr align="center">
										<td>
											'.$i.'
										</td>
										<td>
											'.$renglongeneral['CtoEntPag'].'
										</td>
										<td>
											'.date('d-m-Y',strtotime($renglongeneral['FecEntPagPrg'])).'
										</td>
										<td>
											';
                                                                                          if($renglongeneral['FecEntPagRal']){
                                                                                            echo date('d-m-Y',strtotime($renglongeneral['FecEntPagRal']));
                                                                                          }
                                                                                        echo '
										</td>
										<td>
											$'.$monto.'
										</td>
								</tr>
								</table>
                                                                <br>
                                                                <br>
                                                                
								';
                                                echo '          <div id="controlDispersion">
                                                                    <table class="ui-widget" border="0" cellpadding="0" align="center" style="width: 1225px;">
                                                                        <tr>
                                                                            <td width="50px">
                                                                                    Destino
                                                                            </td>
                                                                            <td width="220px">
                                                                                    Empresa o Persona Física
                                                                            </td>
                                                                            <td width="100px">
                                                                                    Fecha de movimiento
                                                                            </td>
                                                                            <td width="160px">
                                                                                    Tipo de Movimiento
                                                                            </td>
                                                                            <td width="150px">
                                                                                    Banco
                                                                            </td>
                                                                            <td width="150px">
                                                                                    Cuenta
                                                                            </td>
                                                                            <td width="100px">
                                                                                    Monto
                                                                            </td>
                                                                            <td width="220px">
                                                                                    Destino
                                                                            </td>
                                                                        </tr>
                                                                    </table>';
                                                
                                                        $query = "select PadDspPag,IdDspPag,IdEntPoE,FecMovDspPag,IdOrgPag,IdEntCue,MonDspPag,SalDspPag,IdDesPag from tbldsppag where IdEntPag = $IdEntPag[$i] and PadDspPag is NULL";
                                                        $dispersiones = mysql_query($query);
                                                        $numeroRegistrados = mysql_num_rows($dispersiones);
                                                        $h = 1;
                                                        if($numeroRegistrados > 0){
                                                        /////////// AQUI COMIENZAN LOS QUE YA ESTAN EN LA BASE DE DATOS
                                                        while ($dispersion = mysql_fetch_array($dispersiones)) {
                                                            if($dispersion['PadDspPag']==NULL){
                                                            echo '<div id="divDispersion" style="width: 1225px;">
                                                                    <table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
                                                                        <tr id="dispersion'.$i.'" bgcolor="5EBA67">	
                                                                            <td width="50px">
                                                                                '.$i.'.'.$h.'
                                                                            </td>
                                                                            <td width="220px">';
                                                                                //************************************POE agregado en base
                                                                                $consultapoe = "SELECT IdEntPoE,NomEntPoE FROM tblentpoe where IdEntPoE=".$dispersion['IdEntPoE'];
                                                                                //************************************	
                                                                                $resultadopoe=mysql_query($consultapoe) or die (mysql_error());
                                                                                while($renglon = mysql_fetch_array($resultadopoe)){
                                                                                    echo $renglon['NomEntPoE'];
                                                                                }
                                                                            echo'</td>
                                                                            <td width="100px">
                                                                                '.date('d-m-Y',strtotime($dispersion['FecMovDspPag'])).'
                                                                            </td>
                                                                            <td width="160px">';
                                                                                //************************************Origen pago ya en base
                                                                                $consultaorig = "SELECT IdOrgPag,DscOrgPag FROM tblorgpag WHERE IdOrgPag=".$dispersion['IdOrgPag'];
                                                                                //*************************************		
                                                                                $resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());
                                                                                while($renglon = mysql_fetch_array($resultadoorig)){
                                                                                    
                                                                                    echo $renglon['DscOrgPag'];
                                                                                }
                                                                                    echo '
                                                                            </td>';
                                                                            if($dispersion['IdEntCue']!= NULL){
                                                                                $query="SELECT cue.NumEntCue,ban.NomEntBan FROM tblentcue cue
                                                                                JOIN tblentsuc suc on cue.IdEntSuc = suc.IdEntSuc
                                                                                Join tblentban ban on suc.IdEntBan = ban.IdEntBan
                                                                                WHERE cue.IdEntCue =".$dispersion['IdEntCue'] ;
                                                                                $resultadoCue=mysql_query("$query",$conexion) or die (mysql_error());
                                                                                $renglonCue=  mysql_fetch_array($resultadoCue);
                                                                                echo '<td width="150px">
                                                                                      '.$renglonCue['NomEntBan'].'  
                                                                                      </td>
                                                                                      <td width="150px">
                                                                                      '.$renglonCue['NumEntCue'].'
                                                                                      </td>';
                                                                            }else{
                                                                                echo '<td width="150px"></td>
                                                                                      <td width="150px">
                                                                                          
                                                                                      </td>';
                                                                            }
                                                                            echo '<td width="100px">
                                                                                    $'.$dispersion['MonDspPag'].'
                                                                                </td>
                                                                                <td width="220px">';
                                                                            //***************************************************************En base de datos
                                                                            $consultades = "SELECT IdDesPag,DscDesPag FROM tbldespag WHERE IdDesPag=".$dispersion['IdDesPag'];
                                                                            $resultadodes=mysql_query($consultades) or die (mysql_error());
                                                                                while($renglon = mysql_fetch_array($resultadodes)){
                                                                                        echo $renglon['DscDesPag'];
                                                                                }
                                                                                    echo '
                                                                                </td>
                                                                                </tr>';
                                                                            $query = "select IdEntPoE,FecMovDspPag,IdOrgPag,IdEntCue,MonDspPag,IdDesPag from tbldsppag where PadDspPag = ".$dispersion['IdDspPag'];
                                                                            $dispersionesSecundarias = mysql_query($query);
                                                                            $numeroDispersionesSec = mysql_num_rows($dispersionesSecundarias);
                                                                            $j = 1;
                                                                            if($numeroDispersionesSec > 0){
                                                                                while($dispersionSecundaria = mysql_fetch_array($dispersionesSecundarias)){
                                                                                    echo '<tr class="dispSec" align="left" bgcolor="A9F5A9">
                                                                                            <td width="50px">
                                                                                                '.$i.'.'.$h.'.'.$j.'
                                                                                            </td>
                                                                                            <td width="220px">';
                                                                                    //************************************POE agregado en base
                                                                                    $consultapoe = "SELECT IdEntPoE,NomEntPoE FROM tblentpoe where IdEntPoE=".$dispersionSecundaria['IdEntPoE'];
                                                                                    //************************************	
                                                                                    $resultadopoe=mysql_query($consultapoe) or die (mysql_error());
                                                                                       
                                                                                        while($renglon = mysql_fetch_array($resultadopoe)){
                                                                                            
                                                                                            echo $renglon['NomEntPoE'];
                                                                                        }
                                                                                        echo '
                                                                                            </td>
                                                                                            <td width="100px"> 
                                                                                                '.date('d-m-Y',strtotime($dispersionSecundaria['FecMovDspPag'])).'
                                                                                            </td>
                                                                                            <td width="160px">';
                                                                                            //************************************Origen pago ya en base
                                                                                            $consultaorig = "SELECT IdOrgPag,DscOrgPag FROM tblorgpag WHERE IdOrgPag=".$dispersionSecundaria['IdOrgPag'];
                                                                                            //*************************************		
                                                                                            $resultadoorig=mysql_query($consultaorig) or die (mysql_error());
                                                                                           
                                                                                            while($renglon = mysql_fetch_array($resultadoorig)){
                                                                                                
                                                                                                echo $renglon['DscOrgPag'];
                                                                                            }
                                                                                            echo '
                                                                                            </td>';
                                                                                            if($dispersionSecundaria['IdEntCue']!= NULL){
                                                                                                $query="SELECT cue.NumEntCue,ban.NomEntBan FROM tblentcue cue
                                                                                                JOIN tblentsuc suc on cue.IdEntSuc = suc.IdEntSuc
                                                                                                Join tblentban ban on suc.IdEntBan = ban.IdEntBan
                                                                                                WHERE cue.IdEntCue =".$dispersionSecundaria['IdEntCue'] ;
                                                                                                $resultadoCue=mysql_query("$query",$conexion) or die (mysql_error());
                                                                                                $renglonCue=  mysql_fetch_array($resultadoCue);
                                                                                                echo '<td width="150px">
                                                                                                      '.$renglonCue['NomEntBan'].'  
                                                                                                      </td>
                                                                                                      <td width="150px">
                                                                                                      '.$renglonCue['NumEntCue'].'
                                                                                                      </td>';
                                                                                        }else{
                                                                                            echo '<td width="150px"></td>
                                                                                                  <td width="150px">

                                                                                                  </td>';
                                                                                        }
                                                                                            echo '<td width="100px">
                                                                                                    $'.$dispersionSecundaria['MonDspPag'].'
                                                                                                  </td>
                                                                                                  <td width="220px">';
                                                                                            //***************************************************************
                                                                                            $consultades = "SELECT DscDesPag,IdDesPag FROM tbldespag WHERE IdDesPag=".$dispersionSecundaria['IdDesPag'];
                                                                                            $resultadodes=mysql_query($consultades) or die (mysql_error());
                                                                                           
                                                                                            while($renglon = mysql_fetch_array($resultadodes)){
                                                                                                
                                                                                                    echo $renglon['DscDesPag'];
                                                                                                }
                                                                                            }
                                                                                            echo '
                                                                                                </td>
                                                                                                </tr>';
                                                                                            $j++;
                                                                                        }//fin del while que contiene las dispersiones en base
                                                                            }
                                                                            echo '</table>
                                                                                
                                                                            </div>
                                                                            ';//aqui termina el div de los que ya estan en base
                                                                        $h++;
                                                                        
                                                                }
                                                                
                                                        }
                                                        
                                                        else{
                                                            echo 'Aun no hay dispersiones programas';
                                                        }
                                              echo  '</div>
                                                  </div>';          
                                        }
                                    }
                                    
                    echo '
                        </div>
                        <div style="position:relative; margin-top:10px;">
                        <input type="button" value="Regresar" onClick="cambiaHtml(\'consultaProyecto.php?IdEntPry='.$IdEntPry.'\')";">
                        </div>
    ';
								