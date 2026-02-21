<?php  // CERRAR SESIÓN //
session_start();
session_destroy(); 
header("Location: login_registro.php"); 
exit();


?