<?php
    require_once '../config/db.php';

    
    $accion = $_GET['accion'] ?? '';

    if ($accion === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') { // SI SE ENVIA UNA FOTO EN EL FORMULARIO SE GUARDA EN LA BASE DE DATOS //

        $nombre = $_POST['nombre'];
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

        
        $stmt = $pdo->prepare("INSERT INTO formulario_ayuda (nombre, email, descripcion, imagen_aportada) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $email, $descripcion, $rutafoto]);  // ESTO GUARDA LOS DATOS EN LA BASE DE DATOS //

        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario Ayuda</title>
</head>
<body>

    <h2 class="titulo_formulario">FORMULARIO AYUDA</h2>
    
    <form action="?accion=crear" method="POST" enctype="multipart/form-data">

        <div class="nombre">
            <label class="label_form">Nombre:</label>
            <input type="text" name="nombre" class="input_form" required>
        </div>

        <div class="email">
            <label class="label_form">Email:</label>
            <input type="email" name="email" class="input_form" required>
        </div>

        <div class="descripcion">
            <label class="label_form">Describenos tu problema:</label>
            <input type="text" name="descripcion" class="input_form" required>
        </div>

        <div class="imagen">
            <label class="label_form">Imagen a aportar:</label>
            <input type="file" name="imagen" class="input_form">
        </div>

        <button class="btn_form" name="btn_formulario">ENVIAR</button>
    </form>

</body>
</html>