<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>EcoScam</title>

  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <style>
    body {
      margin: 0;
      font-family: 'Lato', sans-serif;
      background-color: #f6f8fc;
      color: #333;
      scroll-behavior: smooth;
    }

    /* HEADER */
    header {
      background: linear-gradient(90deg,rgb(91, 204, 142),rgb(10, 121, 10));
      color: white;
      padding: 15px 30px;
      box-shadow: 0 2px 10px rgb(0, 0, 0);
    }

    .encabezado {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .titulo-header {
      flex: 1;
      text-align: center;
      font-size: 1.9rem;
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      font-weight: 700;
    }

    .auth {
      display: flex;
      gap: 10px;
    }

    .auth a {
      color: white;
      text-decoration: none;
      background-color: rgba(255,255,255,0.2);
      padding: 8px 14px;
      border-radius: 6px;
      transition: background-color 0.3s ease;
      font-weight: 600;
    }

    .auth a:hover {
      background-color: rgba(255,255,255,0.4);
    }

    /* MENÚ DESPLEGABLE */
    .menu {
      position: relative;
      display: inline-block;
    }

    .menu-button {
      background-color: #ffffff;
      color:rgb(30, 175, 90);
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      transition: all 0.3s ease;
    }

    .menu-button:hover {
      background-color: #edf2ff;
      transform: translateY(-2px);
    }

    .menu-content {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #ffffff;
      border-radius: 0 0 10px 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
      overflow: hidden;
      min-width: 220px;
      z-index: 1000;
    }

    .menu-content a {
      display: block;
      padding: 14px 20px;
      text-decoration: none;
      color:rgb(2, 51, 10);
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .menu-content a:hover {
      background-color: #eaf1fc;
    }

    .menu:hover .menu-content {
      display: block;
    }

    /* BOTONES SUPERIORES */
    .nav-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      background-color:rgb(202, 255, 204);
      padding: 12px;
      box-shadow: 0 1px 5px rgba(0,0,0,0.05);
    }

    .nav-buttons button {
      padding: 10px 22px;
      border: none;
      background-color: white;
      color:rgb(42, 180, 42);
      cursor: pointer;
      font-family: 'Montserrat', sans-serif;
      font-weight: 600;
      font-size: 1rem;
      border-radius: 6px;
      transition: all 0.3s ease;
      box-shadow: 0 2px 5px rgba(0,0,0,0.08);
    }

    .nav-buttons button:hover {
      background-color:rgb(225, 255, 223);
      transform: translateY(-2px);
    }

    /* SECCIONES */
    section {
      padding: 60px 80px;
      max-width: 1100px;
      margin: 0 auto;
    }

    h2 {
      font-family: 'Montserrat', sans-serif;
      color:rgb(0, 124, 6);
      border-left: 6px solidrgb(0, 187, 40);
      padding-left: 10px;
      margin-bottom: 25px;
    }

    .info-section {
      background: white;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      border-radius: 16px;
      padding: 40px;
      display: flex;
      align-items: flex-start;
      gap: 40px;
      opacity: 0;
      transform: translateY(30px);
      transition: all 1s ease;
    }

    .info-section.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .info-section p {
      font-size: 1.1rem;
      line-height: 1.8;
    }

    .imagen-frente {
      height: 320px;
      border-radius: 12px;
      object-fit: cover;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    iframe {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    /* NUEVA SECCIÓN SERVICIOS */
    .servicios {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 25px;
      margin-top: 30px;
    }

    .servicio {
      background: white;
      border-radius: 12px;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      padding: 25px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      opacity: 0;
      transform: translateY(40px);
    }

    .servicio.visible {
      opacity: 1;
      transform: translateY(0);
    }

    .servicio:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .servicio i {
      font-size: 40px;
      color:rgb(42, 180, 95);
      margin-bottom: 15px;
    }

    footer {
      background-color:rgb(23, 133, 78);
      color: white;
      text-align: center;
      padding: 20px;
      font-size: 0.95rem;
      margin-top: 60px;
    }

    a {
      color:rgb(3, 94, 44);
      text-decoration: none;
      font-weight: 600;
    }
    a:hover { text-decoration: underline; }
  </style>
</head>

<body>
  <header>
    <div class="encabezado">
      <div class="menu">
        <button class="menu-button">☰ Menú</button>
        <div class="menu-content">
          <a href="<?= site_url('usuario/perfil') ?>">👤 Perfil</a>
          <a href="<?= site_url('') ?>">📅 info</a>
          <a href="<?= site_url('usuario/servicios') ?>">🛠️ Servicios</a>
          <a href="<?= site_url('usuario/politica_privacidad') ?>">📄 Políticas de privacidad</a>
        </div>
      </div>

      <h1 class="titulo-header">EcoScam</h1>

      <div class="auth">
        <?php if (session()->has('usuario')): ?>
          <a href="<?= site_url('usuario/cerrarSesion') ?>">Cerrar sesión</a>
        <?php else: ?>
          <a href="<?= site_url('usuario/registro') ?>">Registrarse</a>
          <a href="<?= site_url('usuario/login') ?>">Iniciar sesión</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <div class="nav-buttons">
    <button onclick="scrollToSection('ubicacion')">Ubicación</button>
    <button onclick="scrollToSection('contacto')">Contacto</button>
    <button onclick="location.href='<?= site_url('') ?>'">inf</button>
    <button onclick="location.href='<?= site_url('') ?>'">inf</button>

    <?php if (session()->has('usuario') && session()->get('usuario')['rol'] === 'admin'): ?>
      <button onclick="location.href='<?= site_url('admin/usuario') ?>'">Gestionar Usuarios</button>
    <?php endif; ?>
  </div>

  <section id="informacion">
    <h2>Información</h2>
    <div class="info-section fade">
      <div style="flex:1;">
        <p>
          Bienvenido a <strong>EcoScam</strong>,info
          <br><br>
    info
          <br><br>
        
        </p>
      </div>
      <div>
        <img src="<?= base_url('img/') ?>" class="imagen-frente" alt="">
      </div>
    </div>
  </section>

  <section id="servicios">
    <h2>Servicios </h2>
    <div class="servicios">
      <div class="servicio"><i class="bi bi-person-hearts"></i><h3>.</h3><p>info.</p></div>
      <div class="servicio"><i class="bi bi-lightbulb"></i><h3>.</h3><p>info.</p></div>
      <div class="servicio"><i class="bi bi-emoji-smile"></i><h3>.</h3><p>info.</p></div>
    </div>
  </section>

  <section id="ubicacion">
    <h2>Ubicación</h2>
    <p>Encontranos en <strong>Libertad 450, Río Tercero, Córdoba</strong><br> Lunes a Viernes: 9–18hs · Sábados y feriados: 10–14hs</p>
    <iframe src="https://www.google.com/maps/embed?...tuMapa..." width="400" height="300" loading="lazy"></iframe>
  </section>


  <section id="contacto">
  <h2>Contacto</h2>
  <p>
    Tel: 351-1234567 | Email: 
    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">
EcoScam2026@gmail.com
    </a>
  </p>
</section>

  <footer>
    © 2026 EcoScam · Proyecto de reciclaje inteligente
  </footer>

  <script>
    function scrollToSection(id) {
      const section = document.getElementById(id);
      if (section) section.scrollIntoView({ behavior: 'smooth' });
    }

    // Animación en scroll
    const faders = document.querySelectorAll('.info-section, .servicio');
    function mostrarElementos() {
      const trigger = window.innerHeight * 0.85;
      faders.forEach(el => {
        const top = el.getBoundingClientRect().top;
        if (top < trigger) el.classList.add('visible');
      });
    }
    window.addEventListener('scroll', mostrarElementos);
    mostrarElementos();
  </script>
</body>
</html>