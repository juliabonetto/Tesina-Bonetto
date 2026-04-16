<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      background: linear-gradient(135deg, rgb(228, 246, 255), rgb(0, 155, 64));
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
      position: relative;
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
      border-color:rgb(0, 95, 16);
      outline: none;
    }

    button {
      width: 100%;
      padding: 0.75rem;
      background-color: rgb(39, 128, 61);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: rgb(20, 110, 47);
    }

    .link-btn {
      display: block;
      margin-top: 1rem;
      color: #4a90e2;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .link-btn:hover {
      text-decoration: underline;
    }

    /* 🔹 Modal de confirmación */
    .confirm-box {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(255,255,255,0.95);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .confirm-box p {
      margin-bottom: 1rem;
      font-size: 1rem;
      color: #333;
    }

    .confirm-btns {
      display: flex;
      gap: 1rem;
      width: 100%;
      justify-content: center;
    }

    .confirm-btns button {
      width: 45%;
      padding: 0.6rem;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn-yes {
      background-color: rgb(18, 112, 30);
      color: white;
      border: none;
    }

    .btn-yes:hover {
      background-color: rgb(29, 129, 50);
    }

    .btn-no {
      background-color: #ddd;
      color: #333;
      border: none;
    }

    .btn-no:hover {
      background-color: #ccc;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Recuperar contraseña</h2>

    <form id="recuperarForm" action="<?= site_url('usuario/enviarRecuperacion') ?>" method="POST">
      <label for="email">Ingresá tu correo</label>
      <input type="email" id="email" name="email" required>
      <button type="submit">Enviar enlace</button>
    </form>

    <!--Confirmación -->
    <div id="confirmBox" class="confirm-box">
      <p id="confirmText"></p>
      <div class="confirm-btns">
        <button type="button" class="btn-yes" id="confirmYes">Sí, enviar</button>
        <button type="button" class="btn-no" id="confirmNo">No, editar</button>
      </div>
    </div>

    <a href="<?= site_url('usuario/inicio') ?>" class="link-btn">← Volver al inicio</a>
  </div>

  <script>
    const form = document.getElementById('recuperarForm');
    const emailInput = document.getElementById('email');
    const confirmBox = document.getElementById('confirmBox');
    const confirmText = document.getElementById('confirmText');
    const confirmYes = document.getElementById('confirmYes');
    const confirmNo = document.getElementById('confirmNo');

    form.addEventListener('submit', function(e) {
      e.preventDefault(); // Evita enviar el formulario
      const email = emailInput.value.trim();
      if (email === '') return;

      confirmText.textContent = `¿Segur@ que este es tu correo? "${email}"`;
      confirmBox.style.display = 'flex';
    });

    confirmYes.addEventListener('click', function() {
      confirmBox.style.display = 'none';
      form.submit(); // Envía el formulario
    });

    confirmNo.addEventListener('click', function() {
      confirmBox.style.display = 'none';
      emailInput.focus(); // Permite editar el correo
    });
  </script>
</body>
</html>
