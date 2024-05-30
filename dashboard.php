<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$sql_user = "SELECT * FROM Usuarios WHERE id = '$user_id'";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc(); // Obtener información 


$sql_publicaciones = "SELECT p.*, u.profile_image FROM Publicaciones p JOIN Usuarios u ON p.usuario_id = u.id ORDER BY p.fecha_publicacion DESC";
$result_publicaciones = $conn->query($sql_publicaciones); // Obtener publicaciones 


$sql_publicaciones = "SELECT p.*, u.nombre AS nombre_usuario, u.profile_image 
                      FROM Publicaciones p 
                      JOIN Usuarios u ON p.usuario_id = u.id 
                      ORDER BY p.fecha_publicacion DESC";
$result_publicaciones = $conn->query($sql_publicaciones); // nombre del usuario
?>


<!DOCTYPE html>
<html>

<head>
    <title>Dashboard/Red Social FET</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <style>
        .post {
            margin-bottom: 20px;
        }

        .post-content {
            margin-bottom: 10px;
        }

        .like-container {
            display: flex;
            align-items: center;
        }

        .like-icon {
            color: #aaa;
            cursor: pointer;
            margin-right: 5px;

        }

        .liked {
            color: red;
        }

        .loguito {
            height: 30px;
            border: solid 1px #0559F5;
            background-color: #4C87F5;
            border-radius: 15px;
        }

        .loguito span {
            color: white;
            font-weight: 600;
            margin-left: 20%;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="sidebar-left">
            <div class="loguito">
                <span> Red Social FET</span>
            </div>
            <h2 style="margin: 10% 15% 10% 28%; font-weight:800; font-family:Georgia, 'Times New Roman', Times, serif; color:#083995;">MENÚ</h2>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="publicaciones.php">Publicaciones</a></li>
                <li><a href="amigos.php">Amigos</a></li>
                <li><a href="logout.php">Cerrar Sesión</a></li>
            </ul>
        </div>

        <div class="central-area">
            <div class="profile-card">
                <img src="<?php echo $user['profile_image']; ?>" alt="Foto de perfil" width="130">
                <h3><?php echo $user['nombre']; ?></h3>
                <p>Email: <?php echo $user['email']; ?></p>
                <p>Fecha de Registro: <?php echo $user['fecha_registro']; ?></p>
            </div>

            <h2>Publicaciones</h2>
            <?php
            if ($result_publicaciones->num_rows > 0) {
                while ($row = $result_publicaciones->fetch_assoc()) {
                    echo "<div class='post'>";
                    echo "<div class='post-content'>";
                    echo "<p style='font-style: italic; margin-top: 5px;'>Publicó: " . $row['nombre_usuario'] . "</p>";
                    echo "<p style='width:400px; margin-left: 20%; margin-bottom:20px;'>" . $row['contenido'] . "</p>";
                    echo "<time style='font-style: italic;'>" . $row['fecha_publicacion'] . "</time>";
                    echo "</div>";
                    echo "<div class='like-container'>";
                    echo "<img src='" . $row['profile_image'] . "' class='user-avatar' alt='Foto de perfil' style='max-width:70px; border-radius:100%; margin-top:-20%;'>";
                    echo "<i style='margin-left: 20px; width:22px;' class='like-icon" . ($row['liked_by'] ? ' liked' : '') . "' data-post-id='" . $row['id'] . "'>&#x2661;</i>";
                    echo "<span class='likes-count' id='likes-count-" . $row['id'] . "'>" . $row['me_gusta'] . "</span>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "No hay publicaciones.";
            }
            ?>
        </div>

        <div class="sidebar-right">
            <h2>Chat de Amigos</h2>
            <span>No tienes amigos agregados</span>
        </div>
    </div>

    <script>
        document.querySelectorAll('.like-icon').forEach(item => { // Manejar clic en el me gusta
            item.addEventListener('click', event => {
                const postId = item.getAttribute('data-post-id');
                const likesCountElement = document.getElementById('likes-count-' + postId);
                let likesCount = parseInt(likesCountElement.textContent);
                const hasLiked = item.classList.contains('liked');
                if (hasLiked) {
                    likesCount--;
                    item.classList.remove('liked');
                } else {
                    likesCount++;
                    item.classList.add('liked');
                }

                likesCountElement.textContent = likesCount;

                fetch('guardar_likes.php', { // Guardar el estado de like en la base de datos ajax, (falta mas configuraciones)
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            post_id: postId,
                            likes_count: likesCount,
                            has_liked: !hasLiked
                        })
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>