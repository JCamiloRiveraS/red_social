<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM Usuarios WHERE id != '$user_id'"; // buscar entre todos los usuarios excepto el usuario actual
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Buscar Amigos</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
    <div class="dashboard">
        <div class="sidebar-left">
            <h2>Opciones</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="publicaciones.php">Publicaciones</a></li>
                <li><a href="amigos.php">Amigos</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>

        <div class="central-area">
            <h2>Buscar Amigos</h2>
            <ul>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>";
                        echo "<strong>Nombre:</strong> " . $row['nombre'] . "<br>";
                        echo "<strong>Email:</strong> " . $row['email'] . "<br>";
                        echo "<a href='agregar_amigo.php?amigo_id={$row['id']}'>Agregar Amigo</a>";
                        echo "</li>";
                    }
                } else {
                    echo "No se encontraron usuarios.";
                }
                ?>
            </ul>
        </div>

        <div class="sidebar-right">
            <h2>Chat de Amigos</h2>

        </div>
    </div>
</body>

</html>