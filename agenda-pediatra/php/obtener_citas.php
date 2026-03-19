<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    echo json_encode(array('citas' => array(), 'mensaje' => 'No hay sesión'));
    exit;
}

$query = mysqli_query($conn, "SELECT c.*, p.nombre as paciente_nombre, p.telefono as paciente_telefono 
                               FROM citas c 
                               LEFT JOIN pacientes p ON c.paciente_id = p.id 
                               ORDER BY c.fecha, c.hora");

$citas = array();
while ($row = mysqli_fetch_assoc($query)) {
    $citas[] = $row;
}

echo json_encode(array('citas' => $citas, 'mensaje' => 'OK'));

mysqli_close($conn);
?>