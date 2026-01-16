<?php
require_once '../config/db.php';


$stmt = $pdo->query("SELECT url, descripcion FROM imagenes where seccion=1");
$fotogaleria = $stmt->fetchAll(); 
?>

    <style>
        .galeria {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 20px;
        }
        .foto {
            text-align: center;
        }
        .foto img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ddd;
        }
    </style>

    <?php if (count($fotogaleria) > 0): ?>
        <div class="galeria">
            <?php foreach ($fotogaleria as $foto): ?>
                <div class="foto">
                    <img src="../assets/img/fotogaleria/<?= $foto['url'] ?>" alt="<?= $foto['descripcion'] ?>">
                    <p><?= $foto['descripcion'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay fotos en la base de datos.</p>
    <?php endif; ?>
