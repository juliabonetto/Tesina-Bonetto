<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrarse | EcoScam</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(135deg, rgb(208, 252, 230), rgb(82, 190, 124));
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background-color: white;
      padding: 2rem;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h2 {
      margin-bottom: 1.5rem;
      color: #333;
    }

    input {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 8px;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: rgb(25, 110, 39);
      outline: none;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background-color: rgb(0, 172, 57);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: rgb(26, 114, 40);
    }

    .link-btn {
      display: block;
      margin-top: 1rem;
      color: rgb(14, 190, 117);
      text-decoration: none;
      font-size: 0.9rem;
    }

    .link-btn:hover {
      text-decoration: underline;
    }

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
      color: #555;
      user-select: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Crear cuenta</h2>
    <?php if (session()->getFlashdata('success')): ?>
  <p style="color: green; font-weight: bold; margin-bottom: 1rem;">
    <?= session()->getFlashdata('success') ?>
  </p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
  <p class="error-msg"><?= session()->getFlashdata('error') ?></p>
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
      <p id="emailError" class="error-msg" style="display:none;">Los gmails no coinciden</p>

      <div class="password-container">
        <input type="password" id="password" name="contraseña" placeholder="Contraseña" required>
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
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
        toggleIcon.textContent = "👓"; 
      } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "👁️"; 
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

