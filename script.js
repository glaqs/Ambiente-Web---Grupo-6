function mostrarSeccion(id) {
    const secciones = [
        "login",
        "registro",
        "dashboard",
        "finanzas",
        "reportes",
        "usuario",
        "notificaciones",
        "config",
    ];
    secciones.forEach(sec => {
        document.getElementById(sec).classList.add("hidden");
    });
    document.getElementById(id).classList.remove("hidden");
}

function mostrarMenuLogueado() {
    document.querySelectorAll('.nav-logged').forEach(el => {
        el.classList.remove('hidden');
    });
    document.getElementById('navLogin').classList.add('hidden');
    document.getElementById('navRegistro').classList.add('hidden');
}

function mostrarMenuNoLogueado() {
    document.querySelectorAll('.nav-logged').forEach(el => {
        el.classList.add('hidden');
    });
    document.getElementById('navLogin').classList.remove('hidden');
    document.getElementById('navRegistro').classList.remove('hidden');
}

function logout() {
    fetch('logout.php', { method: 'POST' })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                mostrarMenuNoLogueado();
                mostrarSeccion('login');
            } else {
                alert('Error al cerrar sesión');
            }
        })
        .catch(() => alert('Error en la conexión'));
}

window.onload = function () {
    mostrarMenuNoLogueado();
    mostrarSeccion('login');
};

function enviarFormulario(url, formElement, onSuccess) {
    const formData = new FormData(formElement);
    fetch(url, {
        method: 'POST',
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                if (onSuccess) onSuccess();
            } else {
                alert(data.message);
            }
        })
        .catch(() => alert('Error en la conexión'));
}

document.getElementById('formLogin').addEventListener('submit', function (e) {
    e.preventDefault();
    enviarFormulario('login.php', this, () => {
        mostrarMenuLogueado();
        mostrarSeccion('dashboard');
    });
});

document.getElementById('formRegistro').addEventListener('submit', function (e) {
    e.preventDefault();
    enviarFormulario('registro.php', this, () => {
        mostrarMenuLogueado();
        mostrarSeccion('dashboard');
    });
});
