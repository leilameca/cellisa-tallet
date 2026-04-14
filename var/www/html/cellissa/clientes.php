<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $correo = $_POST["correo"];
    $direccion = $_POST["direccion"];

    $sql = "INSERT INTO clientes (nombre, telefono, correo, direccion)
            VALUES ('$nombre', '$telefono', '$correo', '$direccion')";
    $conn->query($sql);
}

$resultado = $conn->query("SELECT * FROM clientes");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Clientes</title>
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
    <h1>Módulo de Clientes</h1>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="telefono" placeholder="Teléfono">
        <input type="email" name="correo" placeholder="Correo">
        <input type="text" name="direccion" placeholder="Dirección">
        <button type="submit">Guardar cliente</button>
    </form>

    <h2>Listado de clientes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Dirección</th>
            <th>Acciones</th>
        </tr>

        <?php while($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['id_cliente']; ?></td>
            <td><?php echo $fila['nombre']; ?></td>
            <td><?php echo $fila['telefono']; ?></td>
            <td><?php echo $fila['correo']; ?></td>
            <td><?php echo $fila['direccion']; ?></td>
            <td class="actions">
                <a class="btn-edit" href="editar_cliente.php?id=<?php echo $fila['id_cliente']; ?>">Editar</a>
                <a class="btn-danger" href="eliminar_cliente.php?id=<?php echo $fila['id_cliente']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>