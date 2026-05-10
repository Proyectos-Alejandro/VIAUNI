<?php 
    require_once '../config/db.php';

    $stmt_ciudades = $pdo->query("SELECT DISTINCT ID, PAIS, PROVINCIA, MUNICIPIO, CP FROM CIUDADES");
    $ciudades = $stmt_ciudades->fetchAll(PDO::FETCH_ASSOC);
    $viajes = $ciudades; 
    $viajes_pais = array_unique(array_column($ciudades, 'PAIS'));
    $viajes_provincia = array_unique(array_column($ciudades, 'PROVINCIA'));
    $viajes_municipio = array_unique(array_column($ciudades, 'MUNICIPIO'));
    $viajes_cp = array_unique(array_column($ciudades, 'CP'));
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
                    <?php if(count($viajes_pais) > 0) foreach ($viajes_pais as $vp) echo '<option value="'.$vp.'">'; ?>
                </datalist>

                <input list="filtro_origen_provincia" name="filtro_origen_provincia" class="input_form" placeholder="Provincia Origen">
                <datalist id="filtro_origen_provincia">
                    <?php if(count($viajes_provincia) > 0) foreach ($viajes_provincia as $vp) echo '<option value="'.$vp.'">'; ?>
                </datalist>

                <input list="filtro_origen_municipio" name="filtro_origen_municipio" class="input_form" placeholder="Municipio Origen">
                <datalist id="filtro_origen_municipio">
                    <?php if(count($viajes_municipio) > 0) foreach ($viajes_municipio as $vm) echo '<option value="'.$vm.'">'; ?>
                </datalist>

                <input list="filtro_origen_cp" name="filtro_origen_cp" class="input_form" placeholder="CP Origen">
                <datalist id="filtro_origen_cp">
                    <?php if(count($viajes_cp) > 0) foreach ($viajes_cp as $vcp) echo '<option value="'.$vcp.'">'; ?>
                </datalist>
            </div>

            <div class="separador_ruta">&#8595;</div> 
            
            <div class="grupo_compacto">
                <input list="filtro_destino_pais" name="filtro_destino_pais" class="input_form" placeholder="País Destino">
                <datalist id="filtro_destino_pais"><?php if(count($viajes_pais) > 0) foreach ($viajes_pais as $vp) echo '<option value="'.$vp.'">'; ?></datalist>

                <input list="filtro_destino_provincia" name="filtro_destino_provincia" class="input_form" placeholder="Provincia Destino">
                <datalist id="filtro_destino_provincia"><?php if(count($viajes_provincia) > 0) foreach ($viajes_provincia as $vp) echo '<option value="'.$vp.'">'; ?></datalist>

                <input list="filtro_destino_municipio" name="filtro_destino_municipio" class="input_form" placeholder="Municipio Destino">
                <datalist id="filtro_destino_municipio"><?php if(count($viajes_municipio) > 0) foreach ($viajes_municipio as $vm) echo '<option value="'.$vm.'">'; ?></datalist>

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

<div class="filtro_resultado"> 
    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $publicar_origen_municipio = $_POST['filtro_origen_municipio'] ?? '';
            $publicar_origen_cp = $_POST['filtro_origen_cp'] ?? '';
            $publicar_destino_municipio = $_POST['filtro_destino_municipio'] ?? '';
            $publicar_destino_cp = $_POST['filtro_destino_cp'] ?? '';
            $publicar_fecha = $_POST['filtro_fecha'] ?? '';
            $publicar_descripcion = $_POST['filtro_descripcion'] ?? '';
            $publicar_precio = $_POST['filtro_precio'] ?? '';
            $publicar_plazas = $_POST['filtro_plazas'] ?? '';
            $publicar_conductor = $_SESSION['user_id'];

            $origenId = null;
            $destinoId = null;

            if (!empty($publicar_origen_municipio)) {
                $stmt = $pdo->prepare("SELECT ID FROM CIUDADES WHERE MUNICIPIO = ?");
                $stmt->execute([$publicar_origen_municipio]);
                $origenId = $stmt->fetchColumn();
            }


            if (!$origenId && !empty($publicar_origen_cp)) {
                $stmt = $pdo->prepare("SELECT ID FROM CIUDADES WHERE CP = ?");
                $stmt->execute([$publicar_origen_cp]);
                $origenId = $stmt->fetchColumn();
            }

            if (!empty($publicar_destino_municipio)) {
                $stmt = $pdo->prepare("SELECT ID FROM CIUDADES WHERE MUNICIPIO = ?");
                $stmt->execute([$publicar_destino_municipio]);
                $destinoId = $stmt->fetchColumn();
            }
            if (!$destinoId && !empty($publicar_destino_cp)) {
                $stmt = $pdo->prepare("SELECT ID FROM CIUDADES WHERE CP = ?");
                $stmt->execute([$publicar_destino_cp]);
                $destinoId = $stmt->fetchColumn();
            }

            if ($origenId && $destinoId) {
                $stmt = $pdo->prepare("INSERT INTO VIAJES (CONDUCTOR_ID, ID_ORIGEN, ID_DESTINO, FECHA_HORA, PLAZAS_TOTALES, PRECIO, DESCRIPCION_EXTRA) VALUES (?, ?, ?, ?, ?, ?, ?)");
                
                if ($stmt->execute([$publicar_conductor, $origenId, $destinoId, $publicar_fecha, $publicar_plazas, $publicar_precio, $publicar_descripcion])) {
                    echo "<p>¡Viaje publicado correctamente!</p>";
                } else {
                    echo "<p>Error al publicar el viaje.</p>";
                }
            } else {
                echo "<p>Error: No se ha encontrado la ciudad de origen o destino.</p>";
            }
        }
    ?>
</div>
</body>
</html>