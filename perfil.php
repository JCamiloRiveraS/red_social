<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['new_profile_image'])) {
    $file_tmp_path = $_FILES['new_profile_image']['tmp_name'];
    $file_name = $_FILES['new_profile_image']['name'];
    $file_size = $_FILES['new_profile_image']['size'];
    $file_type = $_FILES['new_profile_image']['type'];
    $file_name_parts = explode(".", $file_name);
    $file_extension = strtolower(end($file_name_parts));

    $allowed_file_extensions = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($file_extension, $allowed_file_extensions)) {
        $new_file_name = md5(time() . $file_name) . '.' . $file_extension;
        $upload_file_dir = 'uploads/';
        $dest_path = $upload_file_dir . $new_file_name;

        if (move_uploaded_file($file_tmp_path, $dest_path)) {
            $profile_image = $dest_path;
            $sql_update_image = "UPDATE Usuarios SET profile_image='$profile_image' WHERE id='$user_id'";
            if ($conn->query($sql_update_image) === TRUE) {
                $_SESSION['profile_image'] = $profile_image;
                header("Location: perfil.php");
                exit();
            } else {
                echo "Error al actualizar la imagen de perfil.";
            }
        } else {
            echo "Error al mover la imagen al directorio de destino.";
        }
    } else {
        echo "Extensión de archivo no permitida.";
    }
}

$sql = "SELECT * FROM Usuarios WHERE id='$user_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No se encontró el usuario.";
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
    <style>
        .profile-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin: 20px auto;
            max-width: 500px;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }

        .profile-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .profile-card p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #555;
        }

        form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #777;
        }

        form input[type="file"] {
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
        }

        form input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
        }

        form input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
    <div class="container">
        <header>
            <h2>Perfil de <?php echo $user['nombre']; ?></h2>
        </header>
        <div class="profile-card">
            <img src="<?php echo $user['profile_image']; ?>" alt="Foto de perfil" class="profile-image">
            <h3><?php echo $user['nombre']; ?></h3>
            <p>Email: <?php echo $user['email']; ?></p>
            <p>Fecha de Registro: <?php echo $user['fecha_registro']; ?></p>
            <form action="perfil.php" method="post" enctype="multipart/form-data">
                <label for="new_profile_image">Cambiar imagen de perfil:</label>
                <input type="file" id="new_profile_image" name="new_profile_image" accept="image/*">
                <input type="submit" value="Actualizar Imagen">
            </form>
        </div>
        <a href="dashboard.php">Volver al Dashboard</a>
    </div>
</body>

</html>