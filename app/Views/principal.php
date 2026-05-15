<!-- principal.php -->

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EcoScan principal</title>

    <link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

</head>

<body>

    <!-- =========================================================
         NAVBAR
    ========================================================== -->

    <header class="navbar">

        <div class="nav-inner">

           
            <!-- LOGO -->
            <a href="#" class="brand">

                <span class="brand-mark">
                    ♻
                </span>

                <span>
                    EcoS-cam
                </span>

            </a>

            <!-- LINKS -->
            <nav class="nav-links">

                <a href="#" class="active">
                    Resumen
                </a>

                <a href="#">
                    Mis Tachos
                </a>

                <a href="#">
                    Estadísticas
                </a>

    <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ecoscam2026@gmail.com" target="_blank" rel="noopener noreferrer">
                    Contacto
                </a>





                
                <a href="#">
                    Tienda
                </a>

            </nav>

            <!-- MENU DERECHA -->
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

        </div>

    </div>

</div>

        </div>

    </header>

    <!-- =========================================================
         MAIN
    ========================================================== -->

    <main class="container">

        <!-- HERO -->

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

        <!-- CARDS -->

        <section class="cards-grid">

            <div class="card">
                <h3>♻ Residuos reciclados</h3>
                <p>120kg reciclados este mes.</p>
            </div>

            <div class="card">
                <h3>🌍 Impacto ambiental</h3>
                <p>Reducción estimada de CO₂: 35%.</p>
            </div>

            <div class="card">
                <h3>📊 Estadísticas</h3>
                <p>Consultá tu progreso semanal y mensual.</p>
            </div>

            <div class="card">
                <h3>🏆 Nivel ecológico</h3>
                <p>Usuario Eco Avanzado.</p>
            </div>

        </section>

 <!-- HISTORIAL -->

<section class="history-section">

    <h2>
        Últimos movimientos
    </h2>

    <div class="table-wrapper">

        <table>

            <thead>

                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Tipo</th>
                </tr>

            </thead>

            <tbody>

                <tr>

                    <td>28/05/2026</td>
                    <td>08:20</td>

                    <td>
                        <span class="tag tag-plastic">
                            Plástico
                        </span>
                    </td>

                </tr>

                <tr>

                    <td>27/05/2026</td>
                    <td>17:45</td>

                    <td>
                        <span class="tag tag-paper">
                            Papel
                        </span>
                    </td>

                </tr>

                <tr>

                    <td>26/05/2026</td>
                    <td>14:10</td>

                    <td>
                        <span class="tag tag-organic">
                            Orgánico
                        </span>
                    </td>

                </tr>

            </tbody>

        </table>

    </div>

</section>

        <!-- FOOTER -->

        <footer class="footer">
            EcoS-cam © 2026 - Todos los derechos reservados
        </footer>

    </main>

</body>

</html>