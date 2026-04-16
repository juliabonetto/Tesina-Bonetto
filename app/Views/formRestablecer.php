<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablecer contraseña | ecoscam</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(135deg, rgb(228, 246, 255), rgb(14, 121, 0));
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

    label {
      display: block;
      text-align: left;
      margin-bottom: 0.5rem;
      color: #555;
      font-size: 0.9rem;
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
      border-color:rgb(14, 114, 35);
      outline: none;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background-color: rgb(43, 121, 27);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: rgb(13, 180, 35);
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

    .link-btn {
      display: block;
      margin-top: 1rem;
      color:rgb(0, 83, 38);
      text-decoration: none;
      font-size: 0.9rem;
    }

    .link-btn:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Ingresá tu nueva contraseña</h2>
    <form action="<?= site_url('usuario/guardarNuevaContrasena') ?>" method="POST">
      <input type="hidden" name="token" value="<?= esc($token) ?>">

      <label for="contraseña">Nueva contraseña</label>
      <div class="password-container">
        <input type="password" id="password" name="contraseña" required>
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
      </div>

      <button type="submit">Restablecer</button>
    </form>

    <a href="<?= site_url('usuario/inicio') ?>" class="link-btn">← Volver al inicio</a>
  </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById("password");
      const toggleIcon = document.querySelector(".toggle-password");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.textContent = "🤓";
      } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "😎";
      }
    }
  </script>
</body>
</html>
