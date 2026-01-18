<?php 
    require_once '../config/db.php';

    $stmt = $pdo->query("SELECT * FROM bloque_mas_informacion where seccion = 1");
    $mas_informacion = $stmt -> fetchAll()
?>

<?php if (count($mas_informacion) > 0): ?>
        <div class="bloque_informacion">
            <?php foreach ($mas_informacion as $info): ?>
                <div class="info_titulo">
                    <h2><?php echo ($info['TITULO']); ?></h2>
                </div>
                <div class="info_descripcion">
                    <p><?php echo ($info['DESCRIPCION']); ?></p>
                </div>
                <div class="info_imagen">
                    <img src="<?php echo ($info['IMG']); ?>" alt="<?php echo ($info['img_desc']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No hay bloques de información disponible</p>
    <?php endif; ?>
