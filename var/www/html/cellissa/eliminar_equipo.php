<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$id = $_GET['id'];
$conn->query("DELETE FROM equipos WHERE id_equipo=$id");

header("Location: equipos.php");
exit();
?>