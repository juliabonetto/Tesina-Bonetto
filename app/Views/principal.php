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


<section class="cards-grid">

    <div class="card">

        <h2>🌱 Compartí tu impacto</h2>

        <div id="tarjeta-logro" class="tarjeta-logro">

            <h3>♻ EcoS-cam</h3>

            <p>Hoy ayudé al planeta reciclando</p>

            <div class="numero-logro">
                <?= $residuosHoy ?>
            </div>

            <p>residuos correctamente clasificados</p>

            <p>
                🌍 Reducción estimada de CO₂:
                <?= $impactoAmbiental ?>%
            </p>

            <p>
                🏆 <?= $nivelEco ?>
            </p>

            <p>
                <?= esc($usuario['nombre']) ?>
            </p>
            <div class="acciones-logro">

<button onclick="descargarTarjeta()">
    📥 Descargar imagen
</button>

<button onclick="copiarTexto()">
    📋 Copiar texto
</button>

</div>
        </div>

    </div>

    <div class="card">

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
<script>

function descargarTarjeta()
{
    html2canvas(document.getElementById('tarjeta-logro'))
    .then(canvas => {

        const enlace = document.createElement('a');

        enlace.download = 'ecoscam-logro.png';

        enlace.href = canvas.toDataURL();

        enlace.click();

    });
}

function copiarTexto()
{
    const texto =
    "Hoy reciclé <?= $residuosHoy ?> residuos usando EcoS-cam ♻. Mi impacto ambiental estimado es de <?= $impactoAmbiental ?>% y actualmente soy <?= $nivelEco ?>.";

    navigator.clipboard.writeText(texto);

    alert('Texto copiado');
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
</body>

</html>