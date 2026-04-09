<header> 
        <nav>
            <div class="logo">Pediatría Integral Satélite</div>
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#servicios">Servicios</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <section class="hero" id="inicio">
        <div class="hero-image-container">
            <img src="Pediatra2.jpeg" alt="Niños felices en consultorio" class="hero-image">
            <div class="hero-overlay"></div>
        </div>
        <div class="hero-content">
            <h1>Cuidando la salud y sonrisa de tus hijos</h1>
            <p>Atención pediátrica especializada con amor y profesionalismo</p>
            <div class="hero-buttons">
                <button class="btn-primary" onclick="abrirModal()">Agendar Cita</button>
            </div>
        </div>
    </section>

    <section class="por-que-elegirnos" id="servicios">
        <h2 class="section-title">¿Por qué elegirnos?</h2>
        <div class="cards-container">
            <div class="card">
                <div class="card-icon">👨‍⚕️</div>
                <h3>Atención Especializada</h3>
                <p>Contamos con pediatras altamente capacitados y con años de experiencia en el cuidado infantil.</p>
            </div>
            <div class="card">
                <div class="card-icon">📅</div>
                <h3>Citas Rápidas</h3>
                <p>Sistema de agendamiento en línea fácil de usar. Encuentra disponibilidad sin largas esperas.</p>
            </div>
            <div class="card">
                <div class="card-icon">🏥</div>
                <h3>Instalaciones Seguras</h3>
                <p>Espacios diseñados especialmente para la comodidad, diversión y seguridad de los más pequeños.</p>
            </div>
            <div class="card">
                <div class="card-icon">📱</div>
                <h3>Historial Digital</h3>
                <p>Accede al expediente médico de tu hijo desde cualquier dispositivo, en cualquier momento.</p>
            </div>
        </div>
    </section>

    <footer id="contacto">
        <div class="footer-content">
            <h2 class="footer-title">Pediatría Integral Satélite</h2>
            <p class="footer-subtitle">Cuidando la salud y sonrisa de tus hijos todos los días.</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <span class="contact-icon">📍</span>
                    <span>Circuito Poetas, Ciudad Satélite</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">📞</span>
                    <span>(55) 5902 0742</span>
                </div>
                <div class="contact-item">
                    <span class="contact-icon">✉️</span>
                    <span>consultoriopediatrico@gmail.com</span>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2026 Pediatría Integral Satélite. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal de Login -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h2>Bienvenido</h2>
            <p>Inicia sesión para acceder a tu cuenta</p>
            
            <!-- ✅ RUTA CORREGIDA: ../api/ (subir un nivel desde public/) -->
            <form action="../api/login-usuario.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn-submit">Ingresar</button>
            </form>
            
            <div class="register-link">
                <p>¿Eres nuevo? <a href="registro-usuario.html">Regístrate aquí</a></p>
                <p style="margin-top: 10px; font-size: 0.9rem;">
                    <a href="login-doctor.html">Eres doctor</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function abrirModal() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('loginModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Mostrar mensaje si hay error de login (por URL)
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === '1') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Correo o contraseña incorrectos',
                confirmButtonColor: '#667eea'
            });
        }
    </script>