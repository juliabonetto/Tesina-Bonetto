<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EcoScan principal</title>
<link rel="stylesheet" href="<?= base_url('css/dashboard.css') ?>">

</head>

<body>

    <!-- NAVBAR -->

    <header class="navbar">

        <div class="nav-inner">

            <a href="#" class="brand">
                <span class="brand-mark">♻</span>
                <span>EcoScan</span>
            </a>

            <nav class="nav-links">
                <a href="#" class="active">Resumen</a>
                <a href="#">Mis Tachos</a>
                <a href="#">Estadísticas</a>
                <a href="#">Educación</a>
                <a href="#">Tienda</a>
            </nav>

            <a href="<?= base_url('/usuario/perfil') ?>" class="btn">
                Mi Cuenta
            </a>

        </div>

    </header>

    <!-- MAIN -->

    <main class="container">

        <!-- HERO -->

        <section class="welcome-block">

            <div class="welcome-text">

                <h1>
                    ¡Bienvenido,
                    <span class="user-name">
                        <?= esc($usuario['nombre']) ?>
                    </span>!
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

            <h2>Últimos movimientos</h2>

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th>Estado</th>
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
                            <td>Reciclado</td>
                        </tr>

                        <tr>
                            <td>27/05/2026</td>
                            <td>17:45</td>
                            <td>
                                <span class="tag tag-paper">
                                    Papel
                                </span>
                            </td>
                            <td>Procesado</td>
                        </tr>

                        <tr>
                            <td>26/05/2026</td>
                            <td>14:10</td>
                            <td>
                                <span class="tag tag-organic">
                                    Orgánico
                                </span>
                            </td>
                            <td>Compostado</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </section>

        <!-- FOOTER -->

        <footer class="footer">
            EcoScan © 2026 - Todos los derechos reservados
        </footer>

    </main>

</body>

</html>