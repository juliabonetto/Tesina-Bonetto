<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>
        Gestionar Eco-Tacho | EcoS-cam
    </title>

    <style>

        :root {
            --green-dark: #1f4d2b;
            --green: #2f7a3f;
            --green-light: #4ea25c;
            --green-soft: #e8f4ea;
            --bg: #f7faf7;
            --card: #fff;
            --text: #1c2620;
            --muted: #647069;
            --border: #dfe8e1;
            --red: #b3261e;
            --orange: #8a5a00;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--bg);
            font-family: system-ui;
            color: var(--text);
        }

        .container {
            max-width: 1050px;
            margin: auto;
            padding: 30px 20px 50px;
        }

        .header {
            background: #fff;
            border: 2px solid var(--green);
            border-radius: 18px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .header h1 {
            color: var(--green);
            margin-bottom: 8px;
        }

        .back {
            display: inline-block;
            text-decoration: none;
            background: var(--text);
            color: #fff;
            padding: 10px 16px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .role {
            display: inline-block;
            background: var(--green-soft);
            color: var(--green-dark);
            padding: 7px 13px;
            border-radius: 20px;
            font-weight: 700;
        }

        .alert {
            padding: 18px;
            border-radius: 14px;
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
            background: #fff4d6;
            color: #795500;
            border: 1px solid #e7c56a;
        }

        .warning h3 {
            margin-top: 0;
        }

        .categories {
            display: grid;
            grid-template-columns:
                repeat(
                    auto-fit,
                    minmax(280px, 1fr)
                );
            gap: 20px;
            margin-bottom: 25px;
        }

        .category {
            background: var(--card);
            border: 2px solid var(--green);
            border-radius: 18px;
            padding: 25px;
            box-shadow:
                0 4px 14px
                rgba(20, 40, 25, .08);
        }

        .category h2 {
            margin-top: 0;
            color: var(--green-dark);
        }

        .category p {
            color: var(--muted);
        }

        .buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .buttons form {
            flex: 1;
            min-width: 110px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
        }

        .open {
            background: var(--green);
            color: #fff;
        }

        .close {
            background: #eef1ef;
            color: #1c2620;
            border: 1px solid #ccd5ce;
        }

        .bag {
            background: #fff;
            border: 2px solid var(--orange);
            border-radius: 18px;
            padding: 25px;
            margin-top: 20px;
        }

        .bag h2 {
            color: var(--orange);
            margin-top: 0;
        }

        .bag button {
            max-width: 300px;
            background: var(--orange);
            color: #fff;
        }

        .info {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            margin-top: 20px;
        }

        .distance {
            font-weight: 700;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="header">

        <a
            class="back"
            href="<?= site_url('mis-tachos') ?>"
        >
            ← Volver a Mis Eco-Tachos
        </a>

        <h1>
            ⚙️ Gestionar
            <?= esc($tacho->nombre) ?>
        </h1>

        <p>
            Desde esta sección podés controlar manualmente
            la apertura y el cierre de cada categoría.
        </p>

        <span class="role">
            Rol:
            <?= esc(ucfirst($rol)) ?>
        </span>

    </div>


    <?php if (session()->getFlashdata('success')): ?>

        <div class="alert success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('error')): ?>

        <div class="alert error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>

    <?php endif; ?>


    <?php if (session()->getFlashdata('warning')): ?>

        <div class="alert warning">
            <?= esc(session()->getFlashdata('warning')) ?>
        </div>

    <?php endif; ?>


    <!--
    ============================================================
    ALERTA DE LLENADO
    ============================================================
    -->

    <?php if (!empty($tacho->alerta_papel)): ?>

        <div class="alert warning">

            <h3>
                ⚠️ Bolsa llena
            </h3>

            <p>
                El sensor detectó que la bolsa necesita ser revisada.
            </p>

            <?php if (
                isset($tacho->distancia_papel)
                && $tacho->distancia_papel !== null
            ): ?>

                <p class="distance">
                    Distancia detectada:
                    <?= esc($tacho->distancia_papel) ?> cm
                </p>

            <?php endif; ?>

            <p>
                Cambiá físicamente la bolsa correspondiente
                y luego presioná el botón de confirmación.
            </p>

        </div>

    <?php endif; ?>


    <!--
    ============================================================
    CATEGORÍAS
    ============================================================
    -->

    <div class="categories">


        <!-- PLÁSTICO / VIDRIO -->

        <div class="category">

            <h2>
                🟦 Plástico / Vidrio
            </h2>

            <p>
                Control manual del compartimento
                de plástico y vidrio.
            </p>

            <div class="buttons">

                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="plastico_vidrio"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="abrir"
                    >

                    <button
                        type="submit"
                        class="open"
                    >
                        🔓 Abrir
                    </button>

                </form>


                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="plastico_vidrio"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="cerrar"
                    >

                    <button
                        type="submit"
                        class="close"
                    >
                        🔒 Cerrar
                    </button>

                </form>

            </div>

        </div>


        <!-- ORGÁNICO -->

        <div class="category">

            <h2>
                🟫 Orgánico
            </h2>

            <p>
                Control manual del compartimento
                de residuos orgánicos.
            </p>

            <div class="buttons">

                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="organico"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="abrir"
                    >

                    <button
                        type="submit"
                        class="open"
                    >
                        🔓 Abrir
                    </button>

                </form>


                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="organico"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="cerrar"
                    >

                    <button
                        type="submit"
                        class="close"
                    >
                        🔒 Cerrar
                    </button>

                </form>

            </div>

        </div>


        <!-- PAPEL -->

        <div class="category">

            <h2>
                📄 Papel
            </h2>

            <p>
                Control manual del compartimento
                de papel.
            </p>

            <div class="buttons">

                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="papel"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="abrir"
                    >

                    <button
                        type="submit"
                        class="open"
                    >
                        🔓 Abrir
                    </button>

                </form>


                <form
                    action="<?= site_url('tacho/control') ?>"
                    method="POST"
                >

                    <?php if (function_exists('csrf_token')): ?>

                        <input
                            type="hidden"
                            name="<?= csrf_token() ?>"
                            value="<?= csrf_hash() ?>"
                        >

                    <?php endif; ?>

                    <input
                        type="hidden"
                        name="dispositivo_id"
                        value="<?= (int) $tacho->id ?>"
                    >

                    <input
                        type="hidden"
                        name="categoria"
                        value="papel"
                    >

                    <input
                        type="hidden"
                        name="accion"
                        value="cerrar"
                    >

                    <button
                        type="submit"
                        class="close"
                    >
                        🔒 Cerrar
                    </button>

                </form>

            </div>

        </div>

    </div>


    <!--
    ============================================================
    CAMBIO DE BOLSA
    ============================================================
    -->

    <?php if (!empty($tacho->alerta_papel)): ?>

        <div class="bag">

            <h2>
                🗑️ Cambio de bolsa
            </h2>

            <p>
                Una vez que hayas cambiado físicamente
                la bolsa detectada por el sistema,
                presioná el siguiente botón.
            </p>

            <form
                action="<?= site_url('tacho/cambiar-bolsa') ?>"
                method="POST"
                onsubmit="return confirm('¿Confirmás que ya cambiaste la bolsa?');"
            >

                <?php if (function_exists('csrf_token')): ?>

                    <input
                        type="hidden"
                        name="<?= csrf_token() ?>"
                        value="<?= csrf_hash() ?>"
                    >

                <?php endif; ?>

                <input
                    type="hidden"
                    name="dispositivo_id"
                    value="<?= (int) $tacho->id ?>"
                >

                <button type="submit">
                    🗑️ Ya cambié la bolsa
                </button>

            </form>

        </div>

    <?php endif; ?>


    <div class="info">

        <strong>
            ℹ️ Importante
        </strong>

        <p>
            Los botones de apertura y cierre solamente
            controlan el compartimento seleccionado.
            No modifican la clasificación automática
            del Eco-Tacho.
        </p>

    </div>

</div>

</body>
</html>