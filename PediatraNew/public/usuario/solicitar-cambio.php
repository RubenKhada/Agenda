<?php
session_start();
require_once '../../api/conexion.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}

$citaId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$mensajeExito = false;

// Obtener datos de la cita
$cita = $conexion->query("SELECT * FROM citas WHERE id = $citaId")->fetch_assoc();

if (!$cita) {
    echo "<script>alert('Cita no encontrada'); window.location.href='mis-citas.php';</script>";
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nuevaFecha = $_POST['nueva_fecha'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    
    if (!empty($nuevaFecha) && !empty($motivo)) {
        $resultado = $conexion->query("INSERT INTO cambios_cita (cita_original_id, nueva_fecha_propuesta, motivo_cambio) 
                    VALUES ($citaId, '$nuevaFecha', '$motivo')");
        
        if ($resultado) {
            $mensajeExito = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Cambio - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f7fa; min-height: 100vh; }
        .page-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px 40px; display: flex; justify-content: space-between; align-items: center; }
        .page-header h1 { color: white; font-size: 1.8rem; font-weight: 700; }
        .btn-volver { background: rgba(255,255,255,0.2); color: white; padding: 10px 25px; border: none; border-radius: 25px; text-decoration: none; font-weight: 600; }
        .content { padding: 40px; max-width: 800px; margin: 0 auto; }
        .form-card { background: white; border-radius: 15px; padding: 40px; box-shadow: 0 5px 25px rgba(0,0,0,0.08); }
        .cita-info { background: #e8ebff; border-left: 4px solid #667eea; padding: 20px; border-radius: 8px; margin-bottom: 25px; }
        .cita-info p { margin: 8px 0; color: #555; }
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; color: #333; margin-bottom: 10px; font-size: 1rem; }
        .form-group input, .form-group textarea { width: 100%; padding: 15px 18px; border: 2px solid #ddd; border-radius: 12px; font-size: 1rem; font-family: inherit; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #667eea; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .btn-solicitar { width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 700; cursor: pointer; }
        .btn-solicitar:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Solicitar Cambio de Cita</h1>
        <a href="mis-citas.php" class="btn-volver">Volver</a>
    </div>
    
    <div class="content">
        <div class="form-card">
            <div class="cita-info">
                <h4 style="color:#667eea;margin-bottom:15px;">Cita Actual</h4>
                <p><strong>Fecha:</strong> <?php echo date('d/m/Y g:i A', strtotime($cita['fecha_hora'])); ?></p>
                <p><strong>Motivo:</strong> <?php echo htmlspecialchars($cita['motivo_consulta']); ?></p>
                <p><strong>Estado:</strong> <?php echo $cita['estado']; ?></p>
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label for="nueva_fecha">Nueva Fecha Propuesta</label>
                    <input type="datetime-local" id="nueva_fecha" name="nueva_fecha" required>
                </div>

                <div class="form-group">
                    <label for="motivo">Motivo del Cambio</label>
                    <textarea id="motivo" name="motivo" rows="4" required placeholder="Explica por qué necesitas cambiar la cita..."></textarea>
                </div>

                <button type="submit" class="btn-solicitar">Enviar Solicitud</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mostrar alerta si la solicitud se envió exitosamente
        <?php if ($mensajeExito): ?>
        Swal.fire({
            icon: 'success',
            title: 'Solicitud Enviada',
            text: 'El doctor revisará tu solicitud de cambio',
            confirmButtonColor: '#667eea',
            confirmButtonText: 'Ver Mis Citas'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'mis-citas.php';
            }
        });
        <?php endif; ?>
    </script>
</body>
</html>