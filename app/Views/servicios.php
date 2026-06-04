<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>EcoS-cam · Clasificación Inteligente de Residuos</title>
  <style>
    :root {
      --bg:rgb(243, 255, 244);
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
      line-height: 1.6;
    }

    header {
      background: var(--green);
      color: #fff;
      padding: 24px;
      text-align: center;
    }

    header h1 {
      font-family: var(--serif);
      font-size: 32px;
      font-weight: 600;
      margin-bottom: 8px;
    }

    header p {
      font-size: 16px;
      color: rgba(255, 255, 255, 0.85);
    }

    .container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 0 20px;
    }

    section {
      margin-bottom: 40px;
    }

    h2 {
      font-family: var(--serif);
      font-size: 26px;
      font-weight: 600;
      color: var(--green);
      margin-bottom: 12px;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 8px;
      color: var(--ink-soft);
    }

    p {
      font-size: 1rem;
      color: var(--ink-soft);
    }

    .volver {
      display: inline-block;
      margin-top: 30px;
      background: var(--green);
      color: #fff;
      padding: 10px 20px;
      border-radius: var(--radius);
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s, transform 0.2s;
    }

    .volver:hover {
      background: var(--ink);
      transform: translateY(-2px);
    }
  </style>
</head>
<body>

  <header>
    <h1>EcoS-cam · Tacho Inteligente</h1>
    <p>Clasificación automática de residuos con IoT y Visión por Computadora</p>
  </header>

  <div class="container">

    <section>
      <p>EcoS-cam es un sistema innovador que facilita la separación de residuos mediante un tacho inteligente. 
      Utiliza una cámara y un modelo de visión por computadora para identificar si el desecho es plástico, papel, vidrio u orgánico. 
      El ESP32 recibe la orden y abre el compartimento correcto, reduciendo errores humanos y promoviendo la sostenibilidad.</p>
    </section>

    <section>
      <h2>-> Beneficios Principales</h2>
      <ul>
        <li>Clasificación automática de residuos (plástico, papel, vidrio, orgánico).</li>
        <li>Reducción de errores humanos en espacios públicos y privados.</li>
        <li>Generación de estadísticas sobre tipo y cantidad de residuos recolectados.</li>
        <li>Gestión inteligente de capacidad: evita mezclar residuos cuando un compartimento está lleno.</li>
        <li>Valor educativo: fomenta la conciencia ambiental en escuelas y comunidades.</li>
      </ul>
    </section>

    <section>
      <h2>-> Tecnologías Utilizadas</h2>
      <ul>
        <li>ESP32 DevKit V1 como microcontrolador.</li>
        <li>Cámara OV5640 de 5MP para captura de imágenes.</li>
        <li>Servomotores para apertura de tapas.</li>
        <li>Sensores ultrasónicos HC-SR04 para medir capacidad.</li>
        <li>Servidor en Python con TensorFlow/Keras para clasificación.</li>
        <li>Base de datos MySQL para registro histórico.</li>
      </ul>
    </section>

    <section>
      <h2>-> Estadísticas y Educación</h2>
      <p>EcoS-cam no solo clasifica residuos, también genera datos útiles para medir impacto ambiental. 
      Además, incluye consejos prácticos de reciclaje y sostenibilidad, convirtiéndose en una herramienta educativa.</p>
    </section>


    <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver al inicio</a>

  </div>

</body>
</html>
