<?php 
    require_once '../config/db.php';

    $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");
    $empresa = $stmtlogo->fetch();

?>

<footer>
    <div class="footer">
        <p>&copy; <?= date('Y') ?> <?= $empresa['nombre'] ?>. Todos los derechos reservados.</p>
        
        <div class="redes-sociales">

            <a href="#"><img src="../assets/img/redessociales/linkedin.png" alt="LinkedIn" height="30" width="30"></a>
            <a href="#"><img src="../assets/img/redessociales/x.png" alt="Twitter" height="30" width="30"></a>
            <a href="#"><img src="../assets/img/redessociales/instagram.png" alt="Instagram" height="30" width="30"></a>
        </div>

        <div class="enlaces-footer">

            <a href="#home">Inicio</a> 
            <a href="#buscarviaje">Buscar Viaje</a> 
            <a href="#estadisticas">Estadísticas</a> 
            <a href="#mas_info">Más Información</a> 
            <a href="#publicarviaje">Publicar Viaje</a> 
            <a href="#formulario">Formulario</a>

        </div>

        <div class="logo-empresa">
            <img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>" height="50" width="100">
        </div>

        <div class="logo-uax">
            <img src="../assets/img/LOGOUAX.JPG" alt="Universidad Alfonso X El Sabio" height="50" width="100">
        </div>

    </div>
</footer>