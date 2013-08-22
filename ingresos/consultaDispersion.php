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

//************************************
$consultadisp="SELECT MonEntPagRal,MonEntPagPrg,CtoEntPag,FecEntPagPrg,FecEntPagRal FROM tblentpag WHERE IdEntPag =$IdEntPag";
$resultadodisp=mysql_query("$consultadisp",$conexion) or die (mysql_error());
//************************************
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
		while($renglon = mysql_fetch_array($resultado))
		{
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
		}
				
			echo'	<h2 align="center" class="encabezado">PROGRAMACIÓN DE PAGOS</h2>
			<div id="accordion">';
									
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
											'.$renglongeneral['FecEntPagPrg'].'
										</td>
										<td>
											'.$renglongeneral['FecEntPagRal'].'
										</td>
										<td>
											$'.$monto.'
										</td>
								</tr>
								</table>
                                                                <br>
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
                                                
                                                        $query = "select PadDspPag,IdDspPag,IdEntPoE,FecMovDspPag,IdOrgPag,IdEntCue,MonDspPag,SalDspPag,IdDesPag from tbldsppag where IdEntPag = $IdEntPag and PadDspPag is NULL";
                                                        $dispersiones = mysql_query($query);
                                                        $numeroRegistrados = mysql_num_rows($dispersiones);
                                                        $h = 1;
                                                        if($numeroRegistrados > 0){
                                                        /////////// AQUI COMIENZAN LOS QUE YA ESTAN EN LA BASE DE DATOS
                                                        while ($dispersion = mysql_fetch_array($dispersiones)) {
                                                            if($dispersion['PadDspPag']==NULL){
                                                            echo '<div id="divDispersion" style="width: 1225px;">
                                                                    <table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
                                                                        <tr id="dispersion'.$i.'" bgcolor="01DF01">	
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
                                                                                echo '<td width="150px" id="datosbanco'.$i.$h.'">
                                                                                        
                                                                                      </td>
                                                                                      <td width="150px" id="datoscuenta'.$i.$h.'">
                                                                                      </td>';
                                                                            }else{
                                                                                echo '<td width="150px" id="datosbanco'.$i.$h.'"></td>
                                                                                      <td width="150px" id="datoscuenta'.$i.$h.'">
                                                                                          <input type="hidden" name="IdEntCue_'.$i.'_0[]" value="-1">
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
                                                                                echo '<script type="text/javascript">
                                                                                        $("#agrega'.$i.$h.'").button({icons: {primary: "ui-icon-plusthick"},text: false}).css({"visibility":"visible","display":""});
                                                                                      </script>';
                                                                                while($dispersionSecundaria = mysql_fetch_array($dispersionesSecundarias)){
                                                                                    echo '<tr  id="dispSec'.$i.$h.$j.'" class="dispSec" align="left" bgcolor="A9F5A9">
                                                                                            <td width="50px">
                                                                                                '.$i.'.'.$h.'.'.$j.'
                                                                                            </td>
                                                                                            <td width="220px">';
                                                                                    //************************************POE agregado en base
                                                                                    $consultapoe = "SELECT IdEntPoE,NomEntPoE FROM tblentpoe where EstEntPoE = 1";
                                                                                    //************************************	
                                                                                    $resultadopoe=mysql_query($consultapoe) or die (mysql_error());
                                                                                        echo '<select name="IdEntPoE_'.$i.'_'.$h.'[]" id="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_" onchange="habilitaOrigen(this,'.$i.','.$h.','.$j.');">
                                                                                                <option value="-1">Selecciona</option>';
                                                                                        while($renglon = mysql_fetch_array($resultadopoe)){
                                                                                            echo '<option value="'.$renglon['IdEntPoE'].'"';
                                                                                            if($dispersionSecundaria['IdEntPoE'] === $renglon['IdEntPoE'])
                                                                                                echo 'selected="selected"';
                                                                                            echo'>'.$renglon['NomEntPoE'].'</option>';
                                                                                        }
                                                                                        echo '</select>
                                                                                            </td>
                                                                                            <td width="100px"> 
                                                                                                <input type="fecha" id="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" name="FecMovDspPag_'.$i.'_'.$h.'[]" placeholder="Ingrese fecha" size="11" value="'.date('d-m-Y',strtotime($dispersionSecundaria['FecMovDspPag'])).'"/>
                                                                                            </td>
                                                                                            <td width="160px">';
                                                                                            //************************************Origen pago ya en base
                                                                                            $consultaorig = "SELECT IdOrgPag,DscOrgPag FROM tblorgpag";
                                                                                            //*************************************		
                                                                                            $resultadoorig=mysql_query($consultaorig) or die (mysql_error());
                                                                                            echo '<select name="IdOrgPag_'.$i.'_'.$h.'[]" id="IdOrgPag_'.$i.'_'.$h.'_'.$j.'_" class="origenSec" onchange="agregaOrigen(this,'.$i.','.$h.','.$j.');">
                                                                                                    <option></option>';
                                                                                            while($renglon = mysql_fetch_array($resultadoorig)){
                                                                                                echo '<option value="'.$renglon['IdOrgPag'].'"';
                                                                                                if($dispersionSecundaria['IdOrgPag']=== $renglon['IdOrgPag'])
                                                                                                    echo 'selected="selected"';
                                                                                                echo'>'.$renglon['DscOrgPag'].'</option>';
                                                                                            }
                                                                                            echo '</select>
                                                                                            </td>';
                                                                                            if($dispersionSecundaria['IdEntCue']!= NULL){
                                                                                                echo '<td width="150px" id="datosbanco'.$i.$h.$j.'">
                                                                                                        
                                                                                                      </td>
                                                                                                      <td width="150px" id="datoscuenta'.$i.$h.$j.'">
                                                                                                      </td>';
                                                                                            }else{
                                                                                                echo '<td width="150px" id="datosbanco'.$i.$h.$j.'">
                                                                                                      </td>
                                                                                                      <td width="150px" id="datoscuenta'.$i.$h.$j.'">
                                                                                                          <input type="hidden" name="IdEntCue_'.$i.'_'.$h.'[]" value="-1">
                                                                                                      </td>';
                                                                                            }
                                                                                            echo '<td width="100px">
                                                                                                    $<input type="text" class="montoSecundaria" id="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" name="MonDspPag_'.$i.'_'.$h.'[]" placeholder="Ingrese Monto" onBlur="validaTotal('.$i.');" size="11" value="'.$dispersionSecundaria['MonDspPag'].'"/>
                                                                                                  </td>
                                                                                                  <td width="220px">';
                                                                                            //***************************************************************
                                                                                            $consultades = "SELECT DscDesPag,IdDesPag FROM tbldespag";
                                                                                            $resultadodes=mysql_query($consultades) or die (mysql_error());
                                                                                            echo '<select name="IdDesPag_'.$i.'_'.$h.'[]" class="destinoSec" id="IdDesPag_'.$i.'_'.$h.'_'.$j.'_" >
                                                                                                       <option value=""></option>';
                                                                                            while($renglon = mysql_fetch_array($resultadodes)){
                                                                                                if($renglon['DscDesPag'] !== "TRANSFERIRLOS A UNA CUENTA" && $renglon['DscDesPag'] !== "REGRESAR EFECTIVO"){
                                                                                                    echo '<option value="'.$renglon['IdDesPag'].'"';
                                                                                                    if($dispersionSecundaria['IdDesPag']===$renglon['IdDesPag']){
                                                                                                        echo ' selected = "selected"';
                                                                                                    }
                                                                                                    echo '>'.$renglon['DscDesPag'].'</option>';
                                                                                                }
                                                                                            }
                                                                                            echo '</select>
                                                                                                </td>
                                                                                                <td>';
                                                                                            if($j > 1){
                                                                                                echo '<li id="eliminaSec'.$i.$h.$j.'" onclick=eliminaDispersionSec('.$i.','.$h.','.$j.');></li>
                                                                                                    <script type="text/javascript">
                                                                                                        $("#eliminaSec'.$i.$h.$j.'").button({icons: {primary: "ui-icon-trash"},text: false});
                                                                                                    </script>';
                                                                                            }
                                                                                            echo '</td>
                                                                                                </tr>';
                                                                                            $j++;
                                                                                        }//fin del while que contiene las dispersiones en base
                                                                            }else{
                                                                                echo '<tr id="dispSec'.$i.$h.$j.'" class="dispSec" align="left" style="visibility:hidden; display:none;" bgcolor="A9F5A9">
                                                                                        <td width="50px">
                                                                                        '.$i.'.'.$h.'.'.$j.'
                                                                                        </td>
                                                                                        <td width="220px">';
                                                                                        //************************************
                                                                                        $consultapoe = "SELECT IdEntPoE,NomEntPoE FROM tblentpoe where EstEntPoE = 1";
                                                                                        //************************************		
                                                                                        $resultadopoe=mysql_query($consultapoe) or die (mysql_error());
                                                                                        echo '<select name="IdEntPoE_'.$i.'_'.$h.'[]" disabled="disabled" id="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_"  onchange="habilitaOrigen(this,'.$i.','.$h.','.$j.');" >
                                                                                                        <option value="-1">Selecciona</option>';
                                                                                        while($renglon = mysql_fetch_array($resultadopoe)){
                                                                                            echo '<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
                                                                                        }
                                                                                        echo '</select>
                                                                                        </td>
                                                                                        <td width="100px"> 
                                                                                                <input type="fecha" disabled="disabled" id="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" name="FecMovDspPag_'.$i.'_'.$h.'[]" placeholder="Ingrese fecha" size="11">
                                                                                        </td>
                                                                                        <td width="160px">';
                                                                                        //************************************
                                                                                        $consultaorig = "SELECT IdOrgPag,DscOrgPag FROM tblorgpag";
                                                                                        //*************************************		
                                                                                        $resultadoorig=mysql_query($consultaorig) or die (mysql_error());
                                                                                        echo '<select name="IdOrgPag_'.$i.'_'.$h.'[]" disabled="disabled" class="origenDis" id="IdOrgPag_'.$i.'_'.$h.'_'.$j.'_" onchange="agregaOrigen(this,'.$i.','.$h.','.$j.');" style="visibility:hidden; display:none;">
                                                                                                <option></option>';
                                                                                        while($renglon = mysql_fetch_array($resultadoorig)){
                                                                                            echo '<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
                                                                                        }
                                                                                        echo '</select>
                                                                                        </td>
                                                                                        <td id="datosbanco'.$i.$h.$j.'" width="150px"></td>
                                                                                        <td id="datoscuenta'.$i.$h.$j.'" width="150px"></td>
                                                                                        <td width="100px">
                                                                                            $<input type="text" class="montoSecundaria" disabled="disabled" id="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" name="MonDspPag_'.$i.'_'.$h.'[]" placeholder="Ingrese Monto" onBlur="validaTotal('.$i.');" size="11"/>
                                                                                        </td>
                                                                                        <td width="220px">';
                                                                                        //***************************************************************
                                                                                        $consultades = "SELECT IdDesPag,DscDesPag FROM tbldespag";
                                                                                        $resultadodes=mysql_query($consultades) or die (mysql_error());
                                                                                        echo '<select name="IdDesPag_'.$i.'_'.$h.'[]" disabled="disabled" class="destinoSec" id="IdDesPag_'.$i.'_'.$h.'_'.$j.'_" >
                                                                                                   <option value=""></option>';
                                                                                        while($renglon = mysql_fetch_array($resultadodes)){
                                                                                            if($renglon['DscDesPag'] !== "TRANSFERIRLOS A UNA CUENTA" && $renglon['DscDesPag'] !== "REGRESAR EFECTIVO"){
                                                                                                echo '<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
                                                                                            }
                                                                                        }
                                                                                        echo '</select>
                                                                                        </td>
                                                                                        <td>
                                                                                        </td>
                                                                                     </tr>';
                                                                            }
                                                                            echo '</table>
                                                                                <input type="hidden" class="controlDispersion" id="numeroDeDispersion'.$i.$h.'" name="numeroDeDispersion[]" value="'.$h.'"/>
                                                                                <input type="hidden" id="numeroDeDispersionesSec'.$i.$h.'" value="'.$numeroDispersionesSec.'"/>
                                                                            </div>';//aqui termina el div de los que ya estan en base
                                                                        $h++;
                                                                }
                                                            }
                        /////////// AQUI TERMINAN LOS QUE YA ESTAN EN LA BASE DE DATOS
                        }
								//Aqui va la consulta para despues incrementar a h
							/*	
							echo '
									<table border="1" cellpadding="3" align="center" width="100%">
										<tr>
											<td colspan="7">
											<article id="error'.$i.'"></article>
											</td>
											<td>
												<input type="button" id="agregar" onclick="agregaDispersion('.$i.','.$h.')" value="Programar otra dispersión">
											</td>
											<td>
											<input type="button" id="guardar" onclick="guardarPagos('.$i.','.$Idpago[$i].')" value="Guardar">
											</td>
										</tr>
										<tr align="center">
											<td>
												Destino
											</td>
											<td>
												Empresa o Persona Física
											</td>
											<td>
												Fecha de movimiento
											</td>
											<td>
												Tipo de Movimiento
											</td>
											<td>
												Banco
											</td>
											<td>
												Cuenta
											</td>
											<td>
												Monto
											</td>
											<td>
												Destino
											</td>
											<td>
											</td>
										</tr>
										<tr align="center" id="dispersion'.$i.$h.'" bgcolor="01DF01">	
											<td>
											<input type="text" id="cve_'.$i.'_'.$h.'_'.$j.'_" name="cve_'.$i.'_'.$h.'_'.$j.'_" value="'.$i.'_'.$h.'_0_" size="3" disabled="disabled">
											</td>
											<td>
											<select name="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_" id="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_" onchange="consultaBanco(this.value,'.$i.','.$h.')">
														<option>Selecciona</option>';
														//************************************
												$consultapoe = "SELECT * 
														FROM tblentpoe;
														";
												//************************************		
												$resultadopoe=mysql_query("$consultapoe",$conexion) or die (mysql_error());
														
												while($renglon = mysql_fetch_array($resultadopoe))
													{
														$selected="";
														if($renglon['IdEntPoE']==$renglongeneral['IdEntPoE']){
														$selected="selected ='selected'";	
														}
														echo '<option value="'.$renglon['IdEntPoE'].'" '.$selected.'>'.$renglon['NomEntPoE'].'</option>';
													}
												echo '</select>';
									echo	'</td>
											<td>
												<input type="fecha" id="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" name="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" placeholder="Ingrese fecha" required value="'.$renglongeneral['FecMovDspPag'].'">
											</td>
											<td>';
												//************************************
												$consultaorig = "SELECT * 
														FROM tblorgpag;
														";
												//*************************************		
												$resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());
												echo '<select name="IdOrgPag_'.$i.'_'.$h.'_0_" id="IdOrgPag_'.$i.'_'.$h.'_0_" onchange="agregaOrigen(this.value)">';
												while($renglon = mysql_fetch_array($resultadoorig))
													{
														echo '<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>';
									echo	'</td>
											<td id="datosbanco'.$i.$h.'">
												
											</td>
											<td id="datoscuenta'.$i.$h.'">
											</td>
											<td>
												<input type="text" id="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" name="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" placeholder="Ingrese Monto" required onBlur="validaTotal('.$i.')" value="'.$renglongeneral['MonDspPag'].'"/>
											</td>
											<td>';
											//***************************************************************
												$consultades = "SELECT * 
														FROM tbldespag;
														";
												$resultadodes=mysql_query("$consultades",$conexion) or die (mysql_error());
												echo '<select name="IdDesPag_'.$i.'_'.$h.'_0_" id="IdDesPag_'.$i.'_'.$h.'_0_" onchange="agregaDestino(this.value,'.$i.','.$h.','.$j.')">';
												while($renglon = mysql_fetch_array($resultadodes))
													{
														echo '<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>';
												
									echo	'</td>
											<td id="agrega'.$i.$h.'" onclick="agregaDispersionSecundaria('.$i.','.$h.','.$j.')"  style="visibility:hidden; display:none;">
												(+)
											</td>
										</tr>
										<tr id="dispSec'.$i.$h.$j.'" align="center" style="visibility:hidden; display:none;" bgcolor="A9F5A9">
										
										
										
											<td>
											<input type="text" id="cve_'.$i.'_'.$h.'_1_" name="cve_'.$i.'_'.$h.'_1_" value="'.$i.'_'.$h.'_1_" size="3" disabled="disabled">
											</td>
											<td>';
											
												//************************************
												$consultapoe = "SELECT * 
														FROM tblentpoe;
														";
												//************************************		
												$resultadopoe=mysql_query("$consultapoe",$conexion) or die (mysql_error());
												echo '<select name="IdEntPoE_'.$i.'_'.$h.'_1_" id="IdEntPoE_'.$i.'_'.$h.'_1_"  onchange="consultaBancoSec(this.value,'.$i.','.$h.','.$j.')">
														<option>Selecciona</option>';
												while($renglon = mysql_fetch_array($resultadopoe))
													{
														echo '<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
													}
												echo '</select>';
									echo	'</td>
											<td>
												<input type="fecha" id="FecMovDspPag_'.$i.'_'.$h.'_1_" name="FecMovDspPag_'.$i.'_'.$h.'_1_" placeholder="Ingrese fecha" required>
											</td>
											<td>';
												//************************************
												$consultaorig = "SELECT * 
														FROM tblorgpag;
														";
												//*************************************		
												$resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());
												echo '<select name="IdOrgPag_'.$i.'_'.$h.'_1_" id="IdOrgPag_'.$i.'_'.$h.'_1_" onchange="agregaOrigen(this.value)">';
												while($renglon = mysql_fetch_array($resultadoorig))
													{
														echo '<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>';
									echo	'</td>
											<td id="datosbanco'.$i.$h.$j.'">
												
											</td>
											<td id="datoscuenta'.$i.$h.$j.'">
											</td>
											<td>
												<input type="text" id="MonDspPag_'.$i.'_'.$h.'_1_" name="MonDspPag_'.$i.'_'.$h.'_1_" placeholder="Ingrese Monto" required onBlur="validaTotal('.$i.')"/>
											</td>
											<td>';
											//***************************************************************
												$consultades = "SELECT * 
														FROM tbldespag;
														";
												$resultadodes=mysql_query("$consultades",$conexion) or die (mysql_error());
												echo '<select name="IdDesPag_'.$i.'_'.$h.'_1_" id="IdDesPag_'.$i.'_'.$h.'_1_" onchange="agregaDestino(this.value,'.$i.','.$h.')">';
												while($renglon = mysql_fetch_array($resultadodes))
													{
														echo '<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>
										
										
										</td>
										</tr>	  	
									</table>';
																
							echo '
							</div>
									';	
										
					
					
				  }
				  
				
		echo '</div>	
				
				';
			
echo '</div>';	

?>
*/
                                        }
                                                              


