<?php


require_once 'conexion.php';
session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$resultado = $conexion->query("SELECT * FROM doctores WHERE email = '$email'");

if ($resultado->num_rows == 1) {
    $doctor = $resultado->fetch_assoc();
    
    // Verificar contraseña
    if (password_verify($password, $doctor['password_hash'])) {
        // Guardar sesión
        $_SESSION['doctor_id'] = $doctor['id'];
        $_SESSION['nombre'] = $doctor['nombre_completo'];
        
        // Redirigir al dashboard de doctor
        header('Location: ../public/doctor/dashboard.php');
        exit;
    } else {
        echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Doctor no encontrado'); window.history.back();</script>";
}

$conexion->close();
?>