<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

$id = $_GET['id'];
$conn->query("DELETE FROM clientes WHERE id_cliente=$id");

header("Location: clientes.php");
exit();
?>