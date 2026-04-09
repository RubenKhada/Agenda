<?php
session_start();
$host = 'localhost';
$usuario = 'root';
$password = '';             
$base_datos = 'consultorio_pediatrico';
$conexion = new mysqli($host, $usuario, $password, $base_datos);
if ($conexion->connect_error) {
    die("error de conexión: " . $conexion->connect_error);
}
$conexion->set_charset("utf8mb4");


?>