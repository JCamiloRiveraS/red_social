<!-- Obtener datos del contador de los me gusta  -->
<?php
include 'includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$post_id = $data['post_id'];
$likes_count = $data['likes_count'];
$has_liked = $data['has_liked'] ? 1 : 0;
$sql_update_likes = "UPDATE Publicaciones SET me_gusta = '$likes_count', liked_by = '$has_liked' WHERE id = '$post_id'";
if ($conn->query($sql_update_likes) === TRUE) {
    echo "Contador de 'Me gusta' actualizado correctamente.";
} else {
    echo "Error al actualizar el contador de 'Me gusta': " . $conn->error;
}
?>