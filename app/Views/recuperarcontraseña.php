<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Recuperar contraseña | EcoScam</title>
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
      position: relative;
    }

    h2 {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 1.5rem;
      color: var(--green);
    }

    label {
      display: block;
      text-align: left;
      margin-bottom: 0.5rem;
      color: var(--ink-soft);
      font-size: 0.9rem;
      font-weight: 500;
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

    /* Modal de confirmación */
    .confirm-box {
      position: absolute;
      inset: 0;
      background: rgba(255,255,255,0.95);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      border-radius: var(--radius);
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(20,36,27,0.2);
    }

    .confirm-box p {
      margin-bottom: 1rem;
      font-size: 1rem;
      color: var(--ink);
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
      border-radius: 12px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s;
      font-family: var(--sans);
    }

    .btn-yes {
      background: var(--green);
      color: #fff;
      border: none;
    }

    .btn-yes:hover { background: var(--ink); }

    .btn-no {
      background: #ddd;
      color: var(--ink);
      border: none;
    }

    .btn-no:hover { background: #ccc; }
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

    <!-- Confirmación -->
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
      e.preventDefault();
      const email = emailInput.value.trim();
      if (email === '') return;

      confirmText.textContent = `¿Segur@ que este es tu correo? "${email}"`;
      confirmBox.style.display = 'flex';
    });

    confirmYes.addEventListener('click', function() {
      confirmBox.style.display = 'none';
      form.submit();
    });

    confirmNo.addEventListener('click', function() {
      confirmBox.style.display = 'none';
      emailInput.focus();
    });
  </script>
</body>
</html>
