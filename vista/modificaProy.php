<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../js/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<script src="../js/jquery.js" type="text/javascript"></script>
<script src="../js/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<link href="css/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/estilos.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.3.custom.css"/>
<?php 
session_start();
if(isset($_GET['id']))
	$IdEntPry = $_GET['id'];
?>
<title>Modifica proyecto</title>
<script type="text/javascript">
buscaProy(<?php echo $IdEntPry; ?>);
</script>
</head>

<body>
<div id="contenido"></div>
</body>
</html>