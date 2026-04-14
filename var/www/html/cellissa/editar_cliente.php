<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];

    $sql = "UPDATE clientes 
            SET nombre='$nombre', telefono='$telefono', correo='$correo', direccion='$direccion' 
            WHERE id_cliente=$id";
    $conn->query($sql);
    header("Location: clientes.php");
    exit();
}

$cliente = $conn->query("SELECT * FROM clientes WHERE id_cliente=$id")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="nav">
    <div class="nav-left">
        <a href="index.php">Inicio</a>
        <a href="clientes.php">Clientes</a>
        <a href="equipos.php">Equipos</a>
        <a href="reparaciones.php">Reparaciones</a>
        <a href="pagos.php">Pagos</a>
    </div>
    <div class="nav-right">
        <a href="logout.php">Cerrar sesión</a>
    </div>
</div>

<div class="container">
    <h1>Editar Cliente</h1>

    <form method="POST">
        <input type="text" name="nombre" value="<?php echo $cliente['nombre']; ?>" required>
        <input type="text" name="telefono" value="<?php echo $cliente['telefono']; ?>">
        <input type="email" name="correo" value="<?php echo $cliente['correo']; ?>">
        <input type="text" name="direccion" value="<?php echo $cliente['direccion']; ?>">
        <button type="submit">Actualizar cliente</button>
    </form>
</div>

</body>
</html>