<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: ../login-doctor.html');
    exit;
}

$pacienteId = isset($_GET['paciente']) ? (int)$_GET['paciente'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensaje'])) {
    $mensaje = $_POST['mensaje'];
    $conexion->query("INSERT INTO mensajes (emisor_id, tipo_emisor, mensaje, paciente_id) 
                    VALUES ($_SESSION[doctor_id], 'doctor', '$mensaje', $pacienteId)");
    header('Location: mensajes.php?paciente=' . $pacienteId);
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Pediatría Integral Satélite</title>
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
        
        .chat-container {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 25px;
            height: calc(100vh - 200px);
            min-height: 550px;
        }
        
        /* Lista de pacientes */
        .pacientes-panel {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }
        
        .pacientes-panel h3 {
            background: #667eea;
            color: white;
            padding: 18px 20px;
            font-size: 1rem;
            font-weight: 600;
        }
        
        .paciente-item {
            padding: 18px 20px;
            border-bottom: 1px solid #eee;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
            display: block;
        }
        
        .paciente-item:hover {
            background: #f8f9ff;
        }
        
        .paciente-item.activo {
            background: #e8ebff;
            border-left: 4px solid #667eea;
        }
        
        .paciente-item h4 {
            font-size: 0.95rem;
            margin-bottom: 5px;
            color: #333;
        }
        
        .paciente-item small {
            color: #888;
            font-size: 0.85rem;
        }
        
        /* Área de chat */
        .chat-panel {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
        }
        
        .chat-header {
            background: #667eea;
            color: white;
            padding: 18px 25px;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .chat-messages {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            background: #f8f9ff;
        }
        
        .message {
            padding: 15px 20px;
            margin-bottom: 15px;
            border-radius: 12px;
            max-width: 75%;
        }
        
        .message-paciente {
            background: #e8ebff;
            margin-right: auto;
        }
        
        .message-doctor {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            margin-left: auto;
        }
        
        .message-text {
            line-height: 1.5;
            margin-bottom: 8px;
        }
        
        .message-time {
            font-size: 0.75rem;
            opacity: 0.7;
        }
        
        .chat-input {
            padding: 20px 25px;
            border-top: 1px solid #eee;
            background: white;
        }
        
        .chat-input textarea {
            width: 100%;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 12px;
            resize: none;
            font-family: inherit;
            font-size: 0.95rem;
            margin-bottom: 15px;
        }
        
        .chat-input textarea:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn-enviar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 35px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .sin-seleccion {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Mensajes</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Panel</a>
    </div>
    
    <div class="content">
        <div class="chat-container">
            <div class="pacientes-panel">
                <h3>Pacientes</h3>
                <?php
                $pacientes = $conexion->query("SELECT DISTINCT p.id, p.nombre, u.nombre_completo as tutor 
                                               FROM pacientes p 
                                               JOIN usuarios u ON p.usuario_id = u.id 
                                               ORDER BY p.nombre");
                while ($p = $pacientes->fetch_assoc()) {
                    $activo = $p['id'] == $pacienteId ? 'activo' : '';
                    echo "<a href='?paciente=" . $p['id'] . "' class='paciente-item $activo'>";
                    echo "<h4>" . htmlspecialchars($p['nombre']) . "</h4>";
                    echo "<small>Tutor: " . htmlspecialchars($p['tutor']) . "</small>";
                    echo "</a>";
                }
                ?>
            </div>
            
            <div class="chat-panel">
                <?php if ($pacienteId > 0): 
                    $paciente = $conexion->query("SELECT nombre FROM pacientes WHERE id = $pacienteId")->fetch_assoc();
                ?>
                <div class="chat-header">
                    Conversación con <?php echo htmlspecialchars($paciente['nombre']); ?>
                </div>
                
                <div class="chat-messages">
                    <?php
                    $mensajes = $conexion->query("SELECT * FROM mensajes 
                                                  WHERE paciente_id = $pacienteId
                                                  ORDER BY fecha_envio ASC");
                    
                    while ($msg = $mensajes->fetch_assoc()) {
                        $clase = $msg['tipo_emisor'] == 'doctor' ? 'message-doctor' : 'message-paciente';
                        $texto = htmlspecialchars($msg['mensaje']);
                        $tiempo = date('d/m/Y g:i A', strtotime($msg['fecha_envio']));
                        
                        echo "<div class='message $clase'>";
                        echo "<div class='message-text'>$texto</div>";
                        echo "<div class='message-time'>$tiempo</div>";
                        echo "</div>";
                    }
                    ?>
                </div>
                
                <form class="chat-input" method="POST">
                    <textarea name="mensaje" rows="2" placeholder="Escribe tu mensaje..." required></textarea>
                    <button type="submit" class="btn-enviar">Enviar Mensaje</button>
                </form>
                <?php else: ?>
                <div class="sin-seleccion">
                    <div>
                        <h3 style="margin-bottom: 10px;">Selecciona un paciente</h3>
                        <p>Haz clic en un paciente para iniciar la conversación</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>