<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Servicios Oftalmológicos</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Montserrat', sans-serif;
      background-color: #f4f7ff;
      color: #333;
    }

    header {
      background-color: #2a56b4;
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
      color: #1976d2;
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
      background-color: #1976d2;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
    }

    .volver:hover {
      background-color: #145cb0;
    }
  </style>
</head>
<body>

  <header>
    <h1>Servicios Oftalmológicos</h1>
  </header>

  <div class="container">

    <section>
      <p>Ofrecemos atención integral y personalizada para el cuidado de la salud visual. Nuestro equipo profesional brinda diagnósticos precisos, tratamientos efectivos y acompañamiento continuo, adaptado a cada paciente.</p>
    </section>

    <section>
      <h2>👁️ Evaluación Clínica Integral</h2>
      <ul>
        <li>Examen de agudeza visual</li>
        <li>Medición de presión intraocular</li>
        <li>Evaluación del fondo de ojo</li>
        <li>Revisión de motilidad ocular y reflejos pupilares</li>
      </ul>
    </section>

    <section>
      <h2>🧪 Estudios Complementarios</h2>
      <ul>
        <li>Campimetría computarizada</li>
        <li>Tomografía de coherencia óptica (OCT)</li>
        <li>Topografía corneal</li>
        <li>Retinografía digital</li>
      </ul>
    </section>

    <section>
      <h2>👨‍⚕️ Subespecialidades</h2>
      <ul>
        <li>Oftalmología pediátrica</li>
        <li>Retina y vítreo</li>
        <li>Córnea y superficie ocular</li>
        <li>Cirugía refractiva y láser</li>
        <li>Estrabismo y motilidad ocular</li>
      </ul>
    </section>

    <section>
      <h2>🔍 Seguimiento y Control</h2>
      <p>Planes personalizados para enfermedades crónicas y postquirúrgicos, garantizando una evolución segura y controlada.</p>
    </section>

    <section>
      <h2>🧑‍💻 Asesoramiento Prequirúrgico</h2>
      <p>Orientación clara sobre opciones quirúrgicas, riesgos y beneficios, para tomar decisiones informadas.</p>
    </section>

    <section>
      <h2>🕶️ Lentes y Ayudas Visuales</h2>
      <ul>
        <li>Lentes de contacto convencionales y especiales</li>
        <li>Anteojos recetados</li>
        <li>Ayudas ópticas para baja visión</li>
      </ul>
    </section>

    <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver al inicio</a>

  </div>

</body>
</html>
