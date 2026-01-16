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
</head>
<body>

    <?php include '../includes/menu.php'; ?>
    <hr/>
    <?php include '../includes/header.php'; ?>
    <hr/>
    <?php include '../includes/estadisticas.php'; ?>
    <hr/>
    <main>
        <hr/>
        <?php include '../includes/galeria.php'; ?>
        <hr/>
    </main>
    <?php include '../includes/buscarviaje.php'; ?>
    <hr/>
    <?php include '../includes/footer.php'; ?>

</body>
</html>