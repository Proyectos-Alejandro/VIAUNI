<?php
require_once '../config/db.php';


$stmt = $pdo->query("SELECT url, descripcion FROM multimedia where seccion=2"); // SELECCIONA LAS IMAGENES DE LA SECIÓN 2 //
$fotoheader= $stmt->fetchAll(); 

        
        $stmt = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");  // SELECCIONA EL LOGO Y NOMBRE DE LA EMPRESA //

        $empresa = $stmt->fetch();
?>


<h3><?=$empresa['nombre']?></h3>
<?php if (count($fotoheader) > 0): ?>  <!-- SI HAY FOTOS EN LA BASE DE DATOS, SE MUESTRAN TODAS LAS FOTOS DE LA SECCIÓN 2-->
        <div class="header">
            <?php foreach ($fotoheader as $fotoenseñar): ?>
                <div class="fotoheader">
                    <img src="../assets/img/fotoheader/<?= $fotoenseñar['url'] ?>" alt="<?= $fotoenseñar['descripcion'] ?>" width="1500" height="700">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>  <!-- SI NO HAY FOTOS EN LA BASE DE DATOS -->
        <p>No hay fotos en la base de datos.</p>
    <?php endif; ?>

<button>MAS INFORMACION</button> <!-- BOTON DE MAS INFORMACION, NO HACE NADA POR EL MOMENTO -->