<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Usuario | EcoS-cam</title>
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
    }

    /* ===== HEADER (ahora con verde oscuro) ===== */
    header {
      background: var(--green-dark);
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
      background: var(--text);
      color: #fff;
      border: none;
      padding: 10px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 0.95rem;
      transition: background 0.3s;
    }
    .menu-button:hover {
      background: var(--green);
    }

    .menu-content {
      display: none;
      position: absolute;
      background: var(--card);
      min-width: 200px;
      box-shadow: var(--shadow);
      border-radius: 8px;
      z-index: 1;
    }
    .menu-content a {
      color: var(--text);
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid var(--border);
      transition: background 0.3s;
    }
    .menu-content a:hover {
      background: var(--bg);
    }
    .menu:hover .menu-content {
      display: block;
    }

    /* ===== CONTENEDOR PRINCIPAL ===== */
    .perfil-container {
      max-width: 500px;
      margin: 50px auto;
      background: var(--card);
      padding: 30px;
      border-radius: var(--radius);
      border: 2px solid var(--green);
      box-shadow: var(--shadow);
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
      color: var(--muted);
    }

    /* ===== BOTONES ===== */
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
      text-decoration: none;
    }
    .btn-editar:hover {
      background: var(--green-dark);
      transform: translateY(-2px);
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

    /* ===== FORMULARIOS (dentro del perfil) ===== */
    .form-group {
      margin-bottom: 18px;
    }
    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 600;
      color: var(--muted);
    }
    .form-group input,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 1px solid var(--border);
      border-radius: 10px;
      font-size: 1rem;
      background: var(--bg);
      transition: border-color 0.2s;
    }
    .form-group input:focus,
    .form-group select:focus {
      outline: none;
      border-color: var(--green);
      box-shadow: 0 0 0 3px rgba(47, 122, 63, 0.15);
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
    <input type="hidden" name="id" value="<?= esc($usuario['id']) ?>">

    <div class="form-group">
      <label>Nombre</label>
      <input type="text"
             name="nombre"
             value="<?= esc($usuario['nombre']) ?>"
             required>
    </div>

    <div class="form-group">
      <label>Apellido</label>
      <input type="text"
             name="apellido"
             value="<?= esc($usuario['apellido']) ?>"
             required>
    </div>

    <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
    <p><strong>Rol:</strong> <?= esc($usuario['rol']) ?></p>
    <p><strong>DNI:</strong> <?= esc($usuario['dni']) ?></p>
  </div>
  <div class="botones-acciones">
    <a href="<?= site_url('usuario/cambiarPass') ?>" class="btn-editar">Editar contraseña</a>
  </div>
</div>

</body>
</html>