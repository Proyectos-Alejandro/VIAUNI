<?php
require_once '../config/db.php';

    $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1"); 
    $empresa = $stmtlogo->fetch();

    $stmtUsuarios = $pdo->query("SELECT COUNT(*) FROM usuario");
    $numUsuarios = $stmtUsuarios->fetchColumn();

    $stmtViajes = $pdo->query("SELECT COUNT(*) FROM viajes");
    $numViajes = $stmtViajes->fetchColumn();

    $stmtReservas = $pdo->query("SELECT COUNT(*) FROM reservas");
    $numReservas = $stmtReservas->fetchColumn();

// UN CONTEO DE LAS ESTADISTICAS PRINCIPALES DE LA PAGINA Y LUEGO MOSTRARLAS //
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESTADISTICAS</title>
    <link rel="stylesheet" href="../assets/css/style_estadisticas.css">
    
</head>
<body>
    <section id="estadisticas" class="seccion_estadisticas">
    <div class="contenido_estadisticas">
        
        <h2 class="titulo_seccion">NUESTRO IMPACTO CON <?php echo $empresa['nombre']; ?></h2>
        <p class="subtitulo">La comunidad crece cada día</p>

        <div class="tabla_estadisticas">
            
            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numUsuarios ?></div>
                <h3>USUARIOS</h3>
                <p>Confían en <?=$empresa['nombre']?></p>
            </article>

            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numViajes ?></div>
                <h3>VIAJES</h3>
                <p>Disponibles a dia de hoy</p>
            </article>

            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numReservas ?></div>
                <h3>RESERVAS</h3>
                <p>Realizadas en <?=$empresa['nombre']?></p>
            </article>

        </div>
    </div>
    </section>
</body>
</html>

