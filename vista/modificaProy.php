<?php
session_start(); 
if(!ISSET($_SESSION["k_username"])){
    echo '<SCRIPT LANGUAGE="javascript">
        location.href = "../vista/login.php";
        </SCRIPT>';	
}
if ($_SESSION["k_perfil"] == "USU") {
    header("HTTP/1.0 404 Not Found");
    die();
}
?>
<script type="text/javascript" src="../js/proyectoFunciones.js"></script>
<?php
if (isset($_GET['id']))
    $IdEntPry = $_GET['id'];
?>
<script type="text/javascript">
    buscaProy(<?php echo $IdEntPry; ?>);
</script>
<div id="contenido"></div>
