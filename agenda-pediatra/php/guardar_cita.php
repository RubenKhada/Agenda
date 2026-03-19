<?php
require_once 'conexion.php';

$nombre = $_POST['paciente_nombre'];
$telefono = $_POST['paciente_telefono'];
$email = $_POST['paciente_email'];
$fecha = $_POST['cita_fecha'];
$hora = $_POST['cita_hora'];
$motivo = $_POST['cita_motivo'];

mysqli_query($conn, "INSERT INTO pacientes (nombre, telefono, email) VALUES ('$nombre', '$telefono', '$email')");
$paciente_id = mysqli_insert_id($conn);

mysqli_query($conn, "INSERT INTO citas (paciente_id, doctor_id, fecha, hora, motivo) VALUES ($paciente_id, 0, '$fecha', '$hora', '$motivo')");

echo json_encode(array('success' => true, 'mensaje' => 'Cita agendada correctamente'));

mysqli_close($conn);
?>