<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: ../login-doctor.html');
    exit;
}

if (isset($_GET['accion']) && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $accion = $_GET['accion'];
    
    if ($accion == 'confirmar') {
        $conexion->query("UPDATE citas SET estado = 'confirmada' WHERE id = $id");
    } elseif ($accion == 'cancelar') {
        $conexion->query("UPDATE citas SET estado = 'cancelada' WHERE id = $id");
    } elseif ($accion == 'completar') {
        $conexion->query("UPDATE citas SET estado = 'completada' WHERE id = $id");
    }
    
    header('Location: gestionar-citas.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        /* Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
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
            transition: all 0.3s;
        }
        
        .btn-volver:hover {
            background: rgba(255,255,255,0.3);
        }
        
        /* Contenido */
        .content {
            padding: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Tabla */
        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
        
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-container th {
            background: #667eea;
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table-container td {
            padding: 16px 15px;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
            color: #333;
        }
        
        .table-container tr:hover {
            background: #f8f9ff;
        }
        
        .table-container tr:last-child td {
            border-bottom: none;
        }
        
        /* Estado */
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
        
        /* Botones de acción */
        .btn-accion {
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            margin: 3px;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-confirmar { background: #10b981; color: white; }
        .btn-confirmar:hover { background: #059669; }
        
        .btn-cancelar { background: #ef4444; color: white; }
        .btn-cancelar:hover { background: #dc2626; }
        
        .btn-completar { background: #3b82f6; color: white; }
        .btn-completar:hover { background: #2563eb; }
        
        .sin-datos {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Gestión de Citas</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Panel</a>
    </div>
    
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Tutor</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $citas = $conexion->query("SELECT c.*, p.nombre as paciente, u.nombre_completo as tutor 
                                            FROM citas c 
                                            JOIN pacientes p ON c.paciente_id = p.id 
                                            JOIN usuarios u ON p.usuario_id = u.id 
                                            ORDER BY c.fecha_hora DESC");
                    
                    if ($citas->num_rows > 0) {
                        while ($cita = $citas->fetch_assoc()) {
                            $fecha = date('d/m/Y', strtotime($cita['fecha_hora']));
                            $hora = date('g:i A', strtotime($cita['fecha_hora']));
                            
                            echo "<tr>";
                            echo "<td><strong>" . htmlspecialchars($cita['paciente']) . "</strong></td>";
                            echo "<td>" . htmlspecialchars($cita['tutor']) . "</td>";
                            echo "<td>$fecha</td>";
                            echo "<td>$hora</td>";
                            echo "<td>" . htmlspecialchars($cita['motivo_consulta']) . "</td>";
                            echo "<td><span class='badge badge-" . $cita['estado'] . "'>" . $cita['estado'] . "</span></td>";
                            echo "<td>";
                            
                            if ($cita['estado'] == 'pendiente') {
                                echo "<a href='?accion=confirmar&id=" . $cita['id'] . "' class='btn-accion btn-confirmar'>Confirmar</a>";
                                echo "<a href='?accion=cancelar&id=" . $cita['id'] . "' class='btn-accion btn-cancelar'>Cancelar</a>";
                            }
                            
                            if ($cita['estado'] == 'confirmada') {
                                echo "<a href='?accion=completar&id=" . $cita['id'] . "' class='btn-accion btn-completar'>Completar</a>";
                            }
                            
                            echo "</td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='sin-datos'>No hay citas registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>