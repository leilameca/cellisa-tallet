<?php
session_start();
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username='$user' AND password='$pass'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $_SESSION['usuario'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Cellissa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-box">
    <h1>Iniciar Sesión</h1>

    <?php if ($mensaje != ""): ?>
        <p class="message-error"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>

    <small>Usuario de prueba: admin | Contraseña: 1234</small>
</div>

</body>
</html>