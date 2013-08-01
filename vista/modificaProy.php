<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<?php
session_start();
if (isset($_GET['id']))
    $IdEntPry = $_GET['id'];
?>
<script type="text/javascript">
    buscaProy(<?php echo $IdEntPry; ?>);
</script>
<div id="contenido"></div>
