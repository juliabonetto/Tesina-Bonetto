<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoS-cam · Clasificación Inteligente de Residuos</title>
  <style>
    :root {
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
      --serif:      'Fraunces', Georgia, serif;
      --sans:       system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      background: var(--bg);
      font-family: var(--sans);
      color: var(--text);
      line-height: 1.6;
    }

    header {
      background: var(--green-dark);
      color: #fff;
      padding: 18px 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 12px;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.3rem;
      font-weight: 600;
      letter-spacing: -0.5px;
    }
    .brand span {
      font-family: var(--serif);
    }

    .menu {
      position: relative;
      display: inline-block;
    }
    .menu-button {
      background: var(--text);
      color: #fff;
      border: none;
      padding: 8px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 0.9rem;
      transition: background 0.3s;
    }
    .menu-button:hover {
      background: var(--green);
    }
    .menu-content {
      display: none;
      position: absolute;
      background: var(--card);
      min-width: 180px;
      box-shadow: var(--shadow);
      border-radius: 8px;
      z-index: 10;
      right: 0;
    }
    .menu-content a {
      color: var(--text);
      padding: 10px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid var(--border);
      transition: background 0.2s;
    }
    .menu-content a:hover {
      background: var(--bg);
    }
    .menu:hover .menu-content {
      display: block;
    }

    .container {
      max-width: 900px;
      margin: 30px auto;
      padding: 0 20px;
    }

    .welcome-block {
      background: linear-gradient(135deg, #e6f5e8, #f7fcf8);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 40px 50px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 30px;
      box-shadow: var(--shadow);
      margin-bottom: 40px;
    }
    .welcome-text h1 {
      font-size: 2.2rem;
      font-family: var(--serif);
      font-weight: 600;
      margin-bottom: 8px;
      color: var(--green-dark);
    }
    .welcome-text h1 .highlight {
      color: var(--green);
    }
    .welcome-text p {
      color: var(--muted);
      max-width: 600px;
    }
    .hero-badge {
      background: var(--card);
      border: 1px solid var(--border);
      padding: 12px 24px;
      border-radius: 16px;
      font-weight: 600;
      color: var(--green-dark);
      white-space: nowrap;
    }

    /* ===== SECCIONES APILADAS ===== */
    .section-block {
      background: var(--card);
      border-radius: var(--radius);
      padding: 30px 35px;
      border: 1px solid var(--border);
      box-shadow: var(--shadow);
      margin-bottom: 30px;
      transition: transform 0.2s;
    }
    .section-block:hover {
      transform: translateY(-2px);
    }
    .section-block h2 {
      font-family: var(--serif);
      font-size: 1.8rem;
      color: var(--green-dark);
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .section-block ul {
      list-style: none;
      padding: 0;
    }
    .section-block ul li {
      padding: 8px 0;
      color: var(--muted);
      display: flex;
      align-items: flex-start;
      gap: 10px;
      border-bottom: 1px solid var(--border);
    }
    .section-block ul li:last-child {
      border-bottom: none;
    }
    .section-block ul li::before {
      content: "";
      font-size: 1.2rem;
    }
    .section-block p {
      color: var(--muted);
      font-size: 1rem;
    }

    .btn-volver {
      display: inline-block;
      background: linear-gradient(135deg, var(--green), var(--green-light));
      color: #fff;
      padding: 14px 28px;
      border-radius: 14px;
      text-decoration: none;
      font-weight: 600;
      box-shadow: var(--shadow);
      transition: transform 0.25s, background 0.25s;
      margin-top: 10px;
    }
    .btn-volver:hover {
      transform: translateY(-2px);
      background: linear-gradient(135deg, var(--green-dark), var(--green));
    }

    .footer {
      text-align: center;
      color: var(--muted);
      font-size: 0.9rem;
      border-top: 1px solid var(--border);
      padding-top: 24px;
      margin-top: 20px;
    }

    @media (max-width: 768px) {
      .welcome-block {
        flex-direction: column;
        align-items: flex-start;
        padding: 30px;
      }
      .welcome-text h1 {
        font-size: 1.8rem;
      }
      .hero-badge {
        white-space: normal;
        align-self: flex-start;
      }
      .section-block {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

<header>
  <div class="brand">
    <span>♻ EcoS-cam</span>
  </div>
  <div class="menu">
    <button class="menu-button">☰ Menú</button>
    <div class="menu-content">
      <a href="<?= site_url('usuario/principal') ?>">🏠 Inicio</a>
      <a href="<?= site_url('mis-tachos') ?>">🗑 Mis Tachos</a>
      <a href="<?= site_url('usuario/perfil') ?>">👤 Perfil</a>
      <a href="<?= site_url('usuario/cerrarSesion') ?>">🔒 Cerrar sesión</a>
    </div>
  </div>
</header>

<div class="container">

  <div class="welcome-block">
    <div class="welcome-text">
      <h1>
        <span class="highlight">EcoS-cam</span> · Tacho Inteligente
      </h1>
      <p>
        Clasificación automática de residuos con IoT y Visión por Computadora.
        Conocé cómo funciona y todos sus beneficios.
      </p>
    </div>
    <div class="hero-badge">
       Innovación sostenible
    </div>
  </div>

  <!-- Sección 1: Beneficios -->
  <div class="section-block">
    <h2> Beneficios Principales</h2>
    <ul>
      <li>Clasificación automática de residuos (plástico, papel, vidrio, orgánico).</li>
      <li>Reducción de errores humanos en espacios públicos y privados.</li>
      <li>Generación de estadísticas sobre tipo y cantidad de residuos recolectados.</li>
      <li>Gestión inteligente de capacidad: evita mezclar residuos cuando un compartimento está lleno.</li>
      <li>Valor educativo: fomenta la conciencia ambiental en escuelas y comunidades.</li>
    </ul>
  </div>

  <!-- Sección 2: Tecnologías -->
  <div class="section-block">
    <h2> Tecnologías Utilizadas</h2>
    <ul>
      <li>ESP32 DevKit V1 como microcontrolador.</li>
      <li>Cámara OV5640 de 5MP para captura de imágenes.</li>
      <li>Servomotores para apertura de tapas.</li>
      <li>Sensores ultrasónicos HC-SR04 para medir capacidad.</li>
      <li>Servidor en Python con TensorFlow/Keras para clasificación.</li>
      <li>Base de datos MySQL para registro histórico.</li>
    </ul>
  </div>

  <!-- Sección 3: Estadísticas y Educación -->
  <div class="section-block">
    <h2> Estadísticas y Educación</h2>
    <p>
      EcoS-cam no solo clasifica residuos, también genera datos útiles para medir impacto ambiental.
      Incluye consejos prácticos de reciclaje y sostenibilidad, convirtiéndose en una herramienta educativa
      para escuelas y comunidades. Visualizá estadísticas en tiempo real desde la plataforma web.
    </p>
  </div>

  <a href="<?= site_url('usuario/principal') ?>" class="btn-volver">
    ← Volver al inicio
  </a>

  <div class="footer">
    EcoS-cam © 2026 · Todos los derechos reservados
  </div>

</div>

</body>
</html>