<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Cambiar contraseña | EcoScam</title>
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

    .card {
      max-width: 480px;
      width: 100%;
      background: #fff;
      padding: 2rem;
      border-radius: var(--radius);
      box-shadow: 0 12px 30px rgba(20,36,27,0.15);
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
      color: var(--ink-soft);
    }

    input {
      width: 100%;
      padding: 0.75rem;
      margin-top: 6px;
      border-radius: 12px;
      border: 1px solid rgba(20,36,27,0.2);
      background: rgba(244,241,234,0.6);
      transition: border-color 0.3s;
      font-size: 15px;
    }

    input:focus {
      border-color: var(--green);
      outline: none;
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
      background: var(--ink);
      transform: translateY(-2px);
    }

    .msg {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 12px;
      font-size: 0.9rem;
    }

    .ok {
      background: rgba(232,245,233,1);
      color: var(--green);
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
      background: var(--ink);
      color: #fff;
      padding: 8px 16px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background 0.3s;
    }

    .volver:hover { background: var(--green); }
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

