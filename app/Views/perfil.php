<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario | EcoS-cam</title>
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
    }

    header {
      background: var(--green);
      padding: 12px 20px;
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .menu {
      position: relative;
      display: inline-block;
    }

    .menu-button {
      background: var(--ink);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.95rem;
      transition: background 0.3s;
    }

    .menu-button:hover { background: var(--green); }

    .menu-content {
      display: none;
      position: absolute;
      background: #fff;
      min-width: 200px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
      border-radius: 8px;
      z-index: 1;
    }

    .menu-content a {
      color: var(--ink);
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #eee;
      transition: background 0.3s;
    }

    .menu-content a:hover { background: var(--bg); }

    .menu:hover .menu-content { display: block; }

    .perfil-container {
      max-width: 500px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: var(--radius);
      border: 2px solid var(--green);
      box-shadow: 0 12px 30px rgba(20,36,27,0.15);
      position: relative;
    }

    .perfil-container h2 {
      font-family: var(--serif);
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 20px;
      text-align: center;
      color: var(--green);
    }

    .perfil-info p {
      margin: 12px 0;
      font-size: 1rem;
      color: var(--ink-soft);
    }

    .btn-editar {
      display: block;
      margin: 20px auto 0;
      background: var(--green);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 12px;
      cursor: pointer;
      font-weight: 600;
      font-family: var(--sans);
      transition: background 0.3s, transform 0.2s;
      text-align: center;
    }

    .btn-editar:hover {
      background: var(--ink);
      transform: translateY(-2px);
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

    .botones-acciones {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }

    .botones-acciones .btn-editar {
      margin: 0;
      flex: 1;
    }
  </style>
</head>
<body>

<header>
  <span>EcoS-cam · Perfil</span>

</header>

<div class="perfil-container">
  <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver</a>
  <h2>Mi Perfil</h2>
  <div class="perfil-info">
    <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
    <p><strong>Nombre:</strong> <?= esc($usuario['nombre'] ?? 'No especificado') ?></p>

  </div>

  <div class="botones-acciones">
    <a href="<?= site_url('usuario/cambiarPass') ?>" class="btn-editar">Editar contraseña</a>
  </div>
</div>

</body>
</html>
