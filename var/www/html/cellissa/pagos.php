<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_reparacion = $_POST["id_reparacion"];
    $fecha_pago = $_POST["fecha_pago"];
    $monto = $_POST["monto"];
    $metodo_pago = $_POST["metodo_pago"];

    $sql = "INSERT INTO pagos (id_reparacion, fecha_pago, monto, metodo_pago)
            VALUES ('$id_reparacion', '$fecha_pago', '$monto', '$metodo_pago')";
    $conn->query($sql);

    header("Location: pagos.php");
    exit();
}

$reparaciones = $conn->query("
    SELECT r.id_reparacion, e.tipo_equipo, r.estado
    FROM reparaciones r
    INNER JOIN equipos e ON r.id_equipo = e.id_equipo
    ORDER BY r.id_reparacion DESC
");

$pagos = $conn->query("
    SELECT p.*, r.estado, e.tipo_equipo
    FROM pagos p
    INNER JOIN reparaciones r ON p.id_reparacion = r.id_reparacion
    INNER JOIN equipos e ON r.id_equipo = e.id_equipo
    ORDER BY p.id_pago DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Pagos</title>
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
    <h1>Módulo de Pagos</h1>

    <form method="POST">
        <select name="id_reparacion" required>
            <option value="">Seleccione una reparación</option>
            <?php while($rep = $reparaciones->fetch_assoc()): ?>
                <option value="<?php echo $rep['id_reparacion']; ?>">
                    Reparación #<?php echo $rep['id_reparacion']; ?> - <?php echo $rep['tipo_equipo']; ?> - <?php echo $rep['estado']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="date" name="fecha_pago" required>
        <input type="number" step="0.01" name="monto" placeholder="Monto" required>
        <input type="text" name="metodo_pago" placeholder="Método de pago" required>
        <button type="submit">Registrar pago</button>
    </form>

    <h2>Listado de pagos</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Reparación</th>
            <th>Equipo</th>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Método</th>
        </tr>

        <?php while($fila = $pagos->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['id_pago']; ?></td>
            <td><?php echo $fila['id_reparacion']; ?></td>
            <td><?php echo $fila['tipo_equipo']; ?></td>
            <td><?php echo $fila['fecha_pago']; ?></td>
            <td><?php echo $fila['monto']; ?></td>
            <td><?php echo $fila['metodo_pago']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>