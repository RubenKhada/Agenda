<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: ../login-doctor.html');
    exit;
}

$mensajeExito = false;
$mensajeTipo = '';

// Procesar aprobación/rechazo
if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $accion = $_GET['accion'];
    
    $cambio = $conexion->query("SELECT * FROM cambios_cita WHERE id = $id")->fetch_assoc();
    
    if ($cambio) {
        if ($accion == 'aprobar') {
            // Actualizar fecha de la cita
            $conexion->query("UPDATE citas SET fecha_hora = '$cambio[nueva_fecha_propuesta]' WHERE id = $cambio[cita_original_id]");
            // Marcar cambio como aprobado
            $conexion->query("UPDATE cambios_cita SET estado = 'aprobado' WHERE id = $id");
            $mensajeExito = true;
            $mensajeTipo = 'success';
        } elseif ($accion == 'rechazar') {
            // Marcar cambio como rechazado
            $conexion->query("UPDATE cambios_cita SET estado = 'rechazado' WHERE id = $id");
            $mensajeExito = true;
            $mensajeTipo = 'info';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobar Cambios - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; min-height: 100vh; }
        .page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px 40px; display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { color: white; font-size: 1.8rem; font-weight: 700; }
        .btn-volver { background: rgba(255,255,255,0.2); color: white; padding: 10px 25px; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; }
        .content { padding: 40px; max-width: 1200px; margin: 0 auto; }
        .table-container { background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 25px rgba(0,0,0,0.08); }
        .table-container table { width: 100%; border-collapse: collapse; }
        .table-container th { background: #667eea; color: white; padding: 18px 15px; text-align: left; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .table-container td { padding: 16px 15px; border-bottom: 1px solid #eee; font-size: 0.95rem; color: #333; }
        .table-container tr:hover { background: #f8f9ff; }
        .table-container tr:last-child td { border-bottom: none; }
        .btn-accion { padding: 8px 18px; border: none; border-radius: 8px; text-decoration: none; font-size: 0.85rem; font-weight: 600; margin: 3px; display: inline-block; transition: all 0.3s; }
        .btn-aprobar { background: #10b981; color: white; }
        .btn-aprobar:hover { background: #059669; transform: translateY(-2px); }
        .btn-rechazar { background: #ef4444; color: white; }
        .btn-rechazar:hover { background: #dc2626; transform: translateY(-2px); }
        .sin-cambios { text-align: center; padding: 60px 20px; color: #888; }
        .info-box { background: #e8ebff; border-left: 4px solid #667eea; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; }
        .info-box p { color: #555; margin: 0; font-size: 0.95rem; }
        .badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-aprobado { background: #d1fae5; color: #065f46; }
        .badge-rechazado { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Aprobar Cambios</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Panel</a>
    </div>
    
    <div class="content">
        <div class="info-box">
            <p>📅 <strong>Información:</strong> Aquí aparecen las solicitudes de reagendamiento de citas pendientes de aprobación.</p>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Cita Original</th>
                        <th>Nueva Fecha</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $cambios = $conexion->query("SELECT c.*, p.nombre as paciente, ci.fecha_hora as fecha_original 
                                                FROM cambios_cita c 
                                                JOIN citas ci ON c.cita_original_id = ci.id 
                                                JOIN pacientes p ON ci.paciente_id = p.id 
                                                ORDER BY c.estado ASC, c.fecha_solicitud DESC");
                    
                    if ($cambios->num_rows > 0) {
                        while ($cambio = $cambios->fetch_assoc()) {
                            $fechaOriginal = date('d/m/Y g:i A', strtotime($cambio['fecha_original']));
                            $nuevaFecha = date('d/m/Y g:i A', strtotime($cambio['nueva_fecha_propuesta']));
                            
                            echo "<tr>";
                            echo "<td><strong>" . htmlspecialchars($cambio['paciente']) . "</strong></td>";
                            echo "<td>$fechaOriginal</td>";
                            echo "<td>$nuevaFecha</td>";
                            echo "<td>" . htmlspecialchars($cambio['motivo_cambio']) . "</td>";
                            echo "<td><span class='badge badge-" . $cambio['estado'] . "'>" . $cambio['estado'] . "</span></td>";
                            echo "<td>";
                            
                            // Solo mostrar botones si está pendiente
                            if ($cambio['estado'] == 'pendiente') {
                                echo "<a href='?accion=aprobar&id=" . $cambio['id'] . "' class='btn-accion btn-aprobar' onclick='return confirm(\"¿Estás seguro de aprobar este cambio?\")'>✓ Aprobar</a>";
                                echo "<a href='?accion=rechazar&id=" . $cambio['id'] . "' class='btn-accion btn-rechazar' onclick='return confirm(\"¿Estás seguro de rechazar este cambio?\")'>✕ Rechazar</a>";
                            } else {
                                echo "<span style='color:#888;'>Sin acciones</span>";
                            }
                            
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='sin-cambios'>No hay solicitudes de cambio pendientes</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        // Mostrar mensaje de éxito si se procesó una solicitud
        <?php if ($mensajeExito): ?>
        Swal.fire({
            icon: '<?php echo $mensajeTipo; ?>',
            title: '<?php echo $mensajeTipo == "success" ? "¡Cambio Aprobado!" : "Cambio Rechazado"; ?>',
            text: 'La solicitud ha sido procesada correctamente',
            confirmButtonColor: '#667eea',
            confirmButtonText: 'Continuar'
        }).then(() => {
            // Limpiar URL para no mostrar el mensaje de nuevo
            window.history.replaceState({}, document.title, window.location.pathname);
        });
        <?php endif; ?>
    </script>
</body>
</html>