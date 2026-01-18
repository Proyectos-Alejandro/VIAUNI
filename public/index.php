<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLABAX</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/menu.php'; ?>
    <hr id="home">
    <?php include '../includes/header.php'; ?>
    <hr id="buscarviaje">
    <?php include '../includes/buscarviaje.php'; ?>
    <hr id="estadisticas">
    <?php include '../includes/estadisticas.php'; ?>
    <hr id="mas_info">
    <?php include '../includes/bloque_informacion.php'; ?>
    <hr/>
    <?php include '../includes/footer.php'; ?>

</body>
</html>