<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// iniciador de la busqueda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $buscar = $_POST['buscar'];

    // Buscar usuarios segun la busqueda hecha
    $sql_buscar = "SELECT * FROM Usuarios WHERE id != '$user_id' AND (nombre LIKE '%$buscar%' OR email LIKE '%$buscar%')";
    $result_buscar = $conn->query($sql_buscar);
}

//  listar de amigos del usuario
$sql_amigos = "SELECT amigo_id FROM Amigos WHERE usuario_id = '$user_id' AND estado = 'aceptado'";
$result_amigos = $conn->query($sql_amigos);
$amigos = array();
while ($row = $result_amigos->fetch_assoc()) {
    $amigos[] = $row['amigo_id'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Amigos</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body>
    <div class="dashboard">
        <div class="sidebar-left">
            <h2>Opciones</h2>
            <ul>
                <li><a href="perfil.php">Ver Perfil</a></li>
                <li><a href="publicaciones.php">Publicaciones</a></li>
                <li><a href="amigos.php">Amigos</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>

        <div class="central-area">
            <h2>Busca y Agrega a tus Amigos</h2>
            <form method="post">      <!-- formulario de la búsquedan de amigos -->
                <input type="text" name="buscar" placeholder="Buscar amigos por nombre o email">
                <input type="submit" value="Buscar">
            </form>
            <?php if (isset($result_buscar) && $result_buscar->num_rows > 0) : ?>
                <h3>Resultados de la búsqueda:</h3>
                <ul>
                    <?php while ($row = $result_buscar->fetch_assoc()) : ?>
                        <?php if (!in_array($row['id'], $amigos)) : ?>
                            <li><?php echo $row['nombre']; ?> - <?php echo $row['email']; ?> <a href="agregar_amigo.php?amigo_id=<?php echo $row['id']; ?>">Agregar Amigo</a></li>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
            <h3>Tus Amigos:</h3>
            <ul>
                <?php
                $sql_tus_amigos = "SELECT u.nombre, u.email FROM Usuarios u JOIN Amigos a ON u.id = a.amigo_id WHERE a.usuario_id = '$user_id' AND a.estado = 'aceptado'";
                $result_tus_amigos = $conn->query($sql_tus_amigos);
                if ($result_tus_amigos->num_rows > 0) {
                    while ($row = $result_tus_amigos->fetch_assoc()) {
                        echo "<li>{$row['nombre']} - {$row['email']}</li>";
                    }
                } else {
                    echo "<li>No tienes amigos.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>