<?php
session_start();

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
    <title>Panel Médico - Pediatría Integral Satélite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        /* Header */
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
        
        /* Contenido principal */
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
        
        /* Grid de módulos */
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
        <h1>Panel Médico</h1>
        <div class="user-info">
            <span class="user-name">Dr. <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
            <a href="../../api/cerrar-sesion.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="welcome-section">
            <h2>Bienvenido</h2>
            <p>Gestiona tus citas, pacientes y recetas desde un solo lugar</p>
        </div>
        
        <div class="modules-grid">
            <a href="gestionar-citas.php" class="module-card">
                <div class="module-icon">📅</div>
                <h3>Gestión de Citas</h3>
                <p>Confirma, cancela o completa las citas programadas</p>
            </a>
            
            <a href="mensajes.php" class="module-card">
                <div class="module-icon">💬</div>
                <h3>Mensajes</h3>
                <p>Comunícate con tus pacientes de forma privada</p>
            </a>
            
            <a href="aprobacion-cambios.php" class="module-card">
                <div class="module-icon">✓</div>
                <h3>Aprobar Cambios</h3>
                <p>Revisa y autoriza solicitudes de reagendamiento</p>
            </a>
            
            <a href="pacientes.php" class="module-card">
                <div class="module-icon">👥</div>
                <h3>Pacientes</h3>
                <p>Consulta historiales y datos de tus pacientes</p>
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>