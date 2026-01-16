<?php
require_once '../config/db.php';


$stmt = $pdo->query("SELECT url, descripcion FROM imagenes where seccion=2");
$fotoheader= $stmt->fetchAll(); 
?>

<?php
        require_once '../config/db.php';
        
        $stmt = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");

        $empresa = $stmt->fetch();
?>


<h3><?=$empresa['nombre']?></h3>
<?php if (count($fotoheader) > 0): ?>
        <div class="header">
            <?php foreach ($fotoheader as $fotoenseñar): ?>
                <div class="fotoheader">
                    <img src="../assets/img/fotoheader/<?= $fotoenseñar['url'] ?>" alt="<?= $fotoenseñar['descripcion'] ?>" width="1500" height="700">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay fotos en la base de datos.</p>
    <?php endif; ?>

<button>MAS INFORMACION</button>