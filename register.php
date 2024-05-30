<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $profile_image = 'uploads/default_profile.png'; 

   
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {  // carga la imagen
        $file_tmp_path = $_FILES['profile_image']['tmp_name'];
        $file_name = $_FILES['profile_image']['name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_type = $_FILES['profile_image']['type'];
        $file_name_parts = explode(".", $file_name);
        $file_extension = strtolower(end($file_name_parts));

        $allowed_file_extensions = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($file_extension, $allowed_file_extensions)) {
            $new_file_name = md5(time() . $file_name) . '.' . $file_extension; // Generar un nombre único para la imagen y moverla al directorio de imágenes
            $upload_file_dir = 'uploads/';
            $dest_path = $upload_file_dir . $new_file_name;

            if (move_uploaded_file($file_tmp_path, $dest_path)) {
                $profile_image = $dest_path;
            } else {
                echo "Error al mover la imagen al directorio de destino.";
            }
        } else {
            echo "Extensión de archivo no permitida.";
        }
    }

    $sql = "INSERT INTO Usuarios (nombre, email, password, profile_image) VALUES ('$nombre', '$email', '$password', '$profile_image')";
    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registro</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #e9ebee;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 90%;
            margin: 20px;
        }

        header h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #555;
            letter-spacing: 1px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
            color: #777;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"],
        input[type="submit"] {
            padding: 12px 20px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        input[type="file"] {
            padding: 3px;
        }

        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        a {
            display: inline-block;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #aaa;
        }
    </style>
    <div class="container">
        <header>
            <h2>Registro de Nuevo Usuario</h2>
        </header>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required><br>

            <label for="profile_image">Imagen de Perfil:</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*"><br>

            <input type="submit" value="Registrar">
        </form>
        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
</body>

</html>