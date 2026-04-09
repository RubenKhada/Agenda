<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../iniciasesion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta - Pediatría Integral Satélite</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .top-bar {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .top-bar h1 {
            color: #667eea;
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .top-bar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .top-bar .user-name {
            color: #333;
            font-weight: 600;
        }
        
        .btn-logout {
            background: #667eea;
            color: white;
            padding: 10px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-logout:hover {
            background: #764ba2;
            transform: translateY(-2px);
        }
        
        .main-content {
            padding: 50px 40px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .welcome-section {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        
        .welcome-section h2 {
            color: #333;
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .welcome-section p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }
        
        .module-card {
            background: white;
            border-radius: 15px;
            padding: 35px 30px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            border-left: 5px solid transparent;
        }
        
        .module-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
            border-left-color: #667eea;
        }
        
        .module-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        
        .module-card h3 {
            color: #333;
            font-size: 1.3rem;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .module-card p {
            color: #888;
            font-size: 0.95rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>Pediatría Integral Satélite</h1>
        <div class="user-info">
            <span class="user-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            <a href="../../api/cerrar-sesion.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="welcome-section">
            <h2>Bienvenido</h2>
            <p>Gestiona las citas médicas de tu hijo desde un solo lugar</p>
        </div>
        
        <div class="modules-grid">
            <a href="agendar-cita.php" class="module-card">
                <div class="module-icon">📅</div>
                <h3>Agendar Cita</h3>
                <p>Programa una nueva consulta médica</p>
            </a>
            
            <a href="mis-citas.php" class="module-card">
                <div class="module-icon">📋</div>
                <h3>Mis Citas</h3>
                <p>Ver citas programadas y su estado</p>
            </a>
            
            <a href="historial.php" class="module-card">
                <div class="module-icon">📁</div>
                <h3>Historial Médico</h3>
                <p>Expediente médico de tu hijo</p>
            </a>
            
            <a href="mensaje.php" class="module-card">
                <div class="module-icon">💬</div>
                <h3>Mensajes</h3>
                <p>Chat directo con el pediatra</p>
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>