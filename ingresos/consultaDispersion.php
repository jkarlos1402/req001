<?php
include("../conexion.php");
		
$IdEntPry=$_POST['IdEntPry'];
$IdEntPag=$_POST['IdEntPag'];

echo '	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> 
		<script src="../js/jquery.js" type="text/javascript"></script>
		<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
		<script type="text/javascript" src="../js/funciones.js"></script>
		<link rel="stylesheet" type="text/css" href="../vista/css/estilos.css">
		<link href="../vista/css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">	
		';
//************************************
$consulta="SELECT * 
		FROM tblentpry, tblentcli WHERE tblentcli.IdEntCli = tblentpry.IdEntCli and tblentpry.IdEntPry=$IdEntPry";
$resultado=mysql_query("$consulta",$conexion) or die (mysql_error());

//************************************
$consultadisp="select * from tbldsppag,tblentcue,tblentsuc,tblentban,tbldespag,tblorgpag,tblentpoe,tblentpag
where tblentban.IdEntBan = tblentsuc.IdEntBan and tblentsuc.IdEntSuc = tblentcue.IdEntSuc and tblentpoe.IdEntPoE = tblentcue.IdEntPoE and tblentcue.IdEntCue = tbldsppag.IdEntCue and tbldespag.IdDesPag = tbldsppag.IdDesPag and tblorgpag.IdOrgPag = tbldsppag.IdOrgPag and tblentpag.IdEntPag = tbldsppag.IdEntPag and tbldsppag.IdEntPag =$IdEntPag";
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


echo '<h2 align="center" class="encabezado">REGISTRO Y DISPERSION DE PAGOS</h2>
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
						
						echo '
							<h3>'.$renglongeneral['CtoEntPag'].'</h3>
							<div>
								<table border="1" cellpadding="3" align="center" width="100%">
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
											<input type="text" value="'.$renglongeneral['MonEntPag'].'" id="montoTotal'.$i.'" disabled="disabled">
										</td>
								</tr>
								</table>
								<br />
								<br />
								<br />';
								$h=1;
								$bandera=$i;
								$j=0;	
								//Aqui va la consulta para despues incrementar a h
								
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
									$h++;	
					
					
				  }
				  
				
		echo '</div>	
				
				';
			
echo '	</div>
<div id="dialog" title="Agregar Categoria">

<input type="text" name="nuevoorg" id="nuevoorg" required="required" size="30" placeholder="Ingresa el nuevo origen"/>
<input type="button" value="Guardar" onclick="guardarOrigen()" />
	<div id="mensaje">
	</div>

</div>
<div id="dialog2" title="Agregar Categoria">

<input type="text" name="nuevodest" id="nuevodest" required="required" size="30" placeholder="Ingresa el nuevo destino"/>
<input type="button" value="Guardar" onclick="guardarDestino()" />
	<div id="mensaje2">
	</div>

</div>
<div id="resp"></div>
<script>arrayPagos('.$r.')</script>
		';	

?>




