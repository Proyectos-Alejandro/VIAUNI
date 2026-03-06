<?php 
    require_once '../config/db.php';

    $stmt = $pdo->query("SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.NOMBRE_CIUDAD AS ORIGEN, C2.NOMBRE_CIUDAD AS DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO;");
    $infoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje = $pdo->query("SELECT ID, NOMBRE_CIUDAD FROM CIUDADES WHERE NOMBRE_CIUDAD COLLATE utf8mb4_unicode_ci LIKE '%%'");
    $viajes = $opcionesviaje->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="filtros_publicar">
    <form action="index.php" method="POST"> <fieldset class="fieldset_publicar">
            <legend>PUBLICA TU VIAJE</legend>

                <?php if (count($viajes) > 0): ?> <div class="contenedor_origen">
                        <input list="filtro_origen" name="filtro_origen" placeholder="Origen">
                        <datalist id="filtro_origen"> <?php foreach ($viajes as $viaje): ?>
                                <option value="<?php echo $viaje['NOMBRE_CIUDAD']; ?>">
                            <?php endforeach; ?>
                        </datalist>  
                    </div>
                <?php else: ?>
                    <div class="contenedor_origen">
                            <input list="filtro_origen" name="filtro_origen" placeholder="Origen">
                            <datalist id="filtro_origen">
                            <option value="">
                            </datalist>  
                    </div>
                <?php endif; ?>  

                <?php if(count($viajes) > 0): ?> <div class="contenedor_destino">
                        <input list="filtro_destino" name="filtro_destino" placeholder="Destino">
                        <datalist id="filtro_destino">
                            <?php foreach ($viajes as $viaje): ?>
                                <option value="<?php echo $viaje['NOMBRE_CIUDAD']; ?>">
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                <?php else: ?>
                    <div class="contenedor_destino">
                            <input list="filtro_destino" name="filtro_destino" placeholder="Destino">
                            <datalist id="filtro_destino">
                            <option value="">
                            </datalist>  
                    </div>
                <?php endif; ?>  
            
            <input type="date" name="filtro_fecha">

            <input type="text" name="filtro_descripcion" placeholder="Informacion adicional">

            <input type="text" name="filtro_plazas" placeholder="Nº de Plazas">

            <input type="text" name="filtro_precio" placeholder="Precio por plaza">

            <button type="submit">PUBLICAR</button>

        </fieldset>
        
    </form>
</div>

<div class="filtro_resultado"> <?php 
        
        $publicar_origen = $_POST['filtro_origen'] ?? '';
        $publicar_destino = $_POST['filtro_destino'] ?? '';
        $publicar_fecha = $_POST['filtro_fecha'] ?? '';
        $publicar_descripcion = $_POST['filtro_descripcion'] ?? '';
        $publicar_precio = $_POST['filtro_precio'] ?? '';
        $publicar_plazas = $_POST['filtro_plazas'] ?? '';
        
        
        $filtro_publicacion = "SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.NOMBRE_CIUDAD AS ORIGEN, C2.NOMBRE_CIUDAD AS DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO WHERE 1=1";

        if (!empty($publicar_origen)) {
            $filtro_publicacion .= " AND C1.NOMBRE_CIUDAD LIKE :origen";
        }
        if (!empty($publicar_destino)) {
            $filtro_publicacion .= " AND C2.NOMBRE_CIUDAD LIKE :destino";
        }
        if (!empty($publicar_fecha)) {
            $filtro_publicacion .= " AND DATE(V.FECHA_HORA) = :fecha";
        }
        if (!empty($publicar_plazas)) {
            $filtro_publicacion .= " AND V.PLAZAS_TOTALES = :plazas";
        }
        if (!empty($publicar_precio)) {
            $filtro_publicacion .= " AND V.PRECIO = :precio";
        }
        if (!empty($publicar_descripcion)) {
            $filtro_publicacion .= " AND V.DESCRIPCION_EXTRA = :descripcion";
        }

        $stmt = $pdo->prepare($filtro_publicacion);
        if (!empty($publicar_origen)) {
            $stmt->bindValue(':origen', '%' . $publicar_origen . '%');
        }
        if (!empty($publicar_destino)) {
            $stmt->bindValue(':destino', '%' . $publicar_destino . '%');
        }
        if (!empty($publicar_fecha)) {
            $stmt->bindValue(':fecha', $publicar_fecha);
        }
        if (!empty($publicar_plazas)) {
            $stmt->bindValue(':plazas', (int)$publicar_plazas);
        }
        if (!empty($publicar_precio)) {
            $stmt->bindValue(':precio', (int)$publicar_precio);
        }
        if (!empty($publicar_descripcion)) {
            $stmt->bindValue(':descripcion', '%' . $publicar_descripcion . '%');
        }

        
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (6, (SELECT ID FROM CIUDADES WHERE NOMBRE_CIUDAD = ? LIMIT 1), (SELECT ID FROM CIUDADES WHERE NOMBRE_CIUDAD = ? LIMIT 1), ?, ?, ?, ?)");
            $stmt->execute([$publicar_origen, $publicar_destino, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion]);
        }
        
    ?>
</div>