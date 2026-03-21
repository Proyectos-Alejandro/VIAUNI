<?php
require_once '../config/db.php';


$stmt = $pdo->query("SELECT url, descripcion FROM multimedia where seccion=2"); // SELECCIONA LAS IMAGENES DE LA SECIÓN 2 //
$fotoheader= $stmt->fetchAll(); 

        
        $stmt = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");  // SELECCIONA EL LOGO Y NOMBRE DE LA EMPRESA //

        $empresa = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEADER</title>
    <link rel="stylesheet" href="../assets/css/style_header.css">
</head>
<body>
    
    <?php if (count($fotoheader) > 0): ?>  <!-- SI HAY FOTOS EN LA BASE DE DATOS, SE MUESTRAN TODAS LAS FOTOS DE LA SECCIÓN 2-->
        <div class="header">
            <h3><?=$empresa['nombre']?></h3>
            <?php foreach ($fotoheader as $fotoenseñar): ?>
                <div class="fotoheader">
                    <img src="../assets/img/fotoheader/<?= $fotoenseñar['url'] ?>" alt="<?= $fotoenseñar['descripcion'] ?>">
                </div>
            <?php endforeach; ?>
            <button><a href="#mas_info">MAS INFORMACION</a></button>
        </div>
    <?php else: ?>  <!-- SI NO HAY FOTOS EN LA BASE DE DATOS -->
        <p>No hay fotos en la base de datos.</p>
    <?php endif; ?>
</body>
</html>
