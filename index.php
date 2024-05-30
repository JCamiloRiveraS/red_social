<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Red Social</title>
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

        header h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #555;
            letter-spacing: 1px;
        }

        header p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #777;
        }

        header a {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        header a:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        header a:first-of-type {
            background-color: #28a745;
        }

        header a:first-of-type:hover {
            background-color: #218838;
        }

        footer {
            margin-top: 20px;
            font-size: 14px;
            color: #aaa;
        }
    </style>
    <div class="container">
        <header>
            <h1>Bienvenido a la Red Social FET</h1>
            <p>Conéctate con tus amigos y comparte lo que te rodea en nuestra plataforma.</p>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="perfil.php">Ver Perfil</a>
                <a href="logout.php">Cerrar Sesión</a>
            <?php else : ?>
                <a href="login.php">Iniciar Sesión</a>
                <a href="register.php">Registrate</a>
            <?php endif; ?>
        </header>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Red Social FET. Fundación Escuela Tecnológica de Neiva.</p>
        </footer>
    </div>
</body>

</html>