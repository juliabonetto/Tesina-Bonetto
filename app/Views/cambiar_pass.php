<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar contraseña | EcoS-cam</title>
  <style>
    :root {
      /* ===== PALETA ECO-CAM ===== */
      --green-dark: #1f4d2b;
      --green:      #2f7a3f;
      --green-light:#4ea25c;
      --green-soft: #e8f4ea;
      --bg:         #f7faf7;
      --card:       #ffffff;
      --text:       #1c2620;
      --muted:      #647069;
      --border:     #dfe8e1;
      --shadow:     0 4px 14px rgba(20, 40, 25, 0.08);
      --radius:     18px;

      /* Variables antiguas (para no romper nada) */
      --ink:       var(--text);
      --ink-soft:  var(--muted);
      --lime:      #c8f257;   /* se mantiene por si se usa */
      --serif:     'Fraunces', Georgia, serif;
      --sans:      system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg);
      font-family: var(--sans);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative; /* para el botón volver absoluto */
    }

    .card {
      max-width: 480px;
      width: 100%;
      background: var(--card);
      padding: 2rem;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      border: 2px solid var(--green);
    }

    h2 {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 1.5rem;
      text-align: center;
      color: var(--green);
    }

    label {
      display: block;
      margin-top: 12px;
      font-weight: 600;
      color: var(--muted);
    }

    input {
      width: 100%;
      padding: 0.75rem;
      margin-top: 6px;
      border-radius: 12px;
      border: 1px solid var(--border);
      background: var(--bg);
      transition: border-color 0.3s;
      font-size: 15px;
    }

    input:focus {
      border-color: var(--green);
      outline: none;
      box-shadow: 0 0 0 3px rgba(47, 122, 63, 0.15);
    }

    .btn {
      margin-top: 16px;
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

    .btn:hover {
      background: var(--green-dark);
      transform: translateY(-2px);
    }

    .msg {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 12px;
      font-size: 0.9rem;
    }

    .ok {
      background: var(--green-soft);
      color: var(--green-dark);
      font-weight: 500;
    }

    .error {
      background: rgba(255,235,238,1);
      color: rgba(198,40,40,1);
      font-weight: 500;
    }

    .volver {
      position: absolute;
      top: 20px;
      left: 20px;
      background: var(--text);
      color: #fff;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background 0.3s;
    }

    .volver:hover {
      background: var(--green);
    }
  </style>
</head>
<body>
  <div class="card">
    <h2>Cambiar mi contraseña</h2>
    <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver</a>
    <?php if(session()->getFlashdata('success')): ?>
      <div class="msg ok"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
      <div class="msg error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('usuario/actualizarPass') ?>">
      <label>Contraseña actual</label>
      <input type="password" name="actual" required>

      <label>Nueva contraseña</label>
      <input type="password" name="nueva" required minlength="6">

      <label>Confirmar nueva contraseña</label>
      <input type="password" name="confirmar" required minlength="6">

      <button type="submit" class="btn">Actualizar contraseña</button>
    </form>
  </div>
</body>
</html>