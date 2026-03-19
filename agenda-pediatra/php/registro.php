<?php
require_once 'conexion.php';

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$clave_maestra = $_POST['clave_maestra'];

$query = mysqli_query($conn, "SELECT * FROM configuracion WHERE clave_maestra = '$clave_maestra'");
if (mysqli_num_rows($query) == 0) {
    echo json_encode(array('success' => false, 'mensaje' => 'Clave maestra incorrecta'));
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM doctores WHERE usuario = '$usuario'");
if (mysqli_num_rows($query) > 0) {
    echo json_encode(array('success' => false, 'mensaje' => 'El usuario ya existe'));
    exit;
}

mysqli_query($conn, "INSERT INTO doctores (nombre, usuario, password, aprobado) VALUES ('$nombre', '$usuario', '$password', 0)");
echo json_encode(array('success' => true, 'mensaje' => 'Registro exitoso. Espere aprobación.'));

mysqli_close($conn);
?>