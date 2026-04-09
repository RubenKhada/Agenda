<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

// Verificar sesión
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}

$mensajeExito = false;

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuarioId = $_SESSION['usuario_id'];
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $motivo = $_POST['motivo'] ?? '';
    
    $paciente = $conexion->query("SELECT id FROM pacientes WHERE usuario_id = $usuarioId")->fetch_assoc();
    
    if ($paciente && !empty($fecha) && !empty($hora)) {
        $fechaHora = $fecha . ' ' . $hora . ':00';
        $resultado = $conexion->query("INSERT INTO citas (paciente_id, fecha_hora, motivo_consulta, estado) 
                        VALUES ($paciente[id], '$fechaHora', '$motivo', 'pendiente')");
        
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
    <title>Agendar Cita - Pediatría Integral Satélite</title>
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
        .form-group { margin-bottom: 25px; }
        .form-group label { display: block; font-weight: 600; color: #333; margin-bottom: 10px; font-size: 1rem; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 15px 18px; border: 2px solid #ddd; border-radius: 12px; font-size: 1rem; font-family: inherit; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #667eea; }
        .form-group textarea { resize: vertical; min-height: 120px; }
        .btn-agendar { width: 100%; padding: 16px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 12px; font-size: 1.1rem; font-weight: 700; cursor: pointer; }
        .btn-agendar:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4); }
        .info-box { background: #e8ebff; border-left: 4px solid #667eea; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; }
        .info-box p { color: #555; margin: 0; font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Agendar Cita</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Menú</a>
    </div>
    
    <div class="content">
        <div class="info-box">
            <p>📅 <strong>Nota:</strong> Las citas están disponibles de Lunes a Viernes de 9:00 AM a 6:00 PM</p>
        </div>
        
        <div class="form-card">
            <form method="POST">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="form-group">
                    <label for="hora">Hora</label>
                    <select id="hora" name="hora" required>
                        <option value="">Seleccionar...</option>
                        <option value="09:00">9:00 AM</option>
                        <option value="10:00">10:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="12:00">12:00 PM</option>
                        <option value="16:00">4:00 PM</option>
                        <option value="17:00">5:00 PM</option>
                        <option value="18:00">6:00 PM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="motivo">Motivo de la consulta</label>
                    <textarea id="motivo" name="motivo" rows="4" required placeholder="Describe brevemente el motivo de la consulta..."></textarea>
                </div>

                <button type="submit" class="btn-agendar">Agendar Cita</button>
            </form>
        </div>
    </div>
    
    <script>
        // Establecer fecha mínima como hoy
        const hoy = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').setAttribute('min', hoy);
        
        // Mostrar alerta si la cita se agendó exitosamente
        <?php if ($mensajeExito): ?>
        Swal.fire({
            icon: 'success',
            title: '¡Cita Agendada!',
            text: 'Tu cita ha sido programada exitosamente',
            confirmButtonColor: '#667eea',
            confirmButtonText: 'Ver Mis Citas'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'mis-citas.php';
            }
        });
        <?php endif; ?>
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>