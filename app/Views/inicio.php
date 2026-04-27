<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcoScam</title>
<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f8fff9;
    color: #094b2c;
  }

  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: #ffffffee;
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 10;
  }
  .logo {
    font-size: 26px;
    font-weight: bold;
    color: #2caa6b;
  }
  nav a {
    margin: 0 12px;
    text-decoration: none;
    color: #308959;
    font-weight: 500;
    transition: 0.3s;
  }
  nav a:hover { color: #119146; }

  .main-content {
    text-align: center;
    padding: 100px 20px;
    background: linear-gradient(135deg, #7cdda4, #95d5b2);
  }
  .main-content h1 {
    font-size: 44px;
    margin-bottom: 20px;
    color: #074707;
  }
  .main-content p {
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto 40px;
    color: #003d2e;
  }
  .buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
  }
  .buttons a {
    padding: 12px 24px;
    text-decoration: none;
    font-size: 16px;
    border-radius: 6px;
    background-color: #119146;
    color: white;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  }
  .buttons a:hover {
    background-color: #30ad3a;
    transform: translateY(-2px);
  }

  section {
    padding: 70px 20px;
    text-align: center;
  }
  section h2 {
    font-size: 30px;
    margin-bottom: 25px;
    color: #074707;
  }

  /* Colores personalizados por sección */
  section:nth-of-type(1) {
    background: linear-gradient(135deg, #a1e9ab, #b0edb9);
  }
  section:nth-of-type(2) {
    background: linear-gradient(135deg, #b0edb9, #caedcf);
  }
  section:nth-of-type(3) {
    background: linear-gradient(135deg, #caedcf, #ffffff);
  }

  .cards {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    max-width: 1100px;
    margin: 0 auto;
  }
  .card {
    background: #ffffffee;
    backdrop-filter: blur(6px);
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.08);
    width: 250px;
    transition: 0.3s;
  }
  .card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
  }
  .card h3 { color: #2caa6b; margin-bottom: 10px; }
  .card p { font-size: 14px; color: #333; }

  footer {
    background: #2caa6b;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: 40px;
  }
</style>
</head>
<body>

<header>
  <div class="logo">EcoScam</div>
  <nav>
    <a href="#">Inicio</a>
    <a href="#">¿Cómo Funciona?</a>
    <a href="#">Estadísticas</a>
    <a href="#">Tienda</a>
    <a href="mailto:optiglass.clinica@gmail.com">Contacto</a>
  </nav>
</header>

<div class="main-content">
  <h1>Bienvenido a EcoScam 🌱</h1>
  <p>
    El tacho inteligente que clasifica automáticamente los residuos para un reciclaje eficiente y sencillo.
    Separá plástico, papel y vidrio con tecnología avanzada y ayudá a construir un futuro sostenible.
  </p>
  <div class="buttons">
    <a href="<?= site_url('usuario/login') ?>">Inicio de Sesión</a>
    <a href="<?= site_url('usuario/registro') ?>">Registro</a>
  </div>
</div>

<section>
  <h2>Tipos de Residuos Reconocidos</h2>
  <div class="cards">
    <div class="card"><h3>Plástico</h3><p>Botellas y envases plásticos.</p></div>
    <div class="card"><h3>Papel</h3><p>Periódicos, revistas y hojas.</p></div>
    <div class="card"><h3>Vidrio</h3><p>Botellas y frascos de vidrio.</p></div>
  </div>
</section>

<section>
  <h2>¿Cómo Funciona?</h2>
  <p style="max-width: 700px; margin: 0 auto 40px; color:#003d2e;">
    Desde que mostrás el residuo hasta que sabés dónde tirarlo, así trabaja EcoScam para lograr un reciclaje eficiente.
  </p>
  <div class="cards">
    <div class="card"><h3>01. Mostrar residuo</h3><p>El usuario presenta el residuo frente a la cámara del tacho.</p></div>
    <div class="card"><h3>02. Captura y análisis</h3><p>La cámara toma la imagen y el sistema analiza el material.</p></div>
    <div class="card"><h3>03. Verificación</h3><p>Si hay dudas, el sistema consulta el tipo de residuo.</p></div>
    <div class="card"><h3>04. Apertura automática</h3><p>Se abre el compartimento correspondiente.</p></div>
    <div class="card"><h3>05. Registro</h3><p>Se guarda la información del residuo en la base de datos.</p></div>
    <div class="card"><h3>06. Estadísticas</h3><p>Se generan datos en tiempo real del uso del sistema.</p></div>
    <div class="card"><h3>07. Advertencia de capacidad</h3><p>Se detecta si el tacho está lleno.</p></div>
  </div>
</section>

<section>
  <h2>Consejos y Educación Ambiental</h2>
  <div class="cards">
    <div class="card"><h3>Recicla en Casa</h3><p>Separá tus desechos orgánicos.</p></div>
    <div class="card"><h3>Sostenibilidad Diaria</h3><p>Usá productos reutilizables.</p></div>
    <div class="card"><h3>Separación Correcta</h3><p>Clasificá según el tipo de material.</p></div>
    <div class="card"><h3>Cero Desperdicio</h3><p>Reducí el uso de plásticos.</p></div>
  </div>
</section>

<footer>
  <p>© 2026 EcoScam - Proyecto de reciclaje inteligente</p>
</footer>

</body>
</html>