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
      background: linear-gradient(to bottom right, #dfffe3, #52be7c);
      color: #094b2c;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background-color: #ffffffcc;
      box-shadow: 0 2px 4px rgba(4, 49, 8, 0.3);
      position: sticky;
      top: 0;
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color: #2caa6b;
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color: #308959;
      font-weight: 500;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .main-content {
      text-align: center;
      padding: 80px 20px;
    }

    .main-content h1 {
      font-size: 42px;
      margin-bottom: 20px;
      color: #074707;
    }

    .main-content p {
      font-size: 18px;
      max-width: 700px;
      margin: 0 auto 40px;
      color: #002c47;
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
      transition: background-color 0.3s ease;
    }

    .buttons a:hover {
      background-color: #30ad3a;
    }

    /* Secciones */
    section {
      padding: 60px 20px;
      text-align: center;
    }

    section h2 {
      font-size: 28px;
      margin-bottom: 20px;
      color: #074707;
    }

    .cards {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 250px;
    }

    .card h3 {
      margin-bottom: 10px;
      color: #2caa6b;
    }

    .card p {
      font-size: 14px;
      color: #333;
    }

    footer {
      background: #094b2c;
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
      <div class="card">
        <h3>Plástico</h3>
        <p>Botellas y envases plásticos.</p>
      </div>
      <div class="card">
        <h3>Papel</h3>
        <p>Periódicos, revistas y hojas.</p>
      </div>
      <div class="card">
        <h3>Vidrio</h3>
        <p>Botellas y frascos de vidrio.</p>
      </div>
    </div>
  </section>

  <section>
    <h2>Consejos y Educación Ambiental</h2>
    <div class="cards">
      <div class="card">
        <h3>Recicla en Casa</h3>
        <p>Separá tus desechos orgánicos.</p>
      </div>
      <div class="card">
        <h3>Sostenibilidad Diaria</h3>
        <p>Usá productos reutilizables.</p>
      </div>
      <div class="card">
        <h3>Separación Correcta</h3>
        <p>Clasificá según el tipo de material.</p>
      </div>
      <div class="card">
        <h3>Cero Desperdicio</h3>
        <p>Reducí el uso de plásticos.</p>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2026 EcoScam - Proyecto de reciclaje inteligente</p>
  </footer>

</body>
</html>
