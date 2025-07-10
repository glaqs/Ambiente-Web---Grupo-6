# Ambiente-Web---Grupo-6
<main>

    <div id="login">
      <h2>Iniciar Sesión</h2>
      <form>
        <input type="email" placeholder="Correo electrónico" required>
        <input type="password" placeholder="Contraseña" required>
        <button type="submit">Entrar</button>
      </form>
    </div>

    <div id="registro" class="hidden">
      <h2>Registro de Usuario</h2>
      <form>
        <input type="text" placeholder="Nombre completo" required>
        <input type="email" placeholder="Correo electrónico" required>
        <input type="password" placeholder="Contraseña" required>
        <input type="password" placeholder="Confirmar contraseña" required>
        <button type="submit">Crear cuenta</button>
      </form>
    </div>

    <div id="dashboard" class="hidden">
      <h2>Panel de Usuario</h2>
      <p>Bienvenido/a a tu panel. Desde aquí puedes acceder a todas las funciones de FINGO®️.</p>
    </div>

    <div id="finanzas" class="hidden">
      <section>
        <h2>Registrar Ingreso</h2>
        <form>
          <input type="text" placeholder="Fuente de ingreso">
          <input type="number" placeholder="Monto">
          <input type="date">
          <button type="submit">Guardar ingreso</button>
        </form>
      </section>

      <section>
        <h2>Registrar Gasto</h2>
        <form>
          <input type="text" placeholder="Categoría">
          <input type="number" placeholder="Monto">
          <input type="text" placeholder="Descripción">
          <input type="date">
          <button type="submit">Guardar gasto</button>
        </form>
      </section>
    </div>
  </main>

  <script>
    function mostrarSeccion(id) {
      const secciones = ['login', 'registro', 'dashboard', 'finanzas'];
      secciones.forEach(sec => {
        document.getElementById(sec).classList.add('hidden');
      });
      document.getElementById(id).classList.remove('hidden');
    }
  </script>
</body>
</html>
