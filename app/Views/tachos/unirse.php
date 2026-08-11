<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unirse a EcoScam | EcoS-cam</title>

    <style>
        :root {
            --green-dark: #1f4d2b;
            --green: #2f7a3f;
            --green-light: #4ea25c;
            --green-soft: #e8f4ea;
            --bg: #f7faf7;
            --card: #ffffff;
            --text: #1c2620;
            --muted: #647069;
            --border: #dfe8e1;
            --shadow: 0 4px 14px rgba(20, 40, 25, 0.08);
            --radius: 18px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            line-height: 1.5;
        }

        .container {
            width: 100%;
            max-width: 1300px;
            margin: auto;
            padding: 40px 24px;
        }

        .btn-volver {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, var(--green), var(--green-light));
            color: white;
            padding: 14px 22px;
            border-radius: 14px;
            font-weight: 600;
            transition: .25s;
            box-shadow: var(--shadow);
            align-self: flex-start;
        }
        .btn-volver:hover {
            transform: translateY(-2px);
        }

        .welcome-block {
            background: linear-gradient(135deg, #e6f5e8, #f7fcf8);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            box-shadow: var(--shadow);
            margin-bottom: 40px;
        }

        .welcome-text h1 {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }
        .user-name {
            color: var(--green);
        }
        .welcome-text p {
            color: var(--muted);
            max-width: 650px;
        }

        .hero-badge {
            background: white;
            border: 1px solid var(--border);
            padding: 16px 22px;
            border-radius: 16px;
            font-weight: 600;
            color: var(--green-dark);
        }

        /* ===== FORMULARIO ===== */
        .form-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 40px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            max-width: 700px;
            margin: 0 auto;
        }

        .form-card label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--green-dark);
        }

        .form-card input {
            width: 100%;
            padding: 14px 18px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font-size: 1rem;
            background: var(--bg);
            transition: border-color .2s;
            margin-bottom: 22px;
        }

        .form-card input:focus {
            outline: none;
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(47, 122, 63, 0.15);
        }

        .btn-accion {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, var(--green), var(--green-light));
            color: white;
            padding: 16px 28px;
            border-radius: 14px;
            font-weight: 600;
            transition: .25s;
            box-shadow: var(--shadow);
            border: none;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }
        .btn-accion:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #1f4d2b, #2f7a3f);
        }

        .form-card .info-text {
            color: var(--muted);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        @media (max-width: 900px) {
            .welcome-block {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 600px) {
            .welcome-text h1 {
                font-size: 2rem;
            }
            .container {
                padding: 25px 16px;
            }
            .welcome-block {
                padding: 30px;
            }
            .form-card {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- Botón volver -->
        <div style="margin-bottom: 16px;">
            <a href="<?= site_url('usuario/mis-tachos') ?>" class="btn-volver">
                ← Volver
            </a>
        </div>

        <!-- Bloque de bienvenida -->
        <div class="welcome-block">
            <div class="welcome-text">
                <h1>
                    Unirse a <span class="user-name">EcoScam</span>
                </h1>
                <p>
                    Ingresá el código de activación del Eco-Tacho al que deseas unirte
                    y comenzá a ver sus estadísticas.
                </p>
            </div>
            <div class="hero-badge">
                🔗 Nuevo acceso
            </div>
        </div>

        <!-- Formulario -->
        <div class="form-card">
            <form action="<?= base_url('procesar-union') ?>" method="post">
                <?= csrf_field() ?>
                <label for="codigo">Código de activación</label>
                <input
                    type="text"
                    id="codigo"
                    name="codigo"
                    placeholder="Ej: ABC123"
                    required
                >
                <button type="submit" class="btn-accion">➕ Unirse al EcoScam</button>
            </form>

            <p class="info-text" style="margin-top:20px;">
                <strong>Nota:</strong> Al unirte, podrás ver las estadísticas del Eco-Tacho.
                
            </p>
        </div>

    </div>

</body>
</html>