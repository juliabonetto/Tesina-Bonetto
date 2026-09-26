<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Mis Eco-Tachos | EcoS-cam</title>

    <style>
        :root {
            --g: #2f7a3f;
            --gd: #1f4d2b;
            --soft: #e8f4ea;
            --bg: #f7faf7;
            --muted: #647069;
            --border: #dfe8e1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: system-ui;
            color: #1c2620;
        }

        .container {
            max-width: 1250px;
            margin: auto;
            padding: 35px 20px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: linear-gradient(135deg, #e6f5e8, #f7fcf8);
            padding: 35px;
            border-radius: 18px;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(135deg, var(--g), #4ea25c);
            color: #fff;
            padding: 12px 18px;
            border-radius: 12px;
            border: 0;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary {
            background: #fff;
            color: var(--gd);
            border: 1px solid var(--g);
        }

        .btn-warning {
            background: #fff7e6;
            color: #8a5a00;
            border: 1px solid #e7c56a;
        }

        .actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            position: relative;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 4px 14px rgba(20, 40, 25, .08);
        }

        .delete {
            position: absolute;
            right: 12px;
            top: 10px;
            border: 0;
            background: transparent;
            font-size: 20px;
            cursor: pointer;
        }

        .status {
            font-weight: 700;
            color: var(--g);
        }

        .warn {
            color: #b3261e;
            font-weight: 700;
        }

        .role {
            display: inline-block;
            background: var(--soft);
            color: var(--gd);
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .card-actions .btn {
            text-align: center;
        }

        .message {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .success {
            background: #e8f5e9;
            color: #216b2f;
        }

        .error {
            background: #fdecec;
            color: #a32121;
        }

        .warning {
            background: #fff6df;
            color: #7a5600;
        }

        @media(max-width:700px) {
            .top {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <a class="btn btn-secondary"
       href="<?= site_url('usuario/principal') ?>">
        ← Volver
    </a>

    <div class="top">

        <div>

            <h1>
                Mis
                <span style="color:var(--g)">
                    Eco-Tachos
                </span>
            </h1>

            <p>
                Administrá tus Eco-Tachos y consultá las estadísticas de cada dispositivo.
            </p>

        </div>

        <strong>
            <?= count($tachos) ?> Eco-Tachos registrados
        </strong>

    </div>

    <?php if (session()->getFlashdata('success')): ?>

        <div class="message success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>

        <div class="message error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>

    <?php if (session()->getFlashdata('warning')): ?>

        <div class="message warning">
            <?= esc(session()->getFlashdata('warning')) ?>
        </div>

    <?php endif; ?>

    <div class="actions">

        <a class="btn"
           href="<?= base_url('unirse-tacho') ?>">
            ➕ Unirse a un EcoScam
        </a>

        <a class="btn"
           href="<?= base_url('registrar-tacho') ?>">
            ♻️ Registrar nuevo Eco-Tacho
        </a>

    </div>

    <div class="grid">

        <?php if (!$tachos): ?>

            <div class="card">

                <h3>
                    No tenés Eco-Tachos registrados.
                </h3>

                <p>
                    Registrá uno o uníte usando un código.
                </p>

            </div>

        <?php endif; ?>

        <?php foreach ($tachos as $tacho): ?>

            <?php
                $rol = strtolower(
                    $tacho->rol ?? 'lector'
                );
            ?>

            <div class="card">

                <button
                    class="delete"
                    data-id="<?= (int) $tacho->id ?>"
                    title="Eliminar"
                >
                    🗑
                </button>

                <h3>
                    <?= esc($tacho->nombre) ?>
                </h3>

                <p>
                    <strong>Tipo:</strong>
                    <?= esc($tacho->tipo) ?>
                </p>

                <p>
                    <strong>Ubicación:</strong>
                    <?= esc($tacho->ubicacion ?? 'Sin ubicación') ?>
                </p>

                <p>
                    <strong>Tu rol:</strong>
                    <span class="role">
                        <?= esc(ucfirst($rol)) ?>
                    </span>
                </p>

                <p class="<?= empty($tacho->habilitado) ? 'warn' : 'status' ?>">
                    <?= empty($tacho->habilitado)
                        ? '🔴 No habilitado'
                        : '🟢 Habilitado'
                    ?>
                </p>

                <div class="card-actions">

                    <!-- ESTADÍSTICAS: TODOS -->
                    <a
                        class="btn"
                        href="<?= base_url('estadisticas-tacho/' . $tacho->id) ?>"
                    >
                        📊 Ver estadísticas
                    </a>

                    <!-- SIMULACIÓN: TODOS -->
                    <a
                        class="btn"
                        href="<?= rtrim($simulacionUrl ?? 'http://192.168.1.150:8080', '/') ?>/tacho/<?= (int) $tacho->id ?>"
                        target="_blank"
                    >
                        🖥️ Abrir simulación
                    </a>

                    <!-- GESTIONAR: PROPIETARIO Y ADMINISTRADOR -->
                    <?php if (
                        in_array(
                            $rol,
                            ['propietario', 'administrador'],
                            true
                        )
                    ): ?>

                        <a
                            class="btn btn-warning"
                            href="<?= base_url('gestionar-tacho/' . $tacho->id) ?>"
                        >
                            ⚙️ Gestionar tacho
                        </a>

                    <?php endif; ?>

                    <!-- USUARIOS: SOLAMENTE PROPIETARIO -->
                    <?php if ($rol === 'propietario'): ?>

                        <a
                            class="btn btn-secondary"
                            href="<?= base_url('usuarios-tacho/' . $tacho->id) ?>"
                        >
                            👥 Usuarios del tacho
                        </a>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<script>

document
    .querySelectorAll('.delete')
    .forEach(button => {

        button.addEventListener(
            'click',
            async () => {

                if (
                    !confirm(
                        '¿Eliminar este Eco-Tacho de tu lista?'
                    )
                ) {
                    return;
                }

                const id = button.dataset.id;

                const fd = new URLSearchParams();

                <?php if (function_exists('csrf_token')): ?>

                    fd.append(
                        '<?= csrf_token() ?>',
                        '<?= csrf_hash() ?>'
                    );

                <?php endif; ?>

                const response = await fetch(
                    '<?= base_url('eliminar-tacho') ?>/' + id,
                    {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Content-Type':
                                'application/x-www-form-urlencoded'
                        },
                        body: fd
                    }
                );

                const data = await response.json();

                if (data.success) {

                    location.reload();

                } else {

                    alert(
                        data.message ||
                        'No se pudo eliminar'
                    );
                }

            }
        );

    });

</script>

</body>
</html>