<?php

        require_once '../config/db.php';  
        
        $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1"); // LOGO Y NOMBRE DE LA EMPRESA //
        $empresa = $stmtlogo->fetch();
        
        $stmtusuario = $pdo->query("SELECT foto, nombre FROM usuario LIMIT 1"); // FOTO Y NOMBRE DEL USUARIO LOGUEADO //
        $perfilusuario = $stmtusuario->fetch();

        $stmtmenu = $pdo->query("SELECT OPCION, SECCION FROM menu WHERE ID!=9 AND ID!=10 AND ID!=11 ORDER BY ORDEN ASC"); // OPCIONES DE MENÚ PRINCIPAL SELECCIONA TODAS LAS SECCIONES MENOS LA 9, 10 Y 11 //
        $menupagina = $stmtmenu->fetchAll();

        $stmtmenuusuario = $pdo->query("SELECT OPCION, SECCION FROM MENU WHERE ID=9 OR ID=10 OR ID=11");
        $menuusuario = $stmtmenuusuario->fetchall(); // LO MISMO QUE LA ANTERIOR PERO SOLO CON LAS SECCIONES 9, 10 Y 11 //


?>



<div class="logo">

        <img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>" height="50" width="100">

</div>



<div class="menu">

        <ul>
                <?php if (count($menupagina) > 0): ?>
                        <?php foreach ($menupagina as $menu): ?>
                        <li>
                                <a href="<?= $menu['SECCION'] ?>"><?= strtoupper($menu['OPCION']) ?></a>
                        </li>
                <?php endforeach; ?>
                <?php else: ?>
                        <li>
                                <a href="#buscar">MENÚ VACÍO</a>
                        </li>
                <?php endif; ?>
        </ul>

</div>


<div class="perfil">

        <img src="../assets/img/perfilusuario/<?=$perfilusuario['foto']?>" alt="<?=$perfilusuario['nombre']?>" height="50" width="50">

        <div class="submenu">
                <ul>
                        <?php if (count($menuusuario) > 0): ?>
                                <?php foreach ($menuusuario as $submenu): ?>
                                <li>
                                        <a href="<?= $submenu['SECCION'] ?>"><?= strtoupper($submenu['OPCION']) ?></a>
                                </li>
                        <?php endforeach; ?>
                        <?php else: ?>
                                <li>
                                        <a href="#buscar">MENÚ VACÍO</a>
                                </li>
                        <?php endif; ?>
                </ul>

        </div>

</div>


