document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registroForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpiar errores previos
        limpiarErrores();
        
        // Validar formulario
        if (validarFormulario()) {
            // Mostrar estado de carga
            const btn = form.querySelector('.btn-login');
            const textoOriginal = btn.textContent;
            btn.textContent = 'Registrando...';
            btn.disabled = true;
            
            // Recopilar datos
            const formData = new FormData(form);
            const datos = Object.fromEntries(formData);
            
            // Enviar al backend
            fetch('../api/registro-usuario.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Registro exitoso
                    alert('Registro exitoso. Ahora puedes iniciar sesión.');
                    window.location.href = 'index.html';
                } else {
                    // Error del servidor
                    alert('Error: ' + data.message);
                    btn.textContent = textoOriginal;
                    btn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error al registrar. Intenta de nuevo.');
                btn.textContent = textoOriginal;
                btn.disabled = false;
            });
        }
    });
    
    // Validación en tiempo real
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validarCampo(this);
        });
        
        input.addEventListener('input', function() {
            if (this.parentElement.classList.contains('error')) {
                this.parentElement.classList.remove('error');
            }
        });
    });
});

function validarFormulario() {
    let esValido = true;
    
    // Validar cada campo
    const campos = ['nombreTutor', 'email', 'telefono', 'password', 'confirmPassword', 'nombrePaciente', 'fechaNacimiento', 'genero'];
    
    campos.forEach(campo => {
        const input = document.getElementById(campo);
        if (!validarCampo(input)) {
            esValido = false;
        }
    });
    
    // Validar que las contraseñas coincidan
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    if (password !== confirmPassword) {
        mostrarError('confirmPassword', 'Las contraseñas no coinciden');
        esValido = false;
    }
    
    // Validar edad del paciente (menor de 18 años)
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    if (fechaNacimiento && !validarEdadPaciente(fechaNacimiento)) {
        mostrarError('fechaNacimiento', 'El paciente debe ser menor de 18 años');
        esValido = false;
    }
    
    return esValido;
}

function validarCampo(input) {
    const valor = input.value.trim();
    const id = input.id;
    
    // Campos requeridos vacíos
    if (input.required && !valor) {
        mostrarError(id, 'Este campo es obligatorio');
        return false;
    }
    
    // Validaciones específicas
    switch(id) {
        case 'email':
            if (valor && !validarEmail(valor)) {
                mostrarError(id, 'Ingresa un correo válido');
                return false;
            }
            break;
            
        case 'telefono':
            if (valor && !validarTelefono(valor)) {
                mostrarError(id, 'Ingresa un teléfono válido (10 dígitos)');
                return false;
            }
            break;
            
        case 'password':
            if (valor && valor.length < 6) {
                mostrarError(id, 'Mínimo 6 caracteres');
                return false;
            }
            break;
    }
    
    // Campo válido
    input.parentElement.classList.remove('error');
    input.parentElement.classList.add('success');
    return true;
}

function mostrarError(campoId, mensaje) {
    const input = document.getElementById(campoId);
    const grupo = input.parentElement;
    const errorDiv = grupo.querySelector('.error-message') || crearElementoError(grupo);
    
    grupo.classList.add('error');
    grupo.classList.remove('success');
    errorDiv.textContent = mensaje;
}

function crearElementoError(grupo) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    grupo.appendChild(errorDiv);
    return errorDiv;
}

function limpiarErrores() {
    document.querySelectorAll('.input-group').forEach(grupo => {
        grupo.classList.remove('error', 'success');
        const errorDiv = grupo.querySelector('.error-message');
        if (errorDiv) errorDiv.remove();
    });
}

function validarEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

function validarTelefono(telefono) {
    const limpio = telefono.replace(/\D/g, '');
    return /^\d{10}$/.test(limpio);
}

function validarEdadPaciente(fechaNacimiento) {
    const nacimiento = new Date(fechaNacimiento);
    const hoy = new Date();
    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();
    
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }
    
    return edad >= 0 && edad < 18;
}