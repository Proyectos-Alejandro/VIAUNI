<?php 
    require_once '../config/db.php';

    $stmt = $pdo->query("SELECT * FROM mas_info where seccion = 1");
    $mas_informacion = $stmt -> fetchAll();

    if (count($mas_informacion) > 0): ?>
            <div class="bloque_informacion">  <!-- BLOQUE DE INFORMACIÓN -->
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

                    <div class="info_boton"> <!-- SI EN LA BASE DE DATOS HAY ALGO ESCRITO EN EL CAMPO BOTON SE PONE UN BOTÓN, SI NO NO -->
                        <?php if (!empty($info['BOTON'])): ?>
                            <button type="button"><?php echo ($info['BOTON']); ?></button>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
        <?php else: ?> <!-- POR SI HAY TEST Y NO HAY INFO PARA VER SI FUNCIONA -->
            <p id="no_info">No hay bloques de información disponible</p>
        <?php endif; ?>
