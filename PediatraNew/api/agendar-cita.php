<?php
require_once 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {
    
    $usuarioId = $_SESSION['usuario_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $motivo = $_POST['motivo'];
    
    // Obtener paciente
    $paciente = $conexion->query("SELECT id FROM pacientes WHERE usuario_id = $usuarioId")->fetch_assoc();
    
    // Insertar cita
    $fechaHora = $fecha . ' ' . $hora . ':00';
    $conexion->query("INSERT INTO citas (paciente_id, fecha_hora, motivo_consulta, estado) 
                VALUES ($paciente[id], '$fechaHora', '$motivo', 'pendiente')");
    
    header('Location: ../public/usuario/mis-citas.php');
    $conexion->close();
}
?>