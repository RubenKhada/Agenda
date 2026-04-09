<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: ../login-doctor.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Pediatría Integral Satélite</title>
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
            max-width: 1400px;
            margin: 0 auto;
        }
        
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
        
        .btn-ver {
            padding: 8px 18px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-ver:hover {
            background: #764ba2;
        }
        
        .sin-pacientes {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Pacientes</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Panel</a>
    </div>
    
    <div class="content">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Nacimiento</th>
                        <th>Edad</th>
                        <th>Género</th>
                        <th>Tutor</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pacientes = $conexion->query("SELECT p.*, u.nombre_completo as tutor, u.telefono 
                                                FROM pacientes p 
                                                JOIN usuarios u ON p.usuario_id = u.id 
                                                ORDER BY p.nombre");
                    
                    if ($pacientes->num_rows > 0) {
                        while ($p = $pacientes->fetch_assoc()) {
                            $edad = date_diff(date_create($p['fecha_nacimiento']), date_create('today'))->y;
                            $genero = $p['genero'] ?: 'No especificado';
                            
                            echo "<tr>";
                            echo "<td><strong>" . htmlspecialchars($p['nombre']) . "</strong></td>";
                            echo "<td>" . date('d/m/Y', strtotime($p['fecha_nacimiento'])) . "</td>";
                            echo "<td>$edad años</td>";
                            echo "<td>$genero</td>";
                            echo "<td>" . htmlspecialchars($p['tutor']) . "</td>";
                            echo "<td>" . htmlspecialchars($p['telefono']) . "</td>";
                            echo "<td><a href='historial-paciente.php?id=" . $p['id'] . "' class='btn-ver'>Ver Historial</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='sin-pacientes'>No hay pacientes registrados</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>