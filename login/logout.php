<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
session_start();
session_destroy();
echo '<SCRIPT LANGUAGE="javascript">
            location.href = "../vista/login.php";
            </SCRIPT>';	
?>