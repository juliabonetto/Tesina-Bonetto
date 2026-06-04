<!-- principal.php -->

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

                <a href="#" class="active">
                    Resumen
                </a>

                <a href="#">
                    Mis Tachos
                </a>

                <a href="<?= site_url('usuario/estadistica') ?>">
    Estadísticas
</a>

    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">
                    Contacto
                </a>

                <a href="<?= site_url('usuario/comprar') ?>">
                    Tienda
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

<section class="history-section">

    <h2>🌱 Compartí tu impacto</h2>

    <div id="tarjeta-logro" class="tarjeta-logro">

        <div class="logo-logro">♻</div>

        <h3>EcoS-cam</h3>

        <p class="frase-logro">
            Hoy ayudé al planeta reciclando
        </p>

        <div class="numero-logro">
            <?= $residuosHoy ?>
        </div>

        <p class="detalle-logro">
            residuos correctamente clasificados
        </p>

        <p class="detalle-logro">
            🌍 Reducción estimada de CO₂:
            <?= $impactoAmbiental ?>%
        </p>

        <p class="nivel-logro">
            🏆 <?= $nivelEco ?>
        </p>

        <p class="usuario-logro">
            <?= esc($usuario['nombre']) ?>
        </p>

    </div>

    <div class="acciones-logro">

        <button onclick="descargarTarjeta()">
            📸 Descargar imagen
        </button>

        <button onclick="copiarTexto()">
            📋 Copiar texto
        </button>

    </div>

</section>

        <footer class="footer">
            EcoS-cam © 2026 - Todos los derechos reservados
        </footer>

    </main>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

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
</body>

</html>