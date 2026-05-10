<?php 
    $stmt_ciudades = $pdo->query("SELECT DISTINCT PAIS, PROVINCIA, MUNICIPIO, CP FROM CIUDADES");
    $ciudades = $stmt_ciudades->fetchAll(PDO::FETCH_ASSOC);

    $viajes_pais = array_unique(array_column($ciudades, 'PAIS'));
    $viajes_provincia = array_unique(array_column($ciudades, 'PROVINCIA'));
    $viajes_municipio = array_unique(array_column($ciudades, 'MUNICIPIO'));
    $viajes_cp = array_unique(array_column($ciudades, 'CP'));

    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina < 1) $pagina = 1;
    $inicio = ($pagina - 1) * 6; 

    $filtro_origen_pais = $_GET['filtro_origen_pais'] ?? '';
    $filtro_origen_provincia = $_GET['filtro_origen_provincia'] ?? '';
    $filtro_origen_municipio = $_GET['filtro_origen_municipio'] ?? '';
    $filtro_origen_cp = $_GET['filtro_origen_cp'] ?? '';
    $filtro_destino_pais = $_GET['filtro_destino_pais'] ?? '';
    $filtro_destino_provincia = $_GET['filtro_destino_provincia'] ?? '';
    $filtro_destino_municipio = $_GET['filtro_destino_municipio'] ?? '';
    $filtro_destino_cp = $_GET['filtro_destino_cp'] ?? '';
    $filtro_fecha = $_GET['filtro_fecha'] ?? '';
    $filtro_plazas = $_GET['filtro_plazas'] ?? '';

    $sql_base = "SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, 
        C1.PAIS AS PAIS_ORIGEN, C1.PROVINCIA AS PROVINCIA_ORIGEN, C1.MUNICIPIO AS MUNICIPIO_ORIGEN, C1.CP AS CP_ORIGEN, 
        C2.PAIS AS PAIS_DESTINO, C2.PROVINCIA AS PROVINCIA_DESTINO, C2.MUNICIPIO AS MUNICIPIO_DESTINO, C2.CP AS CP_DESTINO, 
        V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA 
        FROM VIAJES V 
        INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID 
        INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN 
        INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO 
        WHERE 1=1";

    $filtro_viaje = $sql_base;
    if (!empty($filtro_origen_pais)) { $filtro_viaje .= " AND C1.PAIS LIKE :PAIS_ORIGEN"; }
    if (!empty($filtro_origen_provincia)) { $filtro_viaje .= " AND C1.PROVINCIA LIKE :PROVINCIA_ORIGEN"; }
    if (!empty($filtro_origen_municipio)) { $filtro_viaje .= " AND C1.MUNICIPIO LIKE :MUNICIPIO_ORIGEN"; }
    if (!empty($filtro_origen_cp)) { $filtro_viaje .= " AND C1.CP LIKE :CP_ORIGEN"; }
    if (!empty($filtro_destino_pais)) { $filtro_viaje .= " AND C2.PAIS LIKE :PAIS_DESTINO"; }
    if (!empty($filtro_destino_provincia)) { $filtro_viaje .= " AND C2.PROVINCIA LIKE :PROVINCIA_DESTINO"; }
    if (!empty($filtro_destino_municipio)) { $filtro_viaje .= " AND C2.MUNICIPIO LIKE :MUNICIPIO_DESTINO"; }
    if (!empty($filtro_destino_cp)) { $filtro_viaje .= " AND C2.CP LIKE :CP_DESTINO"; }
    if (!empty($filtro_fecha)) { $filtro_viaje .= " AND DATE(V.FECHA_HORA) = :fecha"; }
    if (!empty($filtro_plazas)) { $filtro_viaje .= " AND V.PLAZAS_TOTALES = :plazas"; }

    $filtro_viaje .= " ORDER BY V.FECHA_HORA ASC, V.PRECIO ASC LIMIT :inicio, 7";

    $stmt = $pdo->prepare($filtro_viaje);
    if (!empty($filtro_origen_pais)) { $stmt->bindValue(':PAIS_ORIGEN', '%' . $filtro_origen_pais . '%'); }
    if (!empty($filtro_origen_provincia)) { $stmt->bindValue(':PROVINCIA_ORIGEN', '%' . $filtro_origen_provincia . '%'); }
    if (!empty($filtro_origen_municipio)) { $stmt->bindValue(':MUNICIPIO_ORIGEN', '%' . $filtro_origen_municipio . '%'); }
    if (!empty($filtro_origen_cp)) { $stmt->bindValue(':CP_ORIGEN', '%' . $filtro_origen_cp . '%'); }
    if (!empty($filtro_destino_pais)) { $stmt->bindValue(':PAIS_DESTINO', '%' . $filtro_destino_pais . '%'); }
    if (!empty($filtro_destino_provincia)) { $stmt->bindValue(':PROVINCIA_DESTINO', '%' . $filtro_destino_provincia . '%'); }
    if (!empty($filtro_destino_municipio)) { $stmt->bindValue(':MUNICIPIO_DESTINO', '%' . $filtro_destino_municipio . '%'); }
    if (!empty($filtro_destino_cp)) { $stmt->bindValue(':CP_DESTINO', '%' . $filtro_destino_cp . '%'); }
    if (!empty($filtro_fecha)) { $stmt->bindValue(':fecha', $filtro_fecha); }
    if (!empty($filtro_plazas)) { $stmt->bindValue(':plazas', (int)$filtro_plazas); }
    
    $stmt->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt->execute();
    $infoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hay_siguiente = false;
    $mostrando_todos = false;

    if (count($infoviaje) == 0) {
        $mostrando_todos = true;
        
        $sql_todos = $sql_base . " ORDER BY V.FECHA_HORA ASC, V.PRECIO ASC LIMIT :inicio, 7";
        $stmt_todos = $pdo->prepare($sql_todos);
        $stmt_todos->bindValue(':inicio', $inicio, PDO::PARAM_INT);
        $stmt_todos->execute();
        $infoviaje = $stmt_todos->fetchAll(PDO::FETCH_ASSOC);
    }

    if (count($infoviaje) > 6) {
        $hay_siguiente = true;
        array_pop($infoviaje);
    }
?>

<link rel="stylesheet" href="../assets/css/style_buscarviaje.css">

<div class="buscar_wrapper">
    <div class="buscar_card">
        <form action="index.php" method="GET" class="form_buscar">
            <h2 class="titulo_buscar">Encuentra tu viaje ideal</h2>
            
            <div class="grid_buscar">
                <div class="columna_buscar">
                    <span class="etiqueta_buscar">Origen</span>
                    
                    <input list="filtro_origen_pais" name="filtro_origen_pais" class="input_buscar" placeholder="País Origen" value="<?php echo htmlspecialchars($filtro_origen_pais); ?>">
                    <datalist id="filtro_origen_pais"><?php foreach($viajes_pais as $p) echo "<option value=\"$p\">"; ?></datalist>

                    <input list="filtro_origen_provincia" name="filtro_origen_provincia" class="input_buscar" placeholder="Provincia Origen" value="<?php echo htmlspecialchars($filtro_origen_provincia); ?>">
                    <datalist id="filtro_origen_provincia"><?php foreach($viajes_provincia as $p) echo "<option value=\"$p\">"; ?></datalist>

                    <input list="filtro_origen_municipio" name="filtro_origen_municipio" class="input_buscar" placeholder="Municipio Origen" value="<?php echo htmlspecialchars($filtro_origen_municipio); ?>">
                    <datalist id="filtro_origen_municipio"><?php foreach($viajes_municipio as $m) echo "<option value=\"$m\">"; ?></datalist>

                    <input list="filtro_origen_cp" name="filtro_origen_cp" class="input_buscar" placeholder="CP Origen" value="<?php echo htmlspecialchars($filtro_origen_cp); ?>">
                    <datalist id="filtro_origen_cp"><?php foreach($viajes_cp as $cp) echo "<option value=\"$cp\">"; ?></datalist>
                </div>

                <div class="separador_buscar"><span>&#10142;</span></div>

                <div class="columna_buscar">
                    <span class="etiqueta_buscar">Destino</span>
                    
                    <input list="filtro_destino_pais" name="filtro_destino_pais" class="input_buscar" placeholder="País Destino" value="<?php echo htmlspecialchars($filtro_destino_pais); ?>">
                    <datalist id="filtro_destino_pais"><?php foreach($viajes_pais as $p) echo "<option value=\"$p\">"; ?></datalist>

                    <input list="filtro_destino_provincia" name="filtro_destino_provincia" class="input_buscar" placeholder="Provincia Destino" value="<?php echo htmlspecialchars($filtro_destino_provincia); ?>">
                    <datalist id="filtro_destino_provincia"><?php foreach($viajes_provincia as $p) echo "<option value=\"$p\">"; ?></datalist>

                    <input list="filtro_destino_municipio" name="filtro_destino_municipio" class="input_buscar" placeholder="Municipio Destino" value="<?php echo htmlspecialchars($filtro_destino_municipio); ?>">
                    <datalist id="filtro_destino_municipio"><?php foreach($viajes_municipio as $m) echo "<option value=\"$m\">"; ?></datalist>

                    <input list="filtro_destino_cp" name="filtro_destino_cp" class="input_buscar" placeholder="CP Destino" value="<?php echo htmlspecialchars($filtro_destino_cp); ?>">
                    <datalist id="filtro_destino_cp"><?php foreach($viajes_cp as $cp) echo "<option value=\"$cp\">"; ?></datalist>
                </div>

                <div class="columna_buscar detalles_buscar">
                    <span class="etiqueta_buscar">Detalles</span>
                    <input type="date" name="filtro_fecha" class="input_buscar" value="<?php echo htmlspecialchars($filtro_fecha); ?>">
                    <input type="text" name="filtro_plazas" class="input_buscar" placeholder="Nº de Plazas" value="<?php echo htmlspecialchars($filtro_plazas); ?>">
                    <button type="submit" class="btn_buscar">BUSCAR</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="filtro_resultado"> 

    <?php if ($mostrando_todos): ?>
        <div class="alerta_sin_viajes">No hay viajes disponibles con estos filtros. Mostrando otros viajes:</div>
    <?php endif; ?>

    <?php if (count($infoviaje) > 0): ?> 
        <div class="contenedor_viajes_grid">
            <?php foreach ($infoviaje as $viaje): ?>
                <div class="tarjeta_viaje">
                    <div class="tv_cabecera">
                        <img src="<?php echo '../assets/img/perfilusuario/' . ($viaje['FOTO']); ?>" alt="Foto" class="tv_foto">
                        <div class="tv_info_conductor">
                            <h4><?php echo ($viaje['NOMBRE'] . ' ' . $viaje['APELLIDO1'] . ' ' . $viaje['APELLIDO2']); ?></h4>
                        </div>
                    </div>

                    <div class="tv_cuerpo">
                        <div class="tv_ruta">
                            <div class="punto_origen"><p class="etiqueta_buscar">De: <?php echo ($viaje['MUNICIPIO_ORIGEN'] . ', ' . $viaje['PROVINCIA_ORIGEN']); ?></p> </div>
                            <div class="linea"></div>
                            <div class="punto_destino"><p class="etiqueta_buscar">A: <?php echo ($viaje['MUNICIPIO_DESTINO'] . ', ' . $viaje['PROVINCIA_DESTINO']); ?></p></div>
                        </div>
                        
                        <div class="tv_detalles_extra">
                            <p><?php echo $viaje['FECHA_HORA']; ?></p>
                            <?php if(!empty($viaje['DESCRIPCION_EXTRA'])): ?>
                                <p class="nota_extra">"<?php echo $viaje['DESCRIPCION_EXTRA']; ?>"</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="tv_pie">
                        <div class="tv_precio_plazas">
                            <span class="precio"><?php echo $viaje['PRECIO']; ?>€</span>
                            <span class="plazas"><?php echo $viaje['PLAZAS_TOTALES']; ?> plazas</span>
                        </div>
                        <button type="button" class="btn_reservar">Reservar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <?php 
                $parametros_url = $_GET; 
            ?>

            <?php if ($pagina > 1): ?>
                <?php $parametros_url['pagina'] = $pagina - 1; ?>
                <a href="index.php?<?php echo http_build_query($parametros_url); ?>" class="btn_buscar">← Anterior</a>
            <?php endif; ?>

            <span>Página <?php echo $pagina; ?></span>

            <?php if ($hay_siguiente): ?>
                <?php $parametros_url['pagina'] = $pagina + 1; ?>
                <a href="index.php?<?php echo http_build_query($parametros_url); ?>" class="btn_buscar">Siguiente →</a>
            <?php endif; ?>
        </div>

    <?php else: ?>
        <div class="alerta_sin_viajes">Aún no hay ningún viaje registrado en la plataforma.</div>
    <?php endif; ?>

</div>