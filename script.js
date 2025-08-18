// Función para mostrar una sección y ocultar las demás
function mostrarSeccion(id) {
    const secciones = ['login', 'registro', 'dashboard', 'finanzas', 'reportes', 'usuario', 'notificaciones', 'config'];
    secciones.forEach(sec => {
        const el = document.getElementById(sec);
        if (el) el.classList.add('hidden'); // Oculta todas
    });
    const mostrar = document.getElementById(id);
    if (mostrar) mostrar.classList.remove('hidden'); // Muestra la seleccionada
}

// Detecta si el usuario no ha iniciado sesión y oculta secciones
document.addEventListener('DOMContentLoaded', () => {
    // Solo login y registro son visibles si no hay sesión
    const userLoggedIn = document.body.getAttribute('data-loggedin'); // atributo que agregamos desde PHP

    if (!userLoggedIn) {
        const secciones = ['dashboard', 'finanzas', 'reportes', 'usuario', 'notificaciones', 'config'];
        secciones.forEach(sec => {
            const el = document.getElementById(sec);
            if (el) el.classList.add('hidden');
        });
        // Mostrar login por defecto
        mostrarSeccion('login');
    }
});

