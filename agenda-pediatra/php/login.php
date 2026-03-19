<?php
session_start();
require_once 'conexion.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$query = "SELECT * FROM doctores WHERE usuario = '$usuario'";
$resultado = mysqli_query($conn, $query);

if (mysqli_num_rows($resultado) == 0) {
    echo json_encode(array('success' => false, 'mensaje' => 'Usuario no encontrado'));
    mysqli_close($conn);
    exit;
}

$doctor = mysqli_fetch_assoc($resultado);

if ($doctor['password'] != $password) {
    echo json_encode(array('success' => false, 'mensaje' => 'Contraseña incorrecta'));
    mysqli_close($conn);
    exit;
}

if ($doctor['aprobado'] == 0) {
    echo json_encode(array('success' => false, 'mensaje' => 'Cuenta pendiente de aprobación'));
    mysqli_close($conn);
    exit;
}

$_SESSION['doctor_id'] = $doctor['id'];
$_SESSION['doctor_nombre'] = $doctor['nombre'];

echo json_encode(array('success' => true, 'mensaje' => 'Login exitoso'));

mysqli_close($conn);
?>