<?php
include("../conexion.php");
		
$IdEntPry=$_POST['IdEntPry'];
$Idpago=$_POST['pago'];
$renglones = $_POST['renglones'];
$r=0;
echo '	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/funciones.js"></script>
		<script type="text/javascript" src="../js/dispersionFunciones.js"></script>
		<link rel="stylesheet" type="text/css" href="../vista/css/estilos.css">
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">	
		';

//************************************
$consulta="SELECT * 
		FROM tblentpry, tblentcli WHERE tblentcli.IdEntCli = tblentpry.IdEntCli and tblentpry.IdEntPry=$IdEntPry";
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());



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




echo '<article align="center" class="encabezado">REGISTRO Y DISPERSION DE PAGOS</article>
		<div align="center">';
while($renglon = mysql_fetch_array($resultado)){
		echo'<table class="ui-widget">
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
			</table>					
			<article align="center" class="encabezado">PROGRAMACIÓN DE PAGOS</article>
			<div id="accordion">
			';
				for ($i=1;$i<$renglones;$i++)
				{	
					
					if(isset($Idpago[$i])){
						$r++;
					$consulta="SELECT * 
						FROM tblentpag WHERE IdEntPag =$Idpago[$i]";
					$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());
					
					while($renglon = mysql_fetch_array($resultado))
					{
						if($renglon['FecEntPagRal']!=null){
							$monto =$renglon['MonEntPagRal'];
						}else{
							$monto =$renglon['MonEntPagPrg'];
						}
						echo '
							<h3>'.$renglon['CtoEntPag'].'</h3>
							<div>
							<form id="form'.$i.'" action="../ingresos/registraDispersion.php" method="post">
								<table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
									<tr>
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
										<td>
											Dispersión
										</td>
									</tr>
									<tr>
										<td>
											'.$i.'
										</td>
										<td>
											'.$renglon['CtoEntPag'].'
										</td>
										<td>
											'.date("d-m-Y",strtotime($renglon['FecEntPagPrg'])).'
										</td>
										<td>
											';
                                                                              if($renglon['FecEntPagRal']!= "")
                                                                                echo date("d-m-Y",  strtotime($renglon['FecEntPagRal']));
                                                                              echo '
										</td>
										<td>
											<input type="text" value="'.$monto.'" id="montoTotal'.$i.'" name="montoTotal'.$i.'" disabled="disabled">
										</td>
										<td>
											<input type="button" value="Programar" id="Programar'.$i.'" name="Programar" onClick="habilitaDispersion('.$i.');" />
										</td>
									</tr>
								</table>
								<br />
								<br />
								<br />';
								$h=1;
								$j=0;	
															
								
								
							echo '<div id="controlDispersion'.$i.'" style="visibility:hidden; display:none;">
									<table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
									<tr>
											<td colspan="9">
                                                                                            <article id="error'.$i.'"></article><br>
                                                                                            <article id="errorSec'.$i.'"></article>
											</td>
											
									</tr>
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
											<td>
												Opciones
											</td>
										</tr></table>';										
							echo		'
										<div id="divDispersion'.$i.$h.'">
										<table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
										<tr id="dispersion'.$i.'" bgcolor="01DF01">	
											<td width="50px">
											'.$i.'.'.$h.'
											</td>
											<td width="220px">';
											
												//************************************
												$consultapoe = "SELECT * 
														FROM tblentpoe where EstEntPoE = 1;
														";
												//************************************		
												$resultadopoe=mysql_query("$consultapoe",$conexion) or die (mysql_error());
												echo '<select name="IdEntPoE_'.$i.'_0[]" id="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_" onchange="habilitaOrigen(this,'.$i.','.$h.','.$j.');">
														<option value="-1">Selecciona</option>';
												while($renglon = mysql_fetch_array($resultadopoe))
													{
														echo '<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
													}
												echo '</select>';
									echo	'</td>
											<td width="100px">
												<input type="fecha" id="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" name="FecMovDspPag_'.$i.'_0[]" placeholder="Ingrese fecha" size="11"/>
											</td>
											<td width="160px">';
												//************************************
												$consultaorig = "SELECT * 
														FROM tblorgpag;
														";
												//*************************************		
												$resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());
												echo '<select name="IdOrgPag_'.$i.'_0[]" id="IdOrgPag_'.$i.'_'.$h.'_'.$j.'_" onchange="agregaOrigen(this,'.$i.','.$h.','.$j.');" style="visibility:hidden; display:none;"><option></option>';
												while($renglon = mysql_fetch_array($resultadoorig))
													{
														echo '<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>';
									echo	'</td>
											<td width="150px" id="datosbanco'.$i.$h.'">
												
											</td>
											<td width="150px" id="datoscuenta'.$i.$h.'">
											</td>
											<td width="100px">
												$<input type="text"  class="montoDispersion" id="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" name="MonDspPag_'.$i.'_0[]" placeholder="Ingrese Monto" onBlur="validaTotal('.$i.');" size="11"/>
											</td>
											<td width="220px">';
											//***************************************************************
												$consultades = "SELECT * 
														FROM tbldespag;
														";
												$resultadodes=mysql_query("$consultades",$conexion) or die (mysql_error());
												echo '<select name="IdDesPag_'.$i.'_0[]" class="destinoDis" id="IdDesPag_'.$i.'_'.$h.'_'.$j.'_" onchange="agregaDestino(this.value,'.$i.','.$h.','.$j.');">';
												while($renglon = mysql_fetch_array($resultadodes))
													{
														echo '<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
													}
												echo '
																<option value="otros">OTRO...</option>
													  </select>
											</td>	  ';
											$j=1;
						//********************************* DISPERSIONES SECUNDARIAS NUEVAS ********************************///						
									echo	'
											
											<td >
												<li id="agrega'.$i.$h.'" style="visibility:hidden; display:none;" onclick="agregaDispersionSecundaria('.$i.','.$h.');"></li>
											</td>
										</tr>
										<tr id="dispSec'.$i.$h.$j.'" class="dispSec" align="left" style="visibility:hidden; display:none;" bgcolor="A9F5A9">
											<td width="50px">
											'.$i.'.'.$h.'.'.$j.'
											</td>
											<td width="220px">';
											
												//************************************
												$consultapoe = "SELECT * 
														FROM tblentpoe where EstEntPoE = 1;
														";
												//************************************		
												$resultadopoe=mysql_query("$consultapoe",$conexion) or die (mysql_error());
												echo '<select name="IdEntPoE_'.$i.'_'.$j.'[]" disabled="disabled" id="IdEntPoE_'.$i.'_'.$h.'_'.$j.'_"  onchange="habilitaOrigen(this,'.$i.','.$h.','.$j.');" >
														<option value="-1">Selecciona</option>';
												while($renglon = mysql_fetch_array($resultadopoe))
													{
														echo '<option value="'.$renglon['IdEntPoE'].'">'.$renglon['NomEntPoE'].'</option>';
													}
												echo '</select>';
									echo	'</td>
											<td width="100px"> 
												<input type="fecha" disabled="disabled" id="FecMovDspPag_'.$i.'_'.$h.'_'.$j.'_" name="FecMovDspPag_'.$i.'_'.$j.'[]" placeholder="Ingrese fecha" size="11">
											</td>
											<td width="160px">';
												//************************************
												$consultaorig = "SELECT * 
														FROM tblorgpag;
														";
												//*************************************		
												$resultadoorig=mysql_query("$consultaorig",$conexion) or die (mysql_error());
												echo '<select name="IdOrgPag_'.$i.'_'.$j.'[]" disabled="disabled" id="IdOrgPag_'.$i.'_'.$h.'_'.$j.'_" onchange="agregaOrigen(this,'.$i.','.$h.','.$j.');" style="visibility:hidden; display:none;">
																<option></option>';
												while($renglon = mysql_fetch_array($resultadoorig))
													{
														echo '<option value="'.$renglon['IdOrgPag'].'">'.$renglon['DscOrgPag'].'</option>';
													}
												echo '
															
													  </select>';
									echo	'</td>
											<td id="datosbanco'.$i.$h.$j.'" width="150px">
												
											</td>
											<td id="datoscuenta'.$i.$h.$j.'" width="150px">
											</td>
											<td width="100px">
												$<input type="text" class="montoSecundaria" disabled="disabled" id="MonDspPag_'.$i.'_'.$h.'_'.$j.'_" name="MonDspPag_'.$i.'_'.$j.'[]" placeholder="Ingrese Monto" onBlur="validaTotal('.$i.');" size="11"/>
											</td>
											<td width="220px">';
											//***************************************************************
												$consultades = "SELECT * 
														FROM tbldespag;
														";
												$resultadodes=mysql_query("$consultades",$conexion) or die (mysql_error());
												echo '<select name="IdDesPag_'.$i.'_'.$j.'[]" disabled="disabled" class="destinoSec" id="IdDesPag_'.$i.'_'.$h.'_'.$j.'_" >';
												while($renglon = mysql_fetch_array($resultadodes)){
                                                                                                    if($renglon['DscDesPag'] !== "TRANSFERIRLOS A UNA CUENTA" && $renglon['DscDesPag'] !== "REGRESAR EFECTIVO"){
                                                                                                        echo '<option value="'.$renglon['IdDesPag'].'">'.$renglon['DscDesPag'].'</option>';
                                                                                                    }
												}
												echo '
															
													  </select>
										
										
											</td>
											<td>
											</td>
										</tr>
										</table>
										<input type="hidden" class="controlDispersion" id="numeroDeDispersion'.$i.$h.'" name="numeroDeDispersion[]" value="'.$h.'"/>
										<input type="hidden" id="numeroDeDispersionesSec'.$i.$h.'" value="0"/>
										</div>
										<table class="ui-widget" border="0" cellpadding="0" align="center" width="100%">
										<tr>
											<td colspan="7">
											
											</td>
											<td>
												<input type="button" id="agregar" onclick="agregaDispersion('.$i.');" value="Programar otra dispersión">
											</td>
											<td>
											<input type="button" id="guardar" onclick="guardarDispersiones('.$i.','.$Idpago[$i].');" value="Guardar">
											</td>
										</tr>	
									</table>
									';							
							echo '</div>
								  <input type="hidden" id="numerodePago'.$i.'" name="numerodePago" value="'.$i.'"/>
								  <input type="hidden" id="IdEntPag'.$i.'" name="IdEntPag" value="'.$Idpago[$i].'"/>
								</form>
							</div> 
									';	
									$h++;
					}
				  }
				  
				}
		echo '
				
				
				';
			}//aqui cieera el while de pagos
/*aqui cierra el acordeon*/echo  '	</div> 
</div> 
<div id="dialog" title="Agregar Categoria">

<input type="text" name="nuevoorg" id="nuevoorg" size="30" placeholder="Ingresa el nuevo origen"/>
<input type="button" value="Guardar" onclick="guardarOrigen();" />
	<div id="mensaje">
	</div>

</div>
<div id="dialog2" title="Agregar Categoria">

<input type="text" name="nuevodest" id="nuevodest" size="30" placeholder="Ingresa el nuevo destino"/>
<input type="button" value="Guardar" onclick="guardarDestino()" />
<input type="hidden" value="" id="pagoPadre"/>
<input type="hidden" value="" id="dispersionPago"/>
	<div id="mensaje2">
	</div>

</div>
<div id="resp"></div>
		';	
/*

*/
?>