<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pediatría Integral Satélite</title>
    <link rel="stylesheet" href="registro-styles.css">
</head>
<body>

    <div class="container">
        <div class="image-section">
            <div class="image-overlay">
                <h2>Bienvenido de nuevo</h2>
                <p>Accede a tu cuenta para gestionar las citas médicas de tu hijo.</p>
            </div>
        </div>

        <div class="form-section">
            <h2>Iniciar Sesión</h2>
            
            <!-- Formulario tradicional -->
            <form action="../api/login-usuario.php" method="POST">
                
                <div class="input-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" required>
                </div>

                <button type="submit" class="btn-login">Ingresar</button>

                <div class="footer-text">
                    <a href="registro-usuario.html">¿No tienes cuenta? Regístrate</a>
                </div>
                
                <div class="footer-text">
                    <a href="login-doctor.html">Soy doctor</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>