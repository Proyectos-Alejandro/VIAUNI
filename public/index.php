<?php 
session_start();
$esta_logueado = isset($_SESSION['user_id']);
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

    <?php if ($esta_logueado): ?>
        <?php include '../includes/menu.php'; ?>
    <?php else: ?>
        <?php include '../includes/menu_log_reg.php'; ?>
    <?php endif; ?>
    
    <hr id="home">
    <?php include '../includes/header.php'; ?>

    <?php if ($esta_logueado): ?>
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
    <?php else: ?>
        <hr id="home" class="sinseparador">
        <hr id="caja_login" class="sinseparador">
        <?php include '../includes/login_registro.php'; ?>
        <hr id="estadisticas" class="separador">
        <?php include '../includes/estadisticas.php'; ?>
        <hr id="mas_info" class="separador">
        <?php include '../includes/bloque_informacion.php'; ?>
        <hr id="formulario" class="separador">
        <?php include '../includes/formulario.php'; ?>
        <hr>
        <?php include '../includes/footer.php'; ?>
    <?php endif; ?>

</body>
</html>