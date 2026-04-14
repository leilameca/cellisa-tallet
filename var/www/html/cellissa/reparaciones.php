<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_equipo = $_POST["id_equipo"];
    $id_tecnico = !empty($_POST["id_tecnico"]) ? $_POST["id_tecnico"] : "NULL";
    $estado = $_POST["estado"];
    $costo_estimado = $_POST["costo_estimado"];

    $sql = "INSERT INTO reparaciones (id_equipo, id_tecnico, fecha_ingreso, estado, costo_estimado)
            VALUES ('$id_equipo', " . ($id_tecnico === "NULL" ? "NULL" : "'$id_tecnico'") . ", NOW(), '$estado', '$costo_estimado')";
    $conn->query($sql);

    header("Location: reparaciones.php");
    exit();
}

$equipos = $conn->query("SELECT * FROM equipos ORDER BY id_equipo DESC");
$tecnicos = $conn->query("SELECT * FROM tecnico ORDER BY nombre ASC");

$reparaciones = $conn->query("
    SELECT r.*, e.tipo_equipo, t.nombre AS tecnico_nombre
    FROM reparaciones r
    JOIN equipos e ON r.id_equipo = e.id_equipo
    LEFT JOIN tecnico t ON r.id_tecnico = t.id_tecnico
    ORDER BY r.id_reparacion DESC
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Reparaciones</title>
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
    <h1>Módulo de Reparaciones</h1>

    <form method="POST">
        <select name="id_equipo" required>
            <option value="">Seleccione equipo</option>
            <?php while($eq = $equipos->fetch_assoc()): ?>
                <option value="<?php echo $eq['id_equipo']; ?>">
                    #<?php echo $eq['id_equipo']; ?> - <?php echo $eq['tipo_equipo']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="id_tecnico">
            <option value="">Seleccione técnico</option>
            <?php while($tec = $tecnicos->fetch_assoc()): ?>
                <option value="<?php echo $tec['id_tecnico']; ?>">
                    <?php echo $tec['nombre']; ?> - <?php echo $tec['especialidad']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="text" name="estado" placeholder="Estado (En proceso, Finalizado)" required>
        <input type="number" step="0.01" name="costo_estimado" placeholder="Costo estimado" required>
        <button type="submit">Registrar reparación</button>
    </form>

    <h2>Listado de reparaciones</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Equipo</th>
            <th>Técnico</th>
            <th>Estado</th>
            <th>Costo</th>
            <th>Fecha ingreso</th>
        </tr>

        <?php while($fila = $reparaciones->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['id_reparacion']; ?></td>
            <td><?php echo $fila['tipo_equipo']; ?></td>
            <td><?php echo $fila['tecnico_nombre'] ? $fila['tecnico_nombre'] : 'No asignado'; ?></td>
            <td><?php echo $fila['estado']; ?></td>
            <td><?php echo $fila['costo_estimado']; ?></td>
            <td><?php echo $fila['fecha_ingreso']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>