// Función para mostrar una sección y ocultar las demás
function mostrarSeccion(id) {
    // Lista de todas las secciones posibles
    const secciones = ['login', 'registro', 'dashboard', 'finanzas', 'reportes', 'usuario', 'notificaciones', 'config'];

    secciones.forEach(sec => {
        const elemento = document.getElementById(sec);
        if (elemento) {
            elemento.classList.add('hidden'); // Oculta todas las secciones
        }
    });

    // Muestra solo la sección solicitada
    const seccionAMostrar = document.getElementById(id);
    if (seccionAMostrar) {
        seccionAMostrar.classList.remove('hidden');
    } else {
        console.error(`No se encontró la sección con ID: ${id}`);
    }
}

// Control de visibilidad según el estado de sesión
document.addEventListener('DOMContentLoaded', () => {
    // Verifica si el usuario ha iniciado sesión (atributo data-loggedin)
    const userLoggedIn = document.body.getAttribute('data-loggedin') === 'true';

    if (!userLoggedIn) {
        // Oculta secciones que requieren autenticación
        const seccionesProtegidas = ['dashboard', 'finanzas', 'reportes', 'usuario', 'notificaciones', 'config'];
        seccionesProtegidas.forEach(sec => {
            const elemento = document.getElementById(sec);
            if (elemento) elemento.classList.add('hidden');
        });

        // Muestra el formulario de login por defecto
        mostrarSeccion('login');
    } else {
        // Si está logueado, muestra el dashboard por defecto
        mostrarSeccion('dashboard');
    }
});
