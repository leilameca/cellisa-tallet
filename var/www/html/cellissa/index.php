<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$c1 = $conn->query("SELECT COUNT(*) as total FROM clientes")->fetch_assoc();
$c2 = $conn->query("SELECT COUNT(*) as total FROM equipos")->fetch_assoc();
$c3 = $conn->query("SELECT COUNT(*) as total FROM reparaciones")->fetch_assoc();
$c4 = $conn->query("SELECT COUNT(*) as total FROM pagos")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema Cellissa Comunicaciones</title>
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
    <h1>Sistema de Gestión - Cellissa Comunicaciones</h1>
    <p>Bienvenido, <strong><?php echo $_SESSION['usuario']; ?></strong>. Este dashboard muestra un resumen general del sistema.</p>

    <div class="dashboard">
        <div class="card">
            <h3>Clientes</h3>
            <p><?php echo $c1['total']; ?></p>
        </div>
        <div class="card">
            <h3>Equipos</h3>
            <p><?php echo $c2['total']; ?></p>
        </div>
        <div class="card">
            <h3>Reparaciones</h3>
            <p><?php echo $c3['total']; ?></p>
        </div>
        <div class="card">
            <h3>Pagos</h3>
            <p><?php echo $c4['total']; ?></p>
        </div>
    </div>

    <h2>Módulos disponibles</h2>
    <ul>
        <li>Gestión de Clientes</li>
        <li>Gestión de Equipos</li>
        <li>Gestión de Reparaciones</li>
        <li>Gestión de Pagos</li>
    </ul>

    <p>Este sistema fue desarrollado como parte de la actividad final de la asignatura Desarrollo de Proyectos con Software Libre, integrando aplicación web, base de datos y servidor Linux.</p>
</div>

</body>
</html>