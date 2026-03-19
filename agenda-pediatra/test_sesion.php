<?php
session_start();

echo "<h2>Prueba de Sesión</h2>";

if (isset($_SESSION['doctor_id'])) {
    echo "Sesión activa:<br>";
    echo "Doctor ID: " . $_SESSION['doctor_id'] . "<br>";
    echo "Doctor Nombre: " . $_SESSION['doctor_nombre'];
} else {
    echo "No hay sesión activa";
}

echo "<br><br><a href='index.php'>Volver al inicio</a>";
?>