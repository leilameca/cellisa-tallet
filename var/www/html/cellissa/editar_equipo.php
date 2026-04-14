<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST["id_cliente"];
    $tipo_equipo = $_POST["tipo_equipo"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $num_serie = $_POST["num_serie"];
    $descrip_falla = $_POST["descrip_falla"];

    $sql = "UPDATE equipos 
            SET id_cliente='$id_cliente', tipo_equipo='$tipo_equipo', marca='$marca', modelo='$modelo',
                num_serie='$num_serie', descrip_falla='$descrip_falla'
            WHERE id_equipo=$id";
    $conn->query($sql);
    header("Location: equipos.php");
    exit();
}

$equipo = $conn->query("SELECT * FROM equipos WHERE id_equipo=$id")->fetch_assoc();
$clientes = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Equipo</title>
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
    <h1>Editar Equipo</h1>

    <form method="POST">
        <select name="id_cliente" required>
            <?php while($cliente = $clientes->fetch_assoc()): ?>
                <option value="<?php echo $cliente['id_cliente']; ?>" <?php if($cliente['id_cliente'] == $equipo['id_cliente']) echo 'selected'; ?>>
                    <?php echo $cliente['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="text" name="tipo_equipo" value="<?php echo $equipo['tipo_equipo']; ?>" required>
        <input type="text" name="marca" value="<?php echo $equipo['marca']; ?>">
        <input type="text" name="modelo" value="<?php echo $equipo['modelo']; ?>">
        <input type="text" name="num_serie" value="<?php echo $equipo['num_serie']; ?>">
        <input type="text" name="descrip_falla" value="<?php echo $equipo['descrip_falla']; ?>">
        <button type="submit">Actualizar equipo</button>
    </form>
</div>

</body>
</html>