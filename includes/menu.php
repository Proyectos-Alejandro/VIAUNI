<?php

        require_once '../config/db.php';  
        
        $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1"); // LOGO Y NOMBRE DE LA EMPRESA //
        $empresa = $stmtlogo->fetch();
        
        $stmtusuario = $pdo->query("SELECT foto, nombre FROM usuario where id = " . $_SESSION['user_id'] . " LIMIT 1"); // FOTO Y NOMBRE DEL USUARIO LOGUEADO //
        $perfilusuario = $stmtusuario->fetch();

        $stmtmenu = $pdo->query("SELECT OPCION, SECCION FROM menu WHERE ID!=9 AND ID!=10 AND ID!=11 AND ID!=12 ORDER BY ORDEN ASC"); // OPCIONES DE MENÚ PRINCIPAL SELECCIONA TODAS LAS SECCIONES MENOS LA 9, 10 Y 11 //
        $menupagina = $stmtmenu->fetchAll();

        $stmtmenuusuario = $pdo->query("SELECT OPCION, SECCION FROM MENU WHERE ID!=1 AND ID!=2 AND ID!=3 AND ID!=4 AND ID!=10 AND ID!=9 ORDER BY ORDEN ASC"); 
        $menuusuario = $stmtmenuusuario->fetchall(); // LO MISMO QUE LA ANTERIOR PERO SOLO CON LAS SECCIONES 9, 10 Y 11 //

        $stmtregin =$pdo->query("SELECT ID FROM usuario WHERE ID=9 OR ID=10");
        $menu_regin = $stmtregin->fetchall();

        $usuario_imagen = $_SESSION['user_id'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MENU</title>
        <link rel="stylesheet" href="../assets/css/style_menu.css">
</head>
<body>

<nav class="navperfil">

<div class="menu_container">
        <div class="logo">

        <a href="#home"><img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>"> </a>

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

                        
                        <input type="checkbox" id="menu-toggle" class="menu-checkbox">
                        <label for="menu-toggle">
                                <img src="<?php echo '../assets/img/perfilusuario/' . ($perfilusuario['foto']); ?>" alt="<?=$perfilusuario['nombre']?>" class="perfilfoto">
                        </label>
                        
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

</div>
</nav> 
</body>
</html>
