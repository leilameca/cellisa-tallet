<?php
$host = "localhost";
$user = "cellissa_user";
$pass = "1234";
$db = "taller_electronicos";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>