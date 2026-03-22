<?php 
    require_once '../config/db.php';

    $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");
    $empresa = $stmtlogo->fetch();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOTER</title>
    <link rel="stylesheet" href="../assets/css/style_footer.css">
</head>
<body>


<footer>
    <div class="footer_container">
        
        <div class="footer_columna redes-sociales">
            <h4>Sígueme</h4>
            <div class="iconos-redes">
                <a href="https://www.linkedin.com/in/alejandro-calvo-mateos-284720370/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/redessociales/linkedin.png" alt="LinkedIn"></a>
                <a href="https://x.com/aCalvomat" target="_blank" rel="noopener noreferrer"><img src="../assets/img/redessociales/x.png" alt="Twitter"></a>
                <a href="https://www.instagram.com/a_calvo._/" target="_blank" rel="noopener noreferrer"><img src="../assets/img/redessociales/instagram.png" alt="Instagram"></a>
            </div>
        </div>

        <div class="footer_columna enlaces-footer">
            <h4>Enlaces Rápidos</h4>
            <ul>
                <li><a href="#home">Inicio</a></li>
                <li><a href="#buscarviaje">Buscar Viaje</a></li>
                <li><a href="#estadisticas">Estadísticas</a></li>
                <li><a href="#mas_info">Más Información</a></li>
                <li><a href="#publicarviaje">Publicar Viaje</a></li>
                <li><a href="#formulario">Formulario</a></li>
            </ul>
        </div>

        <div class="footer_columna logos-footer">
            <h4>Proyecto Intermodular</h4>
            <div class="contenedor-logos">
                <div class="logo-empresa">
                    <img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>">
                </div>
                <div class="logo-uax">
                    <img src="../assets/img/LOGOUAX.JPG" alt="Universidad Alfonso X El Sabio">
                </div>
            </div>
        </div>

    </div>

    <div class="footer_bottom">
        <p class="copyright">&copy; <?= date('Y') ?> <?= $empresa['nombre'] ?>. Todos los derechos reservados.</p>
    </div>
</footer>
</body>
</html>
