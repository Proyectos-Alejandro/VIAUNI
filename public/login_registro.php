<?php
session_start();
require_once '../config/db.php';
$mensaje = "";


if (isset($_POST['btn_registro'])) {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT, ["cost" => 10]); // ENCRIPTADO DE CONTRASEÑA CON BCRYPT Y COSTE 10, MAS SEGYRA PERO SI SE PONE MAS TARDA MAS EN CARGAR //


    if (strlen($password) < 7) { // REQUISITOS DE LA CONTRASEÑA //
        
        $mensaje = "La contraseña es muy sencilla, debe tener al menos 7 caracteres";
    } else if (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^\w]/', $password)) {
        $mensaje = "La contraseña debe tener como mínimo una mayúscula, un número y un carácter especial";
    }else{ // SI SE HA CUMPLIDO TODO LO DE ANTES COMPRUEBA SI EL CORREO YA ESTÁ REGISTRADO //
        
        $check = $pdo->prepare("SELECT ID FROM usuario WHERE CORREO = :email");
        $check->execute([':email' => $email]);

        if ($check->rowCount() > 0) {  // SI EL CORREO YA EXISTE DA UN ERROR //
            $mensaje = "Tu correo ya está registrado";
        } else { // SI NO EXISTE EL CORREO, CREA LA CUENTA SIN FOTO POR EL MOMENTO //
            
            $sql = "INSERT INTO usuario (NOMBRE, APELLIDO1, APELLIDO2, CORREO, PASSWORD, FOTO) 
                    VALUES (:nombre, :apellido1, :apellido2, :email, :password_hash, 'sinfoto.png')";
            $stmt = $pdo->prepare($sql);
            

            // COMPRUEBA SI SE HA CREADO LA CUENTA CORRECTAMENTE Y MUESTRA UN MENSAJE //
            if ($stmt->execute([':nombre' => $nombre, ':apellido1' => $apellido1, ':apellido2' => $apellido2, ':email' => $email, ':password_hash' => $password_hash])) {
                $mensaje = "¡Cuenta creada! Ahora inicia sesión.";
            } else { // ERROR SI NO SE HA PODIDO CREAR LA CUENTA //
                $mensaje = "Error al registrarse.";
            }
        }
    }
}


if (isset($_POST['btn_login'])) {  // COMPROBAR SI LA INFO EXISTE EN LA BASE DE DATOS // 
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM usuario WHERE CORREO = :email");
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['PASSWORD'])) {

        $_SESSION['user_id'] = $usuario['ID'];
        $_SESSION['user_nombre'] = $usuario['NOMBRE'];
        $_SESSION['user_foto'] = $usuario['FOTO'];
        
        header("Location: index.php");
        exit();
    } else { // SI NO SE HA ENCONTRADO EL USUARIO O LA CONTRASEÑA ES INCORRECTA  ERROR //
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
      // DECORACIÓN //  
        $stmtlogo = $pdo->query("SELECT logo, nombre FROM empresa LIMIT 1");
        $empresa = $stmtlogo->fetch();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BLABLAX</title>
</head>
<body class="pagina_login">

    <div class="caja_login">
        <div class="info_login">
            <img src="../assets/img/<?=$empresa['logo']?>" alt="<?=$empresa['nombre']?>" height="50" width="100">
            <h2>Comparte tu viaje a la UAX</h2>
            <p>Conecta, ahorra y viaja cómodo.</p>
        </div>

        <div class="formulario_login">
            
            <?php if(!empty($mensaje)): ?>
                <div class="alerta"><?= $mensaje ?></div>
            <?php endif; ?>

            <div id="formulario_login">
                <h3>INICIAR SESIÓN</h3>
                <form method="POST" action="">
                    <input type="email" name="email" placeholder="Correo UAX (ej. a.calv.mat@myuax.com)" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit" name="btn_login" class="btn-full">ENTRAR</button>
                </form>
                <p class="cambiar_texto">¿No tienes cuenta? <a href="#">Regístrate aquí</a></p>
            </div>

            <div id="formulario_registro">
                <h3>CREAR CUENTA</h3>
                <form method="POST" action="">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    <input type="text" name="apellido1" placeholder="Primer Apellido" required>
                    <input type="text" name="apellido2" placeholder="Segundo Apellido" required>
                    <input type="email" name="email" placeholder="Correo Electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit" name="btn_registro" class="btn-full btn-outline">REGISTRARSE</button>
                </form>
                <p class="cambiar_texto">¿Ya tienes cuenta? <a href="#">Inicia sesión</a></p>
            </div>

        </div>
    </div>

</body>
</html>