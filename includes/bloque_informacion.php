<?php 
    require_once '../config/db.php';

    $stmt = $pdo->query("SELECT * FROM mas_info where seccion = 1");
    $mas_informacion = $stmt -> fetchAll();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAS INFO</title>
    
    <link rel="stylesheet" href="../assets/css/style_masinfo.css">
</head>
<body>
<?php if (count($mas_informacion) > 0): ?>
    <div class="bloque_informacion">  
        
        <?php foreach ($mas_informacion as $info): ?>
            <article class="info_fila">
                <div class="info_texto">
                    <div class="info_titulo">
                        <h2><?php echo ($info['TITULO']); ?></h2>
                    </div>
                    <div class="info_descripcion">
                        <p><?php echo ($info['DESCRIPCION']); ?></p>
                    </div>
                    <div class="info_boton">
                        <?php if (!empty($info['BOTON'])): ?>
                            <button type="button" class="btn_info"><?php echo ($info['BOTON']); ?></button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="info_imagen">
                    <img src="<?php echo ($info['IMG']); ?>" alt="Info ViaUni">
                </div>
            </article>
        <?php endforeach; ?>

    </div>
<?php else: ?> 
    <p id="no_info" class="alerta_sin_info">No hay bloques de información disponible</p>
<?php endif; ?>
</body>
</html>

