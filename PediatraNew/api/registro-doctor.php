<?php
require_once 'conexion.php';

$MASTER_KEY = 'MEDICO2026';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Verificar contraseña maestra
    if ($_POST['master_key'] !== $MASTER_KEY) {
        echo json_encode(['success' => false, 'message' => 'Código inválido']);
        exit;
    }
    
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $cedula = $_POST['cedula'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $conexion->query("INSERT INTO doctores (nombre_completo, email, cedula_profesional, password_hash) 
                VALUES ('$nombre', '$email', '$cedula', '$password')");
    
    echo json_encode(['success' => true]);
    $conexion->close();
}
?>