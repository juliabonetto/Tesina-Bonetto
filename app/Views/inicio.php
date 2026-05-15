<?php

$tiposResiduos = [
  ['nombre' => 'Plástico', 'desc' => 'Botellas y envases plásticos.', 'icon' => '♺'],
  ['nombre' => 'Papel',    'desc' => 'Periódicos, revistas y hojas.', 'icon' => '📄'],
  ['nombre' => 'Vidrio',   'desc' => 'Botellas y frascos de vidrio.', 'icon' => '🍾'],
  ['nombre' => 'Orgánico', 'desc' => 'Restos de comida y residuos compostables.', 'icon' => '🍃'],
];


$pasos = [
  ['n' => '01', 't' => 'Mostrar residuo',     'd' => 'El usuario presenta el residuo frente a la cámara del tacho.'],
  ['n' => '02', 't' => 'Captura y análisis',  'd' => 'La cámara toma la imagen y el sistema analiza el material.'],
  ['n' => '03', 't' => 'Verificación',        'd' => 'Si hay dudas, el sistema consulta el tipo de residuo.'],
  ['n' => '04', 't' => 'Apertura automática', 'd' => 'Se abre el compartimento correspondiente.'],
  ['n' => '05', 't' => 'Registro',            'd' => 'Se guarda la información del residuo en la base de datos.'],
  ['n' => '06', 't' => 'Estadísticas',        'd' => 'Se generan datos en tiempo real del uso del sistema.'],
  ['n' => '07', 't' => 'Advertencia',         'd' => 'Se detecta si el tacho está lleno y avisa al usuario.'],
  ['n' => '08', 't' => '¡Listo!',             'd' => 'Proceso de clasificación completado. Tu residuo fue separado correctamente. ♻️'],
];


$consejos = [
  ['t' => 'Recicla en casa',     'd' => 'Separá tus desechos orgánicos de los reciclables.'],
  ['t' => 'Sostenibilidad diaria','d' => 'Usá productos reutilizables siempre que puedas.'],
  ['t' => 'Separación correcta', 'd' => 'Clasificá según el tipo de material.'],
  ['t' => 'Cero desperdicio',    'd' => 'Reducí al máximo el uso de plásticos.'],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoScam · Reciclaje inteligente</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/estilos.css') ?>">

</head>
<body>

  <!-- NAVBAR -->
  <header class="nav">
    <a href="#" class="logo">
      <span class="logo-mark">◐</span>
      <span>Eco<strong>S-cam</strong></span>
    </a>
    <nav class="nav-links">
      <a href="#inicio">Inicio</a>
      <a href="#funciona">¿Cómo funciona?</a>
      <a href="#stats">Estadísticas</a>
      <a href="#tienda">Tienda</a>
    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">Contacto</a>
    </nav>
     <a href="<?= site_url('usuario/login') ?>" class="nav-cta">Ingresar →</a>
  </header>

  <!-- HERO -->
  <section class="hero" id="inicio">
    <div class="hero-grid">
      <div class="hero-text">
        <span class="eyebrow">— Proyecto de reciclaje inteligente</span>
        <h1>
          Tirá el residuo.<br>
          <em>Nosotros lo</em><br>
          <span class="hl">clasificamos.</span>
        </h1>
        <p class="lead">
          EcoS-cam es un tacho inteligente que reconoce plástico, papel, vidrio y orgánico
          con visión por computadora. Reciclar nunca fue tan simple.
        </p>
      <div class="hero-actions">
  <a href="<?= site_url('usuario/login') ?>" class="btn btn-primary">Inicio de sesión</a>
  <a href="<?= site_url('usuario/registro') ?>" class="btn btn-ghost">Crear cuenta</a>
</div>

        <div class="hero-meta">
          <div><strong>+4</strong><span>materiales reconocidos</span></div>
          <div><strong>98%</strong><span>precisión de clasificación</span></div>
          <div><strong>24/7</strong><span>funcionamiento autónomo</span></div>
        </div>
      </div>

      <div class="hero-visual">
        <div class="blob"></div>
        <div class="card-float card-float-1">
          <span>♺</span>
          <p>Plástico detectado</p>
        </div>
        <div class="card-float card-float-2">
          <span>📊</span>
          <p>Registro guardado</p>
        </div>
        <div class="device">
          <div class="device-screen">
            <div class="scan-line"></div>
            <div class="device-label">SCAN · 02</div>
            <div class="device-title">Analizando<br>material…</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- TIPOS DE RESIDUOS -->
  <section class="section section-light">
    <div class="section-head">
      <span class="eyebrow">01 · Materiales</span>
      <h2>Tipos de residuos <em>reconocidos</em></h2>
    </div>
    <div class="materials">
      <?php foreach ($tiposResiduos as $i => $t): ?>
        <article class="material" style="--i: <?= $i ?>">
          <div class="material-icon"><?= $t['icon'] ?></div>
          <h3><?= $t['nombre'] ?></h3>
          <p><?= $t['desc'] ?></p>
          <span class="material-num">0<?= $i+1 ?></span>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ¿CÓMO FUNCIONA? -->
  <section class="section section-dark" id="funciona">
    <div class="section-head">
      <span class="eyebrow eyebrow-light">02 · Proceso</span>
      <h2 class="light">¿Cómo <em>funciona</em>?</h2>
      <p class="section-sub">Desde que mostrás el residuo hasta que sabés dónde tirarlo, así trabaja EcoS-cam para lograr un reciclaje eficiente.</p>
    </div>
    <div class="steps">
      <?php foreach ($pasos as $p): ?>
        <article class="step">
          <span class="step-num"><?= $p['n'] ?></span>
          <h3><?= $p['t'] ?></h3>
          <p><?= $p['d'] ?></p>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- CONSEJOS -->
  <section class="section section-light" id="consejos">
    <div class="section-head">
      <span class="eyebrow">03 · Educación ambiental</span>
      <h2>Consejos para una <em>vida sostenible</em></h2>
    </div>
    <div class="tips">
      <?php foreach ($consejos as $c): ?>
        <article class="tip">
          <h3><?= $c['t'] ?></h3>
          <p><?= $c['d'] ?></p>
          <span class="tip-arrow">→</span>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="footer-top">
      <h2>Reciclar es el primer paso.<br><em>Empezá hoy.</em></h2>
      <a href="#registro" class="btn btn-primary">Comprar ahora →</a>
    </div>
    <div class="footer-bot">
      <span>© <?= date('Y') ?> EcoS-cam — Proyecto de reciclaje inteligente</span>
      <span>Tesina Bonetto - Restivo</span>
    </div>
  </footer>

</body>
</html>