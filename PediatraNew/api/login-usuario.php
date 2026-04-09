<?php

require_once __DIR__ . '/conexion.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo "<script>alert('Faltan datos'); window.history.back();</script>";
    exit;
}

$resultado = $conexion->query("SELECT * FROM usuarios WHERE email = '$email'");

if ($resultado && $resultado->num_rows == 1) {
    $usuario = $resultado->fetch_assoc();
    
    if (password_verify($password, $usuario['password_hash'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre_completo'];
        $_SESSION['tipo'] = 'usuario';
        
        // ✅ Redirección correcta
        header('Location: ../public/usuario/dashboard.php');
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
}

$conexion->close();
?>