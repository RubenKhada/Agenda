<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas - Pediatría Integral Satélite</title>
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
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .citas-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
        
        .citas-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .citas-container th {
            background: #667eea;
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .citas-container td {
            padding: 16px 15px;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
            color: #333;
        }
        
        .citas-container tr:hover {
            background: #f8f9ff;
        }
        
        .citas-container tr:last-child td {
            border-bottom: none;
        }
        
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .badge-pendiente { background: #fef3c7; color: #92400e; }
        .badge-confirmada { background: #d1fae5; color: #065f46; }
        .badge-cancelada { background: #fee2e2; color: #991b1b; }
        .badge-completada { background: #dbeafe; color: #1e40af; }
        
        .btn-cambio {
            padding: 8px 16px;
            background: #3b82f6;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-cambio:hover {
            background: #2563eb;
        }
        
        .sin-citas {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Mis Citas</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Menú</a>
    </div>
    
    <div class="content">
        <div class="citas-container">
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $paciente = $conexion->query("SELECT id FROM pacientes WHERE usuario_id = $usuarioId")->fetch_assoc();
                    
                    if ($paciente) {
                        $citas = $conexion->query("SELECT * FROM citas WHERE paciente_id = $paciente[id] ORDER BY fecha_hora DESC");
                        
                        if ($citas->num_rows > 0) {
                            while ($cita = $citas->fetch_assoc()) {
                                $fecha = date('d/m/Y', strtotime($cita['fecha_hora']));
                                $hora = date('g:i A', strtotime($cita['fecha_hora']));
                                
                                echo "<tr>";
                                echo "<td>$fecha</td>";
                                echo "<td>$hora</td>";
                                echo "<td>" . htmlspecialchars($cita['motivo_consulta']) . "</td>";
                                echo "<td><span class='badge badge-" . $cita['estado'] . "'>" . $cita['estado'] . "</span></td>";
                                echo "<td>";
                                if ($cita['estado'] == 'confirmada') {
                                    echo "<a href='solicitar-cambio.php?id=" . $cita['id'] . "' class='btn-cambio'>Solicitar Cambio</a>";
                                } else {
                                    echo "<span style='color:#888;'>No disponible</span>";
                                }
                                echo "</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='sin-citas'>No tienes citas programadas</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='sin-citas'>No hay paciente registrado</td></tr>";
                    }
                    $conexion->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>