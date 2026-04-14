<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cliente = $_POST["id_cliente"];
    $tipo_equipo = $_POST["tipo_equipo"];
    $marca = $_POST["marca"];
    $modelo = $_POST["modelo"];
    $num_serie = $_POST["num_serie"];
    $descrip_falla = $_POST["descrip_falla"];

    $sql = "INSERT INTO equipos (id_cliente, tipo_equipo, marca, modelo, num_serie, descrip_falla)
            VALUES ('$id_cliente', '$tipo_equipo', '$marca', '$modelo', '$num_serie', '$descrip_falla')";
    $conn->query($sql);
}

$clientes = $conn->query("SELECT * FROM clientes");
$equipos = $conn->query("SELECT e.*, c.nombre AS cliente_nombre 
                         FROM equipos e 
                         INNER JOIN clientes c ON e.id_cliente = c.id_cliente");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Equipos</title>
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
    <h1>Módulo de Equipos</h1>

    <form method="POST">
        <select name="id_cliente" required>
            <option value="">Seleccione un cliente</option>
            <?php while($cliente = $clientes->fetch_assoc()): ?>
                <option value="<?php echo $cliente['id_cliente']; ?>">
                    <?php echo $cliente['nombre']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="text" name="tipo_equipo" placeholder="Tipo de equipo" required>
        <input type="text" name="marca" placeholder="Marca">
        <input type="text" name="modelo" placeholder="Modelo">
        <input type="text" name="num_serie" placeholder="Número de serie">
        <input type="text" name="descrip_falla" placeholder="Descripción de falla">
        <button type="submit">Guardar equipo</button>
    </form>

    <h2>Listado de equipos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Tipo</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Serie</th>
            <th>Falla</th>
            <th>Acciones</th>
        </tr>

        <?php while($fila = $equipos->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['id_equipo']; ?></td>
            <td><?php echo $fila['cliente_nombre']; ?></td>
            <td><?php echo $fila['tipo_equipo']; ?></td>
            <td><?php echo $fila['marca']; ?></td>
            <td><?php echo $fila['modelo']; ?></td>
            <td><?php echo $fila['num_serie']; ?></td>
            <td><?php echo $fila['descrip_falla']; ?></td>
            <td class="actions">
                <a class="btn-edit" href="editar_equipo.php?id=<?php echo $fila['id_equipo']; ?>">Editar</a>
                <a class="btn-danger" href="eliminar_equipo.php?id=<?php echo $fila['id_equipo']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este equipo?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>