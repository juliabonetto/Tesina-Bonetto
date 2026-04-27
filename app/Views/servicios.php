<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>EcoScam - Clasificación Inteligente de Residuos</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #f4f7ff;
      color: #333;
    }

    header {
      background-color: #2a9d8f;
      color: white;
      padding: 20px;
      text-align: center;
    }

    h1 {
      margin: 0;
      font-size: 2rem;
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
      color: #2a9d8f;
      margin-bottom: 10px;
    }

    ul {
      padding-left: 20px;
    }

    li {
      margin-bottom: 8px;
    }

    p {
      line-height: 1.6;
      font-size: 1.1rem;
    }

    .volver {
      display: inline-block;
      margin-top: 30px;
      background-color: #2a9d8f;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .volver:hover {
      background-color: #21867a;
    }
  </style>
</head>
<body>

  <header>
    <h1>EcoScam - Tacho Inteligente</h1>
    <p>Clasificación automática de residuos con IoT y Visión por Computadora</p>
  </header>

  <div class="container">

    <section>
      <p>EcoScam es un sistema innovador que facilita la separación de residuos mediante un tacho inteligente. 
      Utiliza una cámara y un modelo de visión por computadora para identificar si el desecho es plástico, papel, vidrio u orgánico. 
      El ESP32 recibe la orden y abre el compartimento correcto, reduciendo errores humanos y promoviendo la sostenibilidad.</p>
    </section>

    <section>
      <h2>♻️ Beneficios Principales</h2>
      <ul>
        <li>Clasificación automática de residuos (plástico, papel, vidrio, orgánico).</li>
        <li>Reducción de errores humanos en espacios públicos y privados.</li>
        <li>Generación de estadísticas sobre tipo y cantidad de residuos recolectados.</li>
        <li>Gestión inteligente de capacidad: evita mezclar residuos cuando un compartimento está lleno.</li>
        <li>Valor educativo: fomenta la conciencia ambiental en escuelas y comunidades.</li>
      </ul>
    </section>

    <section>
      <h2>⚙️ Tecnologías Utilizadas</h2>
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
      <h2>📊 Estadísticas y Educación</h2>
      <p>EcoScam no solo clasifica residuos, también genera datos útiles para medir impacto ambiental. 
      Además, incluye consejos prácticos de reciclaje y sostenibilidad, convirtiéndose en una herramienta educativa.</p>
    </section>

    <section>
      <h2>🛒 Opción de Compra</h2>
      <p>¿Quieres implementar EcoScam en tu institución o empresa? Haz tu pedido en línea:</p>
      <a href="#comprar" class="volver">Comprar Ahora</a>
    </section>

    <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver al inicio</a>

  </div>

</body>
</html>
