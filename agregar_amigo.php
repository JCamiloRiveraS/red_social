<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['amigo_id'])) {
    $user_id = $_SESSION['user_id'];
    $amigo_id = $_GET['amigo_id'];


    $sql_check = "SELECT * FROM Amigos WHERE usuario_id = '$user_id' AND amigo_id = '$amigo_id'";     // Verifica si ya son amigos
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        header("Location: amigos.php?mensaje=Ya eres amigo de este usuario.");
    } else {
        // SOLICITUD DE AMISTAD INCOMPLETO!!!!!!!
        $sql_add = "INSERT INTO Amigos (usuario_id, amigo_id, estado) VALUES ('$user_id', '$amigo_id', 'pendiente')";         // Agregar solicitud de amistad
        
        if ($conn->query($sql_add) === TRUE) {
            header("Location: amigos.php?mensaje=Solicitud de amistad enviada correctamente.");
        } else {
            header("Location: amigos.php?mensaje=Error al enviar la solicitud de amistad: " . $conn->error);
        }
    }
} else {
    echo "Acceso no autorizado.";
}
?>
