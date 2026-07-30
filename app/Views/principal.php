<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EcoS-cam principal</title>

    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

</head>

<body>

    <header class="navbar">

        <div class="nav-inner">

           
            <a href="#" class="brand">

                <span class="brand-mark">
                    ♻
                </span>

                <span>
                    EcoS-cam
                </span>

            </a>

            <nav class="nav-links">

                <a href="<?= base_url('mis-tachos') ?>">
    Mis Tachos
</a>


    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">
                    Contacto
                </a>

                <a href="<?= base_url('pagos/checkout') ?>" class="btn-premium">
    Obtener EcoS-cam 
</a>

            </nav>

    <div class="menu">

        <button class="menu-button">
            ☰ Menú
        </button>

        <div class="menu-content">

            <a href="<?= site_url('usuario/perfil') ?>">
                👤 Perfil
            </a>

            <a href="<?= site_url('usuario/servicios') ?>">
                🛠️ Servicios
            </a>

            <a href="<?= site_url('usuario/politica_privacidad') ?>">
                📄 Políticas de privacidad
            </a>
<a href="<?= site_url('usuario/cerrarSesion') ?>">🔒 Cerrar sesión</a>
        </div>

    </div>

</div>

    </header>

    <main class="container">

        <section class="welcome-block">

            <div class="welcome-text">

                <h1>

                    ¡Bienvenid@,

                    <span class="user-name">
                        <?= esc($usuario['nombre']) ?>
                    </span>

                    !

                </h1>

                <p>
                    Gestioná tus residuos, revisá estadísticas y ayudá
                    al medio ambiente desde tu panel principal.
                </p>

            </div>

            <div class="hero-badge">
                🌱 Sistema activo
            </div>

        </section>
        <section class="cards-grid">

<div class="card">
    <h3>♻ Residuos reciclados</h3>
    <p><?= $residuosHoy ?> residuos reciclados hoy.</p>
</div>

<div class="card">
    <h3>🌍 Impacto ambiental</h3>
    <p>Reducción estimada de CO₂: <?= $impactoAmbiental ?>%</p>
</div>

<div class="card">
    <h3>🏆 Nivel ecológico</h3>
    <p><?= $nivelEco ?></p>
</div>

</section>


<?php if(isset($tachoSeleccionado)): ?>

<div class="card">
    <h3>
        EcoScam seleccionado:
        <?= esc($tachoSeleccionado['nombre']) ?>
    </h3>
</div>

<?php else: ?>

<div class="card">
    <h3>Ningún EcoScam seleccionado</h3>

    <p>
        Registrá un EcoScam o uníte mediante código para comenzar.
    </p>
</div>

<?php endif; ?>


<div class="card card-tacho">

    <div class="tacho-info">

        <div>

            <?php if($tachoSeleccionado): ?>

                <h3>
                    🗑 <?= esc($tachoSeleccionado['nombre']) ?>
                </h3>

                <p>
                    Mostrando estadísticas de este Eco-Tacho
                </p>

            <?php else: ?>

                <h3>
                    Ningún Eco-Tacho seleccionado
                </h3>

            <?php endif; ?>

        </div>

<?php if (isset($tachos) && count($tachos) > 1): ?>

<button
    class="btn-cambiar"
    onclick="abrirModal()">

    📊 Cambiar estadísticas

</button>

<?php endif; ?>

    </div>

</div>
 
<section class="dashboard-extra">

  <!-- TARJETA + BOTONES -->
  <div class="tarjeta-contenedor">
    <div id="tarjeta-logro" class="tarjeta-logro">

      <!-- hojas decorativas -->
      <div class="leaf leaf-top">
        <svg viewBox="0 0 120 120" fill="none">
          <path d="M96 18C58 20 28 48 24 90c30-6 57-28 72-72z"
                stroke="white" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M38 74c13-10 29-25 48-44"
                stroke="white" stroke-width="3"
                stroke-linecap="round"/>
        </svg>
      </div>

      <div class="leaf leaf-bottom">
        <svg viewBox="0 0 120 120" fill="none">
          <path d="M96 18C58 20 28 48 24 90c30-6 57-28 72-72z"
                stroke="white" stroke-width="3"
                stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M38 74c13-10 29-25 48-44"
                stroke="white" stroke-width="3"
                stroke-linecap="round"/>
        </svg>
      </div>

      <!-- header -->
      <div class="impact-header">
        <div class="brand">
          <div class="brand-icon">♻</div>
          <span>EcoS-cam</span>
        </div>
        <div class="fecha"><?= date('d M Y') ?></div>
      </div>

      <!-- título -->
      <p class="impact-label">Mi impacto</p>
      <h2 class="impact-name"><?= esc($usuario['nombre']) ?></h2>

      <!-- número gigante -->
      <div class="impact-number">
        <div class="big-number"><?= $residuosHoy ?></div>
        <div class="number-text">residuos<br>reciclados</div>
      </div>

      <!-- stats -->
      <div class="impact-info">
        
        <div class="info-box">
          <span>Nivel</span>
          <strong>🏆 <?= $nivelEco ?></strong>
        </div>
      </div>

      <!-- footer -->
      <div class="impact-footer">
     
        <span>Reciclá con inteligencia</span>
      </div>
    </div>

    <!-- BOTONES -->
    <div class="acciones-logro">
      <button onclick="descargarTarjeta()">📥 Descargar</button>
      <button onclick="copiarTexto()">📋 Copiar</button>
    </div>
  </div>

  <!-- ESTADÍSTICAS -->
  <div class="panel">
    <h2>📊 Estadísticas</h2>
    <canvas id="graficoResiduos"></canvas>
  </div>

</section>

        <footer class="footer">
            EcoS-cam © 2026 - Todos los derechos reservados
        </footer>

    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
function descargarTarjeta() {
  const tarjeta = document.getElementById('tarjeta-logro');

  if (!tarjeta) {
    alert('No se encontró la tarjeta.');
    return;
  }

  // Esperar un pequeño tiempo para asegurar que todo esté renderizado
  setTimeout(() => {
    html2canvas(tarjeta, {
      scale: 2,
      backgroundColor: null, // mantiene el fondo transparente
      useCORS: true,
      logging: true // muestra errores en consola si algo falla
    }).then(canvas => {
      const enlace = document.createElement('a');
      enlace.download = 'ecoscam-logro.png';
      enlace.href = canvas.toDataURL('image/png');
      enlace.click();
    }).catch(error => {
      console.error('Error al generar la imagen:', error);
      alert('Hubo un problema al generar la tarjeta. Revisá la consola del navegador.');
    });
  }, 300);
}

function copiarTexto() {
  const texto =
    "Hoy reciclé <?= $residuosHoy ?> residuos usando EcoS-cam ♻. Mi impacto ambiental estimado es de <?= $impactoAmbiental ?>% y actualmente soy <?= $nivelEco ?>.";

  navigator.clipboard.writeText(texto)
    .then(() => alert('Texto copiado'))
    .catch(() => alert('No se pudo copiar el texto.'));
}
</script>
<script>

const canvas = document.getElementById('graficoResiduos');

if(canvas)
{
    new Chart(canvas, {

        type: 'bar',

        data: {

            labels: <?= $labels ?>,

            datasets: [{

                label: 'Residuos',

                data: <?= $datos ?>,

                backgroundColor: [
                    '#4CAF50',
                    '#2196F3',
                    '#FF9800',
                    '#9C27B0',
                    '#607D8B'
                ]
            }]
        },

        options: {

            responsive: true,

            plugins: {

                legend: {
                    display: false
                }
            },

            scales: {

                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

</script>
<div id="modalTachos" class="modal">


    <div class="modal-contenido">


        <span class="cerrar" onclick="cerrarModal()">
            ×
        </span>


        <h2>
            Elegí un Eco-Tacho
        </h2>


        <?php if(empty($tachos)): ?>


            <p>No tenés Eco-Tachos registrados.</p>


        <?php else: ?>


            <div class="lista-tachos">


                <?php foreach($tachos as $t): ?>


                    <div class="tarjeta-tacho">


                        <h3>
                            🗑 <?= esc($t['nombre']) ?>
                        </h3>


                        <p>
                            <?= esc($t['ubicacion']) ?>
                        </p>


                        <small>
                            <?= esc($t['tipo']) ?>
                        </small>


                        <br><br>


                        <a
                            class="btn-modal"
                            href="<?= site_url('tachos/seleccionar/'.$t['id']) ?>">


                            Ver estadísticas


                        </a>


                    </div>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>


    </div>


</div>
<script>

function abrirModal()
{
    document
        .getElementById('modalTachos')
        .style.display='flex';
}

function cerrarModal()
{
    document
        .getElementById('modalTachos')
        .style.display='none';
}

window.onclick=function(e)
{
    const modal=document.getElementById('modalTachos');


    if(e.target===modal)
    {
        modal.style.display='none';
    }
}

</script>
</body>
</html>
</html>