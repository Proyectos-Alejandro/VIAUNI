<?php 
require_once '../config/db.php';

//$stmt = $pdo->query("SELECT  FROM  INNER JOIN  ON  INNER JOIN  ON  INNER JOIN ;");

//$nuevoviaje = $stmt->fetchAll(PDO::FETCH_ASSOC);

//$publicarviaje = $pdo->query("SELECT  FROM  WHERE ");
//$nuevosviajes = $publicarviaje->fetchAll(PDO::FETCH_ASSOC);
?>




<div class="filtros_publicar">

    <form action="index.php">

        <fieldset class="fieldset_publicar">
            <legend>PUBLICA TU VIAJE</legend>
            
            <input type="text" name="filtro_origen"  placeholder="Origen">
            <input type="text" name="filtro_destino" placeholder="Destino">
            <input type="date" name="filtro_fecha">
            <input type="text" name="filtro_plazas" placeholder="Nº de Plazas">
            <input type="number" name="precio" placeholder="Precio">
            <button type="submit">PUBLICAR</button>

        </fieldset>
        
    </form>

</div>






