<?php

        require_once '../config/db.php';
        
        $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");
        $empresa = $stmtlogo->fetch();
        
        $stmtusuario = $pdo->query("SELECT foto, nombre FROM usuario LIMIT 1");
        $perfilusuario = $stmtusuario->fetch();

        $stmtmenu = $pdo->query("SELECT OPCION, SECCION FROM menu ORDER BY ORDEN ASC");
        $menupagina = $stmtmenu->fetchAll();

?>


<div class="logo">

        <img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>" height="50" width="100">

</div>



<div class="menu">

        <ul>
                <?php if (count($menupagina) > 0): ?>
                        <?php foreach ($menupagina as $seccion): ?>
                        <li>
                                <a href="<?= $seccion['SECCION'] ?>"><?= strtoupper($seccion['OPCION']) ?></a>
                        </li>
                <?php endforeach; ?>
                <?php else: ?>
                        <li><a href="#buscar">¡MENÚ VACÍO!</a></li>
                <?php endif; ?>
        </ul>

</div>


<div class="perfil">

        <img src="../assets/img/perfilusuario/<?=$perfilusuario['foto']?>" alt="<?=$perfilusuario['nombre']?>" height="50" width="50">

</div>


