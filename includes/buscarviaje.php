<?php 
    require_once '../config/db.php';


    $stmt = $pdo->query("SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.NOMBRE_CIUDAD AS ORIGEN, C2.NOMBRE_CIUDAD AS DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO;");
    $infoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje = $pdo->query("SELECT NOMBRE_CIUDAD FROM CIUDADES WHERE NOMBRE_CIUDAD COLLATE utf8mb4_unicode_ci LIKE '%%'");
    $viajes = $opcionesviaje->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="filtros_buscar">

    <form action="index.php"> <!-- FORMULARIO PARA BUSCAR VIAJES -->
        <fieldset class="fieldset_buscar">
            <legend>BUSCA TU VIAJE</legend>

                <?php if (count($viajes) > 0): ?> <!-- BUSCA EN LA BASE DE DATOS TODAS LAS CIUDADES, SI HAY LAS MUESTRA -->
                    <div class="contenedor_origen">
                        <input list="filtro_origen" name="filtro_origen" placeholder="Origen">
                        <datalist id="filtro_origen"> <!-- MUESTRA TODAS LAS CIUDADES SIN NECESIDAD DE ESCRIBIR -->
                            <?php foreach ($viajes as $viaje): ?>
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

                <?php if(count($viajes) > 0): ?> <!-- LO MISMO QUE EN EL DE ORIGEN -->
                    <div class="contenedor_destino">
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
            <input type="text" name="filtro_plazas" placeholder="Nº de Plazas">
            <button type="submit">Buscar</button>
        </fieldset>
        
    </form>
</div>


<div class="filtro_resultado"> <!-- ESTO VA A BUSCAR TODOS LOS VIAJES DISPONIBLES PARA TENERLO PREPARADO PARA CUANDO ALGUIEN BUSQUE ALGO -->

    <?php 
        
        $filtro_origen = $_GET['filtro_origen'] ?? '';
        $filtro_destino = $_GET['filtro_destino'] ?? '';
        $filtro_fecha = $_GET['filtro_fecha'] ?? '';
        $filtro_plazas = $_GET['filtro_plazas'] ?? '';

        
        $filtro_texto = "SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.NOMBRE_CIUDAD AS ORIGEN, C2.NOMBRE_CIUDAD AS DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO WHERE 1=1";

        if (!empty($filtro_origen)) {
            $filtro_texto .= " AND C1.NOMBRE_CIUDAD LIKE :origen";
        }
        if (!empty($filtro_destino)) {
            $filtro_texto .= " AND C2.NOMBRE_CIUDAD LIKE :destino";
        }
        if (!empty($filtro_fecha)) {
            $filtro_texto .= " AND DATE(V.FECHA_HORA) = :fecha";
        }
        if (!empty($filtro_plazas)) {
            $filtro_texto .= " AND BPV.PLAZAS_TOTALES >= :plazas";
        }

        $stmt = $pdo->prepare($filtro_texto);
        if (!empty($filtro_origen)) {
            $stmt->bindValue(':origen', '%' . $filtro_origen . '%');
        }
        if (!empty($filtro_destino)) {
            $stmt->bindValue(':destino', '%' . $filtro_destino . '%');
        }
        if (!empty($filtro_fecha)) {
            $stmt->bindValue(':fecha', $filtro_fecha);
        }
        if (!empty($filtro_plazas)) {
            $stmt->bindValue(':plazas', (int)$filtro_plazas);
        }

        $stmt->execute();
        $infoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC); // GUARDA TODO LO DE ESTA CONSULTA EN LA VARIABLE INFOVIAJE //
    ?>

    <?php if (count($infoviaje) > 0): ?> <!-- SI HAY VIAJES DIPONIBLES, LOS MUESTRA, SI NO HAY DA UN MENSAJE Y MUESTRA TODOS LOS VIAJES -->
    <div class="contenedor_viajes">
        <?php foreach ($infoviaje as $viaje): ?>
            <div class="viaje">
                <h3>Viaja con <?php echo ($viaje['NOMBRE'] . ' ' . $viaje['APELLIDO1'] . ' ' . $viaje['APELLIDO2']); ?></h3>
                <img src="<?php echo '../assets/img/perfilusuario/' . $viaje['FOTO']; ?>" alt="Foto <?php echo $viaje['NOMBRE']; ?>" height="50" width="50">
                <p>Origen: <?php echo $viaje['ORIGEN']; ?></p>
                <p>Destino: <?php echo $viaje['DESTINO']; ?></p>
                <p>Fecha y hora: <?php echo $viaje['FECHA_HORA']; ?></p>
                <p>Plazas totales: <?php echo $viaje['PLAZAS_TOTALES']; ?></p>
                <p>Precio: <?php echo $viaje['PRECIO']; ?></p>
                <p>Descripción extra: <?php echo $viaje['DESCRIPCION_EXTRA']; ?></p>
                <button type="button">Reservar</button>
            </div>
        <?php endforeach; ?>
    <?php else: ?>

        <p>No hay viajes disponibles con estos filtros</p>

        <?php $error_busqueda = "SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.NOMBRE_CIUDAD AS ORIGEN, C2.NOMBRE_CIUDAD AS DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO"; ?>
        <?php $stmt = $pdo->prepare($error_busqueda);
        $stmt->execute();

        $error_viajes = $stmt->fetchAll(PDO::FETCH_ASSOC); ?>

        <?php foreach ($error_viajes as $viaje): ?>
            <div class="viaje">
                <h3>Viaja con <?php echo ($viaje['NOMBRE'] . ' ' . $viaje['APELLIDO1'] . ' ' . $viaje['APELLIDO2']); ?></h3>
                <img src="<?php echo '../assets/img/perfilusuario/' . $viaje['FOTO']; ?>" alt="Foto <?php echo $viaje['NOMBRE']; ?>" height="50" width="50">
                <p>Origen: <?php echo $viaje['ORIGEN']; ?></p>
                <p>Destino: <?php echo $viaje['DESTINO']; ?></p>
                <p>Fecha y hora: <?php echo $viaje['FECHA_HORA']; ?></p>
                <p>Plazas totales: <?php echo $viaje['PLAZAS_TOTALES']; ?></p>
                <p>Precio: <?php echo $viaje['PRECIO']; ?></p>
                <p>Descripción extra: <?php echo $viaje['DESCRIPCION_EXTRA']; ?></p>
                <button type="button">Reservar</button>
            </div>

        <?php endforeach; ?>
    <?php endif; ?>
    </div>

</div>