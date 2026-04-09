<?php  // CERRAR SESIÓN //
session_start();
session_destroy(); 
header("Location: index.php"); 
exit();
?>