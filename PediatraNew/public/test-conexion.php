<?php
// public/test-conexion.php
require_once '../api/conexion.php';

echo "<h1>✅ ¡Conexión exitosa!</h1>";
echo "<p>📊 Base de datos: <strong>" . $base_datos . "</strong></p>";
echo "<p>🖥️ Servidor: <strong>" . $conexion->host_info . "</strong></p>";
echo "<p>🔗 Estado: <strong>Conectado</strong></p>";

// Probar consulta simple
$resultado = $conexion->query("SELECT COUNT(*) as total FROM usuarios");
if ($resultado) {
    $fila = $resultado->fetch_assoc();
    echo "<p>👥 Usuarios registrados: <strong>" . $fila['total'] . "</strong></p>";
}

$conexion->close();
?>