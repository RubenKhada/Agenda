<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    echo json_encode(array('success' => false, 'mensaje' => 'No autorizado'));
    exit;
}

$cita_id = $_POST['cita_id'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$motivo = $_POST['motivo'];

mysqli_query($conn, "UPDATE citas SET fecha = '$fecha', hora = '$hora', motivo = '$motivo' WHERE id = $cita_id");

echo json_encode(array('success' => true, 'mensaje' => 'Cita actualizada'));

mysqli_close($conn);
?>