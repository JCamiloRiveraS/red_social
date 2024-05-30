<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contenido = $_POST['contenido'];
    $usuario_id = $_SESSION['user_id'];

    $sql = "INSERT INTO Publicaciones (usuario_id, contenido) VALUES ('$usuario_id', '$contenido')";

    if ($conn->query($sql) === TRUE) {
        echo "Publicación exitosa";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Publicaciones</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
    <div class="container">
        <form method="post">
            <h2>Crear Publicación</h2>
            <textarea style="width: 80%; margin-top:20px; margin-bottom: 20px;" name="contenido" placeholder="¿Qué estás pensando?" required></textarea><br>
            <input type="submit" value="Publicar">
        </form>

        <h2 style="text-align:center; margin-bottom:20px; font-size: 40px;">Publicaciones Recientes</h2>
        <?php
        $sql = "SELECT p.contenido, u.nombre, p.fecha_publicacion FROM Publicaciones p JOIN Usuarios u ON p.usuario_id = u.id ORDER BY p.fecha_publicacion DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3>" . $row['nombre'] . "</h3>";
                echo "<p style='width:750px;'>" . $row['contenido'] . "</p>";
                echo "<time>" . $row['fecha_publicacion'] . "</time>";
                echo "</div>";
            }
        } else {
            echo "No hay publicaciones";
        }
        ?>
        <a style="position: absolute; top:0; left:0; margin:5px;" href="dashboard.php">Volver al Dashboard</a>
    </div>
</body>

</html>