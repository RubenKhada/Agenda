<?php
error_reporting(0);
session_start();
require_once '../../api/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}

$usuarioId = $_SESSION['usuario_id'];
$paciente = $conexion->query("SELECT id FROM pacientes WHERE usuario_id = $usuarioId")->fetch_assoc();
$pacienteId = $paciente['id'] ?? 0;

// Enviar mensaje - Sin redirección problemática
$mensajeEnviado = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mensaje']) && $pacienteId > 0) {
    $mensaje = $_POST['mensaje'];
    $conexion->query("INSERT INTO mensajes (emisor_id, tipo_emisor, mensaje, paciente_id) 
                    VALUES ($usuarioId, 'usuario', '$mensaje', $pacienteId)");
    $mensajeEnviado = true;
    // Limpiar POST para evitar reenvío
    unset($_POST);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../styles.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        .page-header h1 { color: white; font-size: 1.8rem; font-weight: 700; }
        .btn-volver {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
        }
        .content { padding: 40px; max-width: 1000px; margin: 0 auto; }
        .chat-panel {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
            display: flex;
            flex-direction: column;
            height: calc(100vh - 200px);
            min-height: 500px;
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
        .message-usuario {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            margin-left: auto;
        }
        .message-doctor {
            background: #e8ebff;
            margin-right: auto;
        }
        .message-text { line-height: 1.5; margin-bottom: 8px; }
        .message-time { font-size: 0.75rem; opacity: 0.7; }
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
        .chat-input textarea:focus { outline: none; border-color: #667eea; }
        .btn-enviar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 35px;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
        }
        .sin-paciente {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #888;
            text-align: center;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Mensajes con el Doctor</h1>
        <a href="dashboard.php" class="btn-volver">Volver al Menú</a>
    </div>
    
    <div class="content">
        <?php if ($pacienteId > 0): ?>
        
        <?php if ($mensajeEnviado): ?>
        <div class="alert-success">✅ Mensaje enviado correctamente</div>
        <?php endif; ?>
        
        <div class="chat-panel">
            <div class="chat-header">
                Conversación con tu Pediatra
            </div>
            
            <div class="chat-messages">
                <?php
                $mensajes = $conexion->query("SELECT * FROM mensajes 
                                              WHERE paciente_id = $pacienteId
                                              ORDER BY fecha_envio ASC");
                
                if ($mensajes->num_rows > 0) {
                    while ($msg = $mensajes->fetch_assoc()) {
                        $clase = $msg['tipo_emisor'] == 'usuario' ? 'message-usuario' : 'message-doctor';
                        $texto = htmlspecialchars($msg['mensaje']);
                        $tiempo = date('d/m/Y g:i A', strtotime($msg['fecha_envio']));
                        
                        echo "<div class='message $clase'>";
                        echo "<div class='message-text'>$texto</div>";
                        echo "<div class='message-time'>$tiempo</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p style='text-align:center;color:#888;padding:40px;'>Aún no hay mensajes. ¡Escribe el primero!</p>";
                }
                ?>
            </div>
            
            <form class="chat-input" method="POST">
                <textarea name="mensaje" rows="2" placeholder="Escribe tu mensaje para el doctor..." required></textarea>
                <button type="submit" class="btn-enviar">Enviar Mensaje</button>
            </form>
        </div>
        <?php else: ?>
        <div class="sin-paciente">
            <div>
                <h3 style="margin-bottom: 10px;">No hay paciente registrado</h3>
                <p>Debes registrar un paciente para poder enviar mensajes</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-scroll al final del chat
        const chatMessages = document.querySelector('.chat-messages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    </script>
</body>
</html>