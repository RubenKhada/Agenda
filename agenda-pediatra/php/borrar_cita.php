<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    echo json_encode(array('success' => false, 'mensaje' => 'No autorizado'));
    exit;
}

$cita_id = $_POST['cita_id'];

mysqli_query($conn, "DELETE FROM citas WHERE id = $cita_id");

echo json_encode(array('success' => true, 'mensaje' => 'Cita eliminada'));

mysqli_close($conn);
?>