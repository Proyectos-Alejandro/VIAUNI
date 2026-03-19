<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_registro.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIAUNI</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <?php include '../includes/menu.php'; ?>
    <hr id="home">
    <?php include '../includes/header.php'; ?>
    <hr id="buscarviaje" class="separador">
    <?php include '../includes/buscarviaje.php'; ?>
    <hr id="estadisticas" class="separador">
    <?php include '../includes/estadisticas.php'; ?>
    <hr id="mas_info" class="separador">
    <?php include '../includes/bloque_informacion.php'; ?>
    <hr id="publicarviaje" class="separador">
    <?php include '../includes/publicarviaje.php'; ?>
    <hr id="formulario" class="separador">
    <?php include '../includes/formulario.php'; ?>
    <hr>
    <?php include '../includes/footer.php'; ?>

</body>
</html>