<?php
    require_once '../config/db.php';

    
    $accion = $_GET['accion'] ?? '';

    if ($accion === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') { // SI SE ENVIA UNA FOTO EN EL FORMULARIO SE GUARDA EN LA BASE DE DATOS //

        $nombre = $_POST['nombre'];
        $ID_usuario = $_SESSION['user_id']; // OBTENEMOS EL ID DEL USUARIO LOGUEADO //
        $email = $_POST['email'];
        $descripcion = $_POST['descripcion'];
        $rutafoto = null; 

        if (!empty($_FILES['imagen']['name'])) {
            $carpetaImagenes = '../assets/img/fotosformulario/';
            $nombreImagen = uniqid() . '_' . $_FILES['imagen']['name'];
            
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $carpetaImagenes . $nombreImagen)) {
                $rutafoto = $carpetaImagenes . $nombreImagen;
            }
        }

        
        $stmt = $pdo->prepare("INSERT INTO formulario_ayuda (ID_USUARIO, NOMBRE, EMAIL, DESCRIPCION, IMAGEN_APORTADA) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$ID_usuario, $nombre, $email, $descripcion, $rutafoto]);  // ESTO GUARDA LOS DATOS EN LA BASE DE DATOS //

        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Ayuda</title>
    <link rel="stylesheet" href="../assets/css/style_form_ayuda.css">
</head>
<body>

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Ayuda</title>
    <link rel="stylesheet" href="../assets/css/style_formulario.css">
</head>
<body>

    <div class="formulario_wrapper">
        <div class="formulario_card">
            
            <div class="formulario_cabecera">
                <h2 class="titulo_formulario">¿Necesitas Ayuda?</h2>
                <p>Rellena el formulario y nos pondremos en contacto contigo lo antes posible.</p>
            </div>
            
            <form action="?accion=crear" method="POST">

                <div class="form_group">
                    <label class="label_form">Nombre completo</label>
                    <input type="text" name="nombre" class="input_form" placeholder="Ej. Alejandro Calvo Mateos" required>
                </div>

                <div class="form_group">
                    <label class="label_form">Correo electrónico</label>
                    <input type="email" name="email" class="input_form" placeholder="Ej. acalvmat@myuax.com" required>
                </div>

                <div class="form_group">
                    <label class="label_form">Descríbenos tu problema</label>
                    <textarea name="descripcion" class="input_form textarea_form" rows="4" placeholder="Dinos aquí lo que te ocurre..." required></textarea>
                </div>

                <div class="form_group">
                    <label class="label_form">Imagen a aportar (Opcional)</label>
                    <input type="file" name="imagen" class="input_file">
                </div>

                <button type="submit" class="btn_form" name="btn_formulario">ENVIAR MENSAJE</button>
            </form>
        </div>
    </div>

</body>
</html>

</body>
</html>