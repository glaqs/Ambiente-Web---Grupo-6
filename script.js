document.addEventListener("DOMContentLoaded", function () {

    function mostrarSeccion(id) {
        const secciones = ["login", "registro", "dashboard", "finanzas", "reportes", "usuario", "notificaciones", "config"];
        secciones.forEach(sec => {
            const elemento = document.getElementById(sec);
            if (elemento) elemento.classList.add("hidden");
        });
        const seccionActiva = document.getElementById(id);
        if (seccionActiva) seccionActiva.classList.remove("hidden");
    }

    function mostrarMenuLogueado() {
        document.querySelectorAll('.nav-logged').forEach(el => el.classList.remove('hidden'));
        document.getElementById('navLogin')?.classList.add('hidden');
        document.getElementById('navRegistro')?.classList.add('hidden');
    }

    function mostrarMenuNoLogueado() {
        document.querySelectorAll('.nav-logged').forEach(el => el.classList.add('hidden'));
        document.getElementById('navLogin')?.classList.remove('hidden');
        document.getElementById('navRegistro')?.classList.remove('hidden');
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
            }).catch(() => alert('Error en la conexión'));
    }

    function enviarFormulario(url, formElement, onSuccess) {
        const formData = new FormData(formElement);
        fetch(url, { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    if (onSuccess) onSuccess();
                } else {
                    alert(data.message || 'Error en el servidor');
                }
            }).catch(() => alert('Error en la conexión'));
    }

    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            e.preventDefault();
            enviarFormulario('login.php', this, () => {
                mostrarMenuLogueado();
                mostrarSeccion('dashboard');
            });
        });
    }

    const formRegistro = document.getElementById('formRegistro');
    if (formRegistro) {
        formRegistro.addEventListener('submit', function (e) {
            e.preventDefault();
            enviarFormulario('registro.php', this, () => {
                mostrarMenuLogueado();
                mostrarSeccion('dashboard');
            });
        });
    }

    // Estado inicial
    mostrarMenuNoLogueado();
    mostrarSeccion('login');

    // Exponer funciones globalmente
    window.logout = logout;
    window.mostrarSeccion = mostrarSeccion; // <-- ahora tus onclick HTML funcionan
});
