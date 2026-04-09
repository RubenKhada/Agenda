<?php
// public/test-registro.php

// Mostrar todos los errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Prueba de Registro</h2>";

// Probar inclusión de conexión
echo "<h3>1. Probando conexión...</h3>";
require_once '../api/conexion.php';
echo "✅ Conexión OK<br>";

// Probar tabla usuarios
echo "<h3>2. Probando tabla usuarios...</h3>";
$resultado = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    echo "✅ Tabla usuarios OK - Registros: " . $fila['total'] . "<br>";
} else {
    echo "❌ Error: " . $conexion->error . "<br>";
}

// Probar tabla pacientes
echo "<h3>3. Probando tabla pacientes...</h3>";
$resultado = $conexion->query("SELECT COUNT(*) as total FROM pacientes");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    echo "✅ Tabla pacientes OK - Registros: " . $fila['total'] . "<br>";
} else {
    echo "❌ Error: " . $conexion->error . "<br>";
}

// Probar inserción
echo "<h3>4. Probando inserción...</h3>";
$testEmail = 'test' . time() . '@test.com';
$passwordHash = password_hash('test123', PASSWORD_DEFAULT);

$insertar = $conexion->query("INSERT INTO usuarios (nombre_completo, email, telefono, password_hash) 
                              VALUES ('Test Usuario', '$testEmail', '5512345678', '$passwordHash')");

if ($insertar) {
    echo "✅ Inserción OK - ID: " . $conexion->insert_id . "<br>";
    
    $usuarioId = $conexion->insert_id;
    $insertarPaciente = $conexion->query("INSERT INTO pacientes (usuario_id, nombre, fecha_nacimiento, genero) 
                                          VALUES ($usuarioId, 'Test Paciente', '2020-01-01', 'Masculino')");
    if ($insertarPaciente) {
        echo "✅ Paciente insertado OK<br>";
    } else {
        echo "❌ Error paciente: " . $conexion->error . "<br>";
    }
} else {
    echo "❌ Error inserción: " . $conexion->error . "<br>";
}

$conexion->close();

echo "<hr>";
echo "<h3>✅ Todas las pruebas completadas</h3>";
echo "<p><a href='registro-usuario.html'>Volver al registro</a></p>";
?>