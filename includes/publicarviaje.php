<?php 
    require_once '../config/db.php';

    $stmt = $pdo->query("SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.PAIS AS PAIS_ORIGEN,C1.PROVINCIA AS PROVINCIA_ORIGEN,C1.MUNICIPIO AS MUNICIPIO_ORIGEN,C1.CP AS CP_ORIGEN, C2.PAIS AS PAIS_DESTINO, C2.PROVINCIA AS PROVINCIA_DESTINO,C2.MUNICIPIO AS MUNICIPIO_DESTINO,C2.CP AS CP_DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO;");
    $infoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje = $pdo->query("SELECT ID, PAIS, PROVINCIA, MUNICIPIO, CP FROM CIUDADES WHERE PAIS COLLATE utf8mb4_unicode_ci LIKE '%%' AND PROVINCIA COLLATE utf8mb4_unicode_ci LIKE '%%' AND MUNICIPIO COLLATE utf8mb4_unicode_ci LIKE '%%' AND CP COLLATE utf8mb4_unicode_ci LIKE '%%';");
    $viajes = $opcionesviaje->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje_pais = $pdo->query("SELECT DISTINCT PAIS FROM CIUDADES WHERE PAIS COLLATE utf8mb4_unicode_ci LIKE '%%';");
    $viajes_pais = $opcionesviaje_pais->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje_provincia = $pdo->query("SELECT DISTINCT PROVINCIA FROM CIUDADES WHERE PROVINCIA COLLATE utf8mb4_unicode_ci LIKE '%%';");
    $viajes_provincia = $opcionesviaje_provincia->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje_municipio = $pdo->query("SELECT DISTINCT MUNICIPIO FROM CIUDADES WHERE MUNICIPIO COLLATE utf8mb4_unicode_ci LIKE '%%';");
    $viajes_municipio = $opcionesviaje_municipio->fetchAll(PDO::FETCH_ASSOC);

    $opcionesviaje_cp = $pdo->query("SELECT DISTINCT CP FROM CIUDADES WHERE CP COLLATE utf8mb4_unicode_ci LIKE '%%';");
    $viajes_cp = $opcionesviaje_cp->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style_publicar.css">
</head>
<body>
<div class="formulario_wrapper">
    
    <div class="formulario_card">
        <div class="formulario_cabecera">
            <h2 class="titulo_formulario">Publica tu Viaje</h2>
        </div>

        <form action="index.php" method="POST" class="form_publicar">
            
            <h3 class="subtitulo_ruta">Ruta</h3>
            <div class="grupo_compacto">
                <input list="filtro_origen_pais" name="filtro_origen_pais" class="input_form" placeholder="País Origen">
                <datalist id="filtro_origen_pais">
                    <?php if(count($viajes_pais) > 0) foreach ($viajes_pais as $vp) echo '<option value="'.$vp['PAIS'].'">'; ?>
                </datalist>

                <input list="filtro_origen_provincia" name="filtro_origen_provincia" class="input_form" placeholder="Provincia Origen">
                <datalist id="filtro_origen_provincia">
                    <?php if(count($viajes_provincia) > 0) foreach ($viajes_provincia as $vp) echo '<option value="'.$vp['PROVINCIA'].'">'; ?>
                </datalist>

                <input list="filtro_origen_municipio" name="filtro_origen_municipio" class="input_form" placeholder="Municipio Origen">
                <datalist id="filtro_origen_municipio">
                    <?php if(count($viajes_municipio) > 0) foreach ($viajes_municipio as $vm) echo '<option value="'.$vm['MUNICIPIO'].'">'; ?>
                </datalist>

                <input list="filtro_origen_cp" name="filtro_origen_cp" class="input_form" placeholder="CP Origen">
                <datalist id="filtro_origen_cp">
                    <?php if(count($viajes_cp) > 0) foreach ($viajes_cp as $vcp) echo '<option value="'.$vcp['CP'].'">'; ?>
                </datalist>
            </div>

            <div class="separador_ruta">&#8595;</div> <div class="grupo_compacto">
                <input list="filtro_destino_pais" name="filtro_destino_pais" class="input_form" placeholder="País Destino">
                <datalist id="filtro_destino_pais"><?php if(count($viajes_pais) > 0) foreach ($viajes_pais as $vp) echo '<option value="'.$vp['PAIS'].'">'; ?></datalist>

                <input list="filtro_destino_provincia" name="filtro_destino_provincia" class="input_form" placeholder="Provincia Destino">
                <datalist id="filtro_destino_provincia"><?php if(count($viajes_provincia) > 0) foreach ($viajes_provincia as $vp) echo '<option value="'.$vp['PROVINCIA'].'">'; ?></datalist>

                <input list="filtro_destino_municipio" name="filtro_destino_municipio" class="input_form" placeholder="Municipio Destino">
                <datalist id="filtro_destino_municipio"><?php if(count($viajes_municipio) > 0) foreach ($viajes_municipio as $vm) echo '<option value="'.$vm['MUNICIPIO'].'">'; ?></datalist>

                <input list="filtro_destino_cp" name="filtro_destino_cp" class="input_form" placeholder="CP Destino">
                <datalist id="filtro_destino_cp"><?php if(count($viajes) > 0) foreach ($viajes as $v) echo '<option value="'.$v['CP'].'">'; ?></datalist>
            </div>

            <h3 class="subtitulo_ruta">Detalles</h3>
            <div class="grupo_compacto">
                <input type="datetime-local" name="filtro_fecha" class="input_form" required>
                <div class="fila_doble">
                    <input type="number" name="filtro_plazas" class="input_form" placeholder="Nº Plazas" min="1" required>
                    <input type="number" step="0.01" name="filtro_precio" class="input_form" placeholder="Precio (€)" min="0" required>
                </div>
                <input type="text" name="filtro_descripcion" class="input_form" placeholder="Info adicional (Ej. Sin fumar)">
            </div>

            <button type="submit" class="btn_form">PUBLICAR VIAJE</button>
        </form>
    </div>

    <div class="formulario_ilustracion">
        <h2 class="eslogan">Comparte gastos.<br>Viaja mejor.</h2>
        <img src="../assets/img/coche_viauni.png" alt="Coche Viaje" class="img_coche">
    </div>

</div>

<div class="filtro_resultado"> <?php 
        
        $publicar_origen_pais = $_POST['filtro_origen_pais'] ?? '';
        $publicar_origen_provincia = $_POST['filtro_origen_provincia'] ?? '';
        $publicar_origen_municipio = $_POST['filtro_origen_municipio'] ?? '';
        $publicar_origen_cp = $_POST['filtro_origen_cp'] ?? '';
        $publicar_destino_pais = $_POST['filtro_destino_pais'] ?? '';
        $publicar_destino_provincia = $_POST['filtro_destino_provincia'] ?? '';
        $publicar_destino_municipio = $_POST['filtro_destino_municipio'] ?? '';
        $publicar_destino_cp = $_POST['filtro_destino_cp'] ?? '';
        $publicar_fecha = $_POST['filtro_fecha'] ?? '';
        $publicar_descripcion = $_POST['filtro_descripcion'] ?? '';
        $publicar_precio = $_POST['filtro_precio'] ?? '';
        $publicar_plazas = $_POST['filtro_plazas'] ?? '';
        $publicar_conductor = $_SESSION['user_id'];
        
        $filtro_publicacion = "SELECT U.NOMBRE, U.APELLIDO1, U.APELLIDO2, U.COCHE, U.FOTO, C1.PAIS AS PAIS_ORIGEN,C1.PROVINCIA AS PROVINCIA_ORIGEN,C1.MUNICIPIO AS MUNICIPIO_ORIGEN,C1.CP AS CP_ORIGEN, C2.PAIS AS PAIS_DESTINO, C2.PROVINCIA AS PROVINCIA_DESTINO,C2.MUNICIPIO AS MUNICIPIO_DESTINO,C2.CP AS CP_DESTINO, V.FECHA_HORA, V.PLAZAS_TOTALES, V.PRECIO, V.DESCRIPCION_EXTRA FROM VIAJES V INNER JOIN USUARIO U ON U.ID = V.CONDUCTOR_ID INNER JOIN CIUDADES C1 ON C1.ID = V.ID_ORIGEN INNER JOIN CIUDADES C2 ON C2.ID = V.ID_DESTINO WHERE 1=1";

        if (!empty($publicar_origen_pais)) {
            $filtro_publicacion .= " AND C1.PAIS LIKE :origen";
        }
        if (!empty($publicar_origen_provincia)) {
            $filtro_publicacion .= " AND C1.PROVINCIA LIKE :origen";
        }
        if (!empty($publicar_origen_municipio)) {
            $filtro_publicacion .= " AND C1.MUNICIPIO LIKE :origen";
        }
        if (!empty($publicar_origen_cp)) {
            $filtro_publicacion .= " AND C1.CP LIKE :origen";
        }
        if (!empty($publicar_destino_pais)) {
            $filtro_publicacion .= " AND C2.PAIS LIKE :destino";
        }
        if (!empty($publicar_destino_provincia)) {
            $filtro_publicacion .= " AND C2.PROVINCIA LIKE :destino";
        }
        if (!empty($publicar_destino_municipio)) {
            $filtro_publicacion .= " AND C2.MUNICIPIO LIKE :destino";
        }
        if (!empty($publicar_destino_cp)) {
            $filtro_publicacion .= " AND C2.CP LIKE :destino";
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
        if (!empty($publicar_origen_pais)) {
            $stmt->bindValue(':origen', '%' . $publicar_origen_pais . '%');
        }
        if (!empty($publicar_origen_provincia)) {
            $stmt->bindValue(':origen', '%' . $publicar_origen_provincia . '%');
        }
        if (!empty($publicar_origen_municipio)) {
            $stmt->bindValue(':origen', '%' . $publicar_origen_municipio . '%');
        }
        if (!empty($publicar_origen_cp)) {
            $stmt->bindValue(':origen', '%' . $publicar_origen_cp . '%');
        }
        if (!empty($publicar_destino_pais)) {
            $stmt->bindValue(':destino', '%' . $publicar_destino_pais . '%');
        }
        if (!empty($publicar_destino_provincia)) {
            $stmt->bindValue(':destino', '%' . $publicar_destino_provincia . '%');
        }
        if (!empty($publicar_destino_municipio)) {
            $stmt->bindValue(':destino', '%' . $publicar_destino_municipio . '%');
        }
        if (!empty($publicar_destino_cp)) {
            $stmt->bindValue(':destino', '%' . $publicar_destino_cp . '%');
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

            $stmtOrigen = $pdo->prepare("SELECT ID FROM CIUDADES WHERE MUNICIPIO = ?");
            $stmtOrigen->execute([$publicar_origen_municipio]);
            $origenRow = $stmtOrigen->fetch(PDO::FETCH_ASSOC);
            $origenId = $origenRow ? $origenRow['ID'] : null;
            
            $stmtDestino = $pdo->prepare("SELECT ID FROM CIUDADES WHERE MUNICIPIO = ?");
            $stmtDestino->execute([$publicar_destino_municipio]);
            $destinoRow = $stmtDestino->fetch(PDO::FETCH_ASSOC);
            $destinoId = $destinoRow ? $destinoRow['ID'] : null;

            $stmtorigen_cp = $pdo->prepare("SELECT ID FROM CIUDADES WHERE CP = ?");
            $stmtorigen_cp->execute([$publicar_origen_cp]);
            $origenCpRow = $stmtorigen_cp->fetch(PDO::FETCH_ASSOC);
            $origenCpId = $origenCpRow ? $origenCpRow['ID'] : null;

            $stmtdestino_cp = $pdo->prepare("SELECT ID FROM CIUDADES WHERE CP = ?");
            $stmtdestino_cp->execute([$publicar_destino_cp]);
            $destinoCpRow = $stmtdestino_cp->fetch(PDO::FETCH_ASSOC);
            $destinoCpId = $destinoCpRow ? $destinoCpRow['ID'] : null;


            if ($origenId && $destinoId) {
                $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$publicar_conductor, $origenId, $destinoId, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion]);
            } else if ($origenCpId && $destinoCpId) {
                $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$publicar_conductor, $origenCpId, $destinoCpId, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion]);
            } else if ($origenId && $destinoCpId) {
                $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$publicar_conductor, $origenId, $destinoCpId, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion]);
            } else if ($origenCpId && $destinoId) {
                $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$publicar_conductor, $origenCpId, $destinoId, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion]);
            } else {
                echo "<p>Error: Origen o destino inválido.</p>";
            }
        }
            
    ?>
</div>
</body>
</html>




