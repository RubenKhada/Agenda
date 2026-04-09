<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$paciente = $conexion->query("SELECT * FROM pacientes WHERE usuario_id = $usuarioId")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial Médico - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h1 {
            color: white;
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .btn-volver {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
        }
        
        .content {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        
        .info-card h3 {
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e8ebff;
            font-size: 1.3rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #eee;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            color: #666;
            font-weight: 500;
        }
        
        .info-value {
            color: #333;
            font-weight: 600;
            text-align: right;
        }
        
        .cita-item {
            background: #f8f9ff;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 12px;
            border-left: 4px solid #667eea;
        }
        
        .cita-item h4 {
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
        }
        
        .cita-item p {
            color: #666;
            font-size: 0.9rem;
            margin: 5px 0;
        }
        
        .sin-datos {
            text-align: center;
            padding: 40px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Historial Médico</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Menú</a>
    </div>
    
    <div class="content">
        <?php if ($paciente): ?>
        <div class="info-card">
            <h3>Datos del Paciente</h3>
            <div class="info-row">
                <span class="info-label">Nombre:</span>
                <span class="info-value"><?php echo htmlspecialchars($paciente['nombre']); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Nacimiento:</span>
                <span class="info-value"><?php echo date('d/m/Y', strtotime($paciente['fecha_nacimiento'])); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Edad:</span>
                <span class="info-value"><?php echo date_diff(date_create($paciente['fecha_nacimiento']), date_create('today'))->y; ?> años</span>
            </div>
            <div class="info-row">
                <span class="info-label">Género:</span>
                <span class="info-value"><?php echo $paciente['genero'] ?: 'No especificado'; ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Antecedentes:</span>
                <span class="info-value"><?php echo $paciente['antecedentes'] ?: 'Sin antecedentes registrados'; ?></span>
            </div>
        </div>
        
        <div class="info-card">
            <h3>Citas Médicas</h3>
            <?php
            $citas = $conexion->query("SELECT * FROM citas WHERE paciente_id = $paciente[id] ORDER BY fecha_hora DESC");
            
            if ($citas->num_rows > 0) {
                while ($cita = $citas->fetch_assoc()) {
                    $fecha = date('d/m/Y g:i A', strtotime($cita['fecha_hora']));
                    echo "<div class='cita-item'>";
                    echo "<h4>📅 $fecha</h4>";
                    echo "<p><strong>Motivo:</strong> " . htmlspecialchars($cita['motivo_consulta']) . "</p>";
                    echo "<p><strong>Estado:</strong> <span style='color:#667eea;font-weight:600;'>$cita[estado]</span></p>";
                    echo "</div>";
                }
            } else {
                echo "<div class='sin-datos'>No hay citas registradas</div>";
            }
            $conexion->close();
            ?>
        </div>
        <?php else: ?>
        <div class="sin-datos">
            <h3>No hay paciente registrado</h3>
            <p>Debes registrar un paciente para ver el historial médico</p>
        </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>