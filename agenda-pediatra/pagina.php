<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Pediátrica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Agenda Pediátrica</h1>
        <?php if(isset($_SESSION['doctor_id'])): ?>
            <div class="login-box">
                <span><?php echo $_SESSION['doctor_nombre']; ?></span>
                <a href="php/cerrar_sesion.php" class="btn-logout">Salir</a>
            </div>
        <?php else: ?>
            <div class="login-box">
                <button onclick="mostrarLogin()" class="btn-login">Doctor</button>
            </div>
        <?php endif; ?>
    </header>

    <div class="container">
        <div class="menu-principal">
            <button onclick="mostrarSeccion('paciente')" class="btn-menu">Agendar Cita</button>
            <button onclick="mostrarSeccion('doctor')" class="btn-menu">Ver Citas</button>
        </div>

        <div id="seccion-paciente" class="seccion">
            <h2>Agendar Nueva Cita</h2>
            <form id="form-cita">
                <input type="text" id="paciente_nombre" placeholder="Nombre del paciente" required>
                <input type="tel" id="paciente_telefono" placeholder="Teléfono" required>
                <input type="email" id="paciente_email" placeholder="Email" required>
                <input type="date" id="cita_fecha" required>
                <input type="time" id="cita_hora" required>
                <textarea id="cita_motivo" placeholder="Motivo de la consulta" required></textarea>
                <button type="submit" class="btn-guardar">Agendar Cita</button>
            </form>
        </div>

        <div id="seccion-doctor" class="seccion oculto">
            <h2>Citas Programadas</h2>
            <div id="lista-citas"></div>
        </div>

        <div id="login-doctor" class="seccion oculto">
            <h2>Acceso Doctores</h2>
            <form id="form-login">
                <input type="text" id="login_usuario" placeholder="Usuario" required>
                <input type="password" id="login_password" placeholder="Contraseña" required>
                <button type="submit" class="btn-guardar">Ingresar</button>
            </form>
            <button onclick="mostrarRegistro()" class="btn-secundario">Registrarse</button>
        </div>

        <div id="registro-doctor" class="seccion oculto">
            <h2>Registro de Doctor</h2>
            <form id="form-registro">
                <input type="text" id="reg_nombre" placeholder="Nombre completo" required>
                <input type="text" id="reg_usuario" placeholder="Usuario" required>
                <input type="password" id="reg_password" placeholder="Contraseña" required>
                <input type="password" id="reg_clave" placeholder="Clave maestra" required>
                <button type="submit" class="btn-guardar">Registrarse</button>
            </form>
            <button onclick="mostrarLogin()" class="btn-secundario">Volver</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>