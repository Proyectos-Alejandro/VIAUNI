<?php
require_once '../config/db.php';


    $stmtUsuarios = $pdo->query("SELECT COUNT(*) FROM usuario");
    $numUsuarios = $stmtUsuarios->fetchColumn();

    $stmtViajes = $pdo->query("SELECT COUNT(*) FROM bloque_publicar_viaje");
    $numViajes = $stmtViajes->fetchColumn();

    $stmtReservas = $pdo->query("SELECT COUNT(*) FROM bloque_reservar_viaje");
    $numReservas = $stmtReservas->fetchColumn();


?>

<section id="estadisticas" class="seccion_estadisticas">
    <div class="contenido_estadisticas">
        
        <h2 class="titulo_seccion">NUESTRO IMPACTO EN LA UAX</h2>
        <p class="subtitulo">La comunidad crece cada día</p>

        <div class="tabla_estadisticas">
            
            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numUsuarios ?></div>
                <h3>USUARIOS</h3>
                <p>Confían en BLABLAX</p>
            </article>

            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numViajes ?></div>
                <h3>CONDUCTORES</h3>
                <p>Han publicado ruta</p>
            </article>

            <article class="tarjeta_dato">
                <div class="numero_grande"><?= $numReservas ?></div>
                <h3>RESERVAS</h3>
                <p>Viajes compartidos</p>
            </article>

        </div>
    </div>
</section>