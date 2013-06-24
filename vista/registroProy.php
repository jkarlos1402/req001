<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Regristro de proyectos</title>
<script src="../js/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css"/>
<?php 
session_start(); 
header("Cache-control: private"); //para no perder formularios al dar back
?>

</head>
<!--
//******************************************************************//
//																	//
// Nombre: Juan Carlos Piña Moreno									//
// Nombre del módulo: Formulario agregar proyectos					//
// Función del módulo: Formulario para recabar los datos necesarios //
//					   y registrar el nuevo proyecto				//
// Fecha: 09/05/2013												//
//																	//
//******************************************************************//
-->
<body>
<form action="../proyecto/alta.php" method="post" name="formAddPry" id="formAddPry" target="_top">
<div align="center" >
<table width="100%">
<tr>
<td align="center" class="encabezado">
<label>Programaci&oacute;n y registro de proyectos</label>
</td>
</tr>
</table>
<div id="proyecto">
<h3>
    <label>Datos generales del proyecto</label>
</h3>
<div>
<table>
<tr>
	<td colspan="3">
      <span id="sprytextfield0">
      <label for="ltxt_nomPry">Proyecto:</label>
      <input type="text" name="ltxt_nomPry" id="ltxt_nomPry" size="70"/>
</span></td>
</tr>
<tr>
	<td colspan="3" id="clientes">
    </td>
</tr>
<tr>
	<td>
    <label><b>Periodo:</b></label>
    </td>
    <td><span id="sprytextfield1">
    <label for="ltxt_fecIni">Fecha inicio</label>
    <input type="fecha" name="ltxt_fecIni" id="ltxt_fecIni" />
    <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span>  
 </td>
    <td><span id="sprytextfield2"><label for="ltxt_fecFin">Fecha final</label>
  <input name="ltxt_fecFin"  id="ltxt_fecFin" type="fecha"/><span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span>  
 </td>
</tr>
<tr>
<td colspan="3">
<label for="ltxt_dscPry">Descripcion:</label><br />
<textarea name="ltxt_dscPry" id="ltxt_dscPry" cols="80" rows="8" title="Agregue una descripción del proyecto"></textarea>
</td>
</tr>
  <td colspan="2">
    <span id="sprytextfield3">
    <label for="lint_ctoPry2">Costo total: $</label>
    <input type="text" name="lint_ctoPry" id="lint_ctoPry" onblur="valida('pje',0)" placeholder="Costo sin IVA"/>
<span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span></span>
    <input type="checkbox" name="lbool_ivaPry" id="lbool_iva" title="¿Se incluirá IVA?" onchange="valida('pje',0)"/>
    <label for="lbool_iva">IVA</label></td>
<td>
  <span id="sprytextfield4">
  <label for="lint_pjeUni">Porcentaje:</label>
  <input type="text" name="lint_pjeUni" title="Porcentaje asignado al intermediario" id="lint_pjeUni" size="3"/>%
  <span class="textfieldInvalidFormatMsg">Formato no v&aacute;lido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
</tr>
</table>
</div>
<h3>
<label>Fases o entregables</label>
</h3>
<div>
<table>
<tr>
<td>No.</td>
<td>Concepto</td>
<td>Fecha T&eacute;rmino</td>
</tr>
<tr id="fase0" class="entrada0">
<td>1</td>
<td><input type="text" id="ltxt_ctoFas0" name="ltxt_ctoFas0" size="60"/></td>
<td><input type="fechaEtr" id="ltxt_fecEnt0" name="ltxt_fecEnt0"/></td>
</tr>
<tr>
<td colspan="3" align="right">
<input type="button" value="Agregar" onclick="agregaFase(0)"/>
</td>
</tr>
</table>
</div>
<h3>
<label>Programaci&oacute;n de pagos</label>
</h3>
<div>
<table width="100%">
<tr>
<td>No.</td>
<td>Concepto</td>
<td>(%)</td>
<td>Subtotal</td>
<td>IVA</td>
<td>Monto total</td>
<td>Fecha de pago</td>
</tr>
<tr  class="entrada0" id="pago0">
<td>1</td>
<td><input type="text" name="ltxt_ctoPag0" id="ltxt_ctoPag0" size="50" /></td>
<td><input type="text" name="lint_pjePag0" id="lint_pjePag0" size="8" onblur="valida('pje',0)"/></td>
<td>$<input type="text" name="lint_subPag0" id="lint_subPag0" size="10" disabled="disabled"/></td>
<td>$<input type="text" name="lint_ivaPag0" id="lint_ivaPag0" size="10" disabled="disabled"/></td>
<td>$<input type="text" name="lint_totPag0" id="lint_totPag0" size="10" onblur="valida('totalP',0)"/></td>
<td><input type="fechaPag" name="ltxt_fecPag0" id="ltxt_fecPag0" /></td>
</tr>
<tr>
<td colspan="7" align="right">
<input type="button" name="botonAddPag" value="Agregar" onclick="agregaPago(0)"/>
</td>
</tr>
<tr>
<td></td>
<td align="center">
<article id="error"></article>
</td>
</tr>
</table>
</div>
</div>
<table width="100%">
<tr>
<td class="encabezado" align="left">
<input name="botonEnviar" type="submit" value="Guardar"/>
</td>
</tr>
</table>
</div>
</form>
<script type="text/javascript">
var sprytextfield0 = new Spry.Widget.ValidationTextField("sprytextfield0", "none", {validateOn:["blur"], isRequired:false});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "date", {validateOn:["blur"], isRequired:false, format:"dd-mm-yyyy"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "date", {validateOn:["blur"], isRequired:false, format:"dd-mm-yyyy"});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "currency", {validateOn:["blur"], isRequired:false});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "real", {isRequired:false, validateOn:["blur"], minValue:0, maxValue:100});
</script>
</body>
</html>
