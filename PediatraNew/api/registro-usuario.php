<?php

error_reporting(0);
ini_set('display_errors', 0);

// Incluir conexión
require_once __DIR__ . '/conexion.php';

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos
$nombreTutor = $_POST['nombreTutor'] ?? '';
$email = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';
$nombrePaciente = $_POST['nombrePaciente'] ?? '';
$fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
$genero = $_POST['genero'] ?? '';

// Validaciones básicas
if (empty($nombreTutor) || empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos obligatorios']);
    exit;
}

if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
    exit;
}

// Verificar si el email ya existe
$verificar = $conexion->query("SELECT id FROM usuarios WHERE email = '$email'");
if ($verificar && $verificar->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El correo ya está registrado']);
    exit;
}

// Encriptar contraseña
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario
$insertarUsuario = $conexion->query("INSERT INTO usuarios (nombre_completo, email, telefono, password_hash) 
                                    VALUES ('$nombreTutor', '$email', '$telefono', '$passwordHash')");

if ($insertarUsuario) {
    $usuarioId = $conexion->insert_id;
    
    // Insertar paciente
    $insertarPaciente = $conexion->query("INSERT INTO pacientes (usuario_id, nombre, fecha_nacimiento, genero) 
                                        VALUES ($usuarioId, '$nombrePaciente', '$fechaNacimiento', '$genero')");
    
    if ($insertarPaciente) {
        echo json_encode(['success' => true, 'message' => 'Registro exitoso']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar paciente: ' . $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar usuario: ' . $conexion->error]);
}

$conexion->close();
?>