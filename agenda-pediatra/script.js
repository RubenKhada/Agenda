function mostrarSeccion(seccion) {
    document.querySelectorAll('.seccion').forEach(s => s.classList.add('oculto'));
    
    if (seccion === 'paciente') {
        document.getElementById('seccion-paciente').classList.remove('oculto');
    } else if (seccion === 'doctor') {
        document.getElementById('seccion-doctor').classList.remove('oculto');
        cargarCitas();
    }
}

function mostrarLogin() {
    document.querySelectorAll('.seccion').forEach(s => s.classList.add('oculto'));
    document.getElementById('login-doctor').classList.remove('oculto');
}

function mostrarRegistro() {
    document.querySelectorAll('.seccion').forEach(s => s.classList.add('oculto'));
    document.getElementById('registro-doctor').classList.remove('oculto');
}

document.getElementById('form-cita').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData();
    formData.append('paciente_nombre', document.getElementById('paciente_nombre').value);
    formData.append('paciente_telefono', document.getElementById('paciente_telefono').value);
    formData.append('paciente_email', document.getElementById('paciente_email').value);
    formData.append('cita_fecha', document.getElementById('cita_fecha').value);
    formData.append('cita_hora', document.getElementById('cita_hora').value);
    formData.append('cita_motivo', document.getElementById('cita_motivo').value);
    
    fetch('php/guardar_cita.php', {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.mensaje);
        if (data.success) {
            this.reset();
        }
    }.bind(this));
});

document.getElementById('form-login').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData();
    formData.append('usuario', document.getElementById('login_usuario').value);
    formData.append('password', document.getElementById('login_password').value);
    
    fetch('php/login.php', {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.success) {
            location.reload();
        } else {
            alert(data.mensaje);
        }
    });
});

document.getElementById('form-registro').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var formData = new FormData();
    formData.append('nombre', document.getElementById('reg_nombre').value);
    formData.append('usuario', document.getElementById('reg_usuario').value);
    formData.append('password', document.getElementById('reg_password').value);
    formData.append('clave_maestra', document.getElementById('reg_clave').value);
    
    fetch('php/registro.php', {
        method: 'POST',
        body: formData
    })
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        alert(data.mensaje);
        if (data.success) {
            mostrarLogin();
        }
    });
});

function cargarCitas() {
    fetch('php/obtener_citas.php')
    .then(function(response) {
        return response.json();
    })
    .then(function(data) {
        if (data.mensaje === 'No hay sesión') {
            document.getElementById('lista-citas').innerHTML = '<p class="texto-centro texto-gris">Debes iniciar sesión como doctor para ver las citas</p>';
            return;
        }
        
        if (data.citas.length === 0) {
            document.getElementById('lista-citas').innerHTML = '<p class="texto-centro texto-gris">No hay citas programadas</p>';
            return;
        }
        
        var html = '<table class="tabla-citas"><tr><th>Fecha</th><th>Hora</th><th>Paciente</th><th>Teléfono</th><th>Motivo</th><th>Acciones</th></tr>';
        
        for (var i = 0; i < data.citas.length; i++) {
            var cita = data.citas[i];
            html += '<tr>';
            html += '<td>' + cita.fecha + '</td>';
            html += '<td>' + cita.hora + '</td>';
            html += '<td>' + cita.paciente_nombre + '</td>';
            html += '<td>' + cita.paciente_telefono + '</td>';
            html += '<td>' + cita.motivo + '</td>';
            html += '<td><button onclick="editarCita(' + cita.id + ',\'' + cita.fecha + '\',\'' + cita.hora + '\',\'' + cita.motivo + '\')" class="btn-editar">Editar</button>';
            html += '<button onclick="borrarCita(' + cita.id + ')" class="btn-eliminar">Borrar</button></td>';
            html += '</tr>';
        }
        
        html += '</table>';
        document.getElementById('lista-citas').innerHTML = html;
    })
    .catch(function(error) {
        console.error('Error:', error);
        document.getElementById('lista-citas').innerHTML = '<p class="texto-centro texto-gris">Error al cargar citas</p>';
    });
}

function editarCita(id, fecha, hora, motivo) {
    var nuevaFecha = prompt('Nueva fecha (YYYY-MM-DD):', fecha);
    var nuevaHora = prompt('Nueva hora (HH:MM):', hora);
    var nuevoMotivo = prompt('Nuevo motivo:', motivo);
    
    if (nuevaFecha && nuevaHora && nuevoMotivo) {
        var formData = new FormData();
        formData.append('cita_id', id);
        formData.append('fecha', nuevaFecha);
        formData.append('hora', nuevaHora);
        formData.append('motivo', nuevoMotivo);
        
        fetch('php/editar_cita.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                cargarCitas();
            } else {
                alert(data.mensaje);
            }
        });
    }
}

function borrarCita(id) {
    if (confirm('¿Eliminar esta cita?')) {
        var formData = new FormData();
        formData.append('cita_id', id);
        
        fetch('php/borrar_cita.php', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                cargarCitas();
            } else {
                alert(data.mensaje);
            }
        });
    }
}