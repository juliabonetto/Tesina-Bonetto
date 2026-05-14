<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrarse | EcoScam</title>
  <style>
    :root {
      --bg:        #f4f1ea;
      --ink:       #14241b;
      --ink-soft:  #3a4a40;
      --green:     #1f6b3a;
      --lime:      #c8f257;
      --radius:    22px;
      --serif:     'Fraunces', Georgia, serif;
      --sans:      'Inter', system-ui, sans-serif;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg);
      font-family: var(--sans);
      color: var(--ink);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: #fff;
      padding: 2rem;
      border-radius: var(--radius);
      box-shadow: 0 12px 30px rgba(20,36,27,0.15);
      width: 100%;
      max-width: 420px;
      text-align: center;
    }

    h2 {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: var(--green);
    }

    input {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid rgba(20,36,27,0.2);
      border-radius: 12px;
      transition: border-color 0.3s;
      font-size: 15px;
    }

    input:focus {
      border-color: var(--green);
      outline: none;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background: var(--green);
      color: #fff;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
      font-family: var(--sans);
      transition: background 0.3s, transform 0.2s;
    }

    button:hover {
      background: var(--ink);
      transform: translateY(-2px);
    }

    .link-btn {
      display: block;
      margin-top: 1rem;
      color: var(--green);
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    .link-btn:hover { color: var(--ink); text-decoration: underline; }

    .error-msg {
      color: red;
      margin-bottom: 1rem;
      font-size: 0.9rem;
    }

    .password-container {
      position: relative;
      width: 100%;
      margin-bottom: 1rem;
    }

    .password-container input {
      padding-right: 40px;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: var(--ink-soft);
      user-select: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Crear cuenta</h2>

    <?php if (session()->getFlashdata('success')): ?>
      <p style="color: var(--green); font-weight: bold; margin-bottom: 1rem;">
        <?= session()->getFlashdata('success') ?>
      </p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      <p class="error-msg"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <form action="<?= site_url('usuario/registrar') ?>" method="post">
      <?= csrf_field() ?>
      <input type="text" name="nombre" placeholder="Nombre" value="<?= old('nombre') ?>" required>
      <input type="text" name="apellido" placeholder="Apellido" value="<?= old('apellido') ?>" required>
      <input type="text" name="dni" placeholder="DNI" value="<?= old('dni') ?>" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">

      <input type="email" id="email" name="email" placeholder="Correo electrónico" value="<?= old('email') ?>" required>
      <input type="email" id="confirmEmail" name="confirmEmail" placeholder="Confirmar correo electrónico" required>
      <p id="emailError" class="error-msg" style="display:none;">Los correos no coinciden</p>

      <div class="password-container">
        <input type="password" id="password" name="contraseña" placeholder="Contraseña" required>
        <span class="toggle-password" onclick="togglePassword()">🌱</span>
      </div>

      <button type="submit">Registrarse</button>
    </form>

    <a href="<?= site_url('usuario/login') ?>" class="link-btn">¿Ya tenés cuenta? Iniciar sesión</a>
    <a href="<?= site_url('usuario/inicio') ?>" class="link-btn" style="margin-top: 0.5rem;">← Volver al inicio</a>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.querySelector(".toggle-password");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.textContent = "👁️";
      } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "🌱";
      }
    }

    document.querySelector("form").addEventListener("submit", function(e) {
      const email = document.getElementById("email").value.trim();
      const confirmEmail = document.getElementById("confirmEmail").value.trim();
      const errorMsg = document.getElementById("emailError");

      if (email !== confirmEmail) {
        e.preventDefault();
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });
  </script>
</body>
</html>
