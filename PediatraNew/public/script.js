// ==========================================
// FUNCIONES DEL MODAL DE LOGIN
// ==========================================

function abrirModal() {
    document.getElementById('loginModal').style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('loginModal').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('loginModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// ==========================================
// FORMULARIO DE LOGIN
// ==========================================

document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // AQUÍ IRÁ LA CONEXIÓN CON EL BACKEND DESPUÉS
    console.log('Intentando login:', email);
    alert('Funcionalidad de login en desarrollo...');
});

// Scroll suave para navegación
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        if (this.classList.contains('btn-login')) return;
        
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});