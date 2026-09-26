<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width,initial-scale=1"
    >

    <title>
        Usuarios del Eco-Tacho | EcoS-cam
    </title>

    <style>

        :root {
            --green-dark: #1f4d2b;
            --green: #2f7a3f;
            --green-light: #4ea25c;
            --green-soft: #e8f4ea;
            --bg: #f7faf7;
            --text: #1c2620;
            --border: #dfe8e1;
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
            max-width: 1000px;
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

        .back {
            display: inline-block;
            text-decoration: none;
            background: var(--text);
            color: #fff;
            padding: 10px 16px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        h1 {
            color: var(--green);
        }

        .message {
            padding: 15px 18px;
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

        .users {
            display: grid;
            gap: 15px;
        }

        .user-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow:
                0 4px 14px
                rgba(20, 40, 25, .06);
        }

        .user-info h3 {
            margin: 0 0 5px;
        }

        .user-info p {
            margin: 4px 0;
            color: #647069;
        }

        .role {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 11px;
            border-radius: 20px;
            background: var(--green-soft);
            color: var(--green-dark);
            font-weight: 700;
            font-size: 13px;
        }

        .owner {
            background: #e8f4ea;
        }

        .admin {
            background: #fff4d6;
            color: #795500;
        }

        .reader {
            background: #eef1ef;
            color: #465149;
        }

        form {
            margin: 0;
        }

        button {
            border: 0;
            border-radius: 10px;
            padding: 11px 15px;
            cursor: pointer;
            font-weight: 700;
        }

        .make-admin {
            background: var(--green);
            color: #fff;
        }

        .remove-admin {
            background: #eef1ef;
            color: #1c2620;
            border: 1px solid #ccd5ce;
        }

        .owner-label {
            color: var(--green-dark);
            font-weight: 700;
        }

        .empty {
            background: #fff;
            border: 1px solid var(--border);
            padding: 25px;
            border-radius: 16px;
        }

        @media(max-width:700px) {

            .user-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .user-card form,
            .user-card button {
                width: 100%;
            }

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
            👥 Usuarios de
            <?= esc($tacho->nombre) ?>
        </h1>

        <p>
            Desde acá podés administrar los permisos
            de los usuarios vinculados a este Eco-Tacho.
        </p>

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


    <div class="users">

        <?php if (!$usuarios): ?>

            <div class="empty">
                <h3>
                    No hay usuarios vinculados.
                </h3>
            </div>

        <?php endif; ?>


        <?php foreach ($usuarios as $usuario): ?>

            <?php

                $rol = strtolower(
                    (string) $usuario->rol
                );

                $nombreCompleto = trim(
                    ($usuario->nombre ?? '')
                    . ' '
                    . ($usuario->apellido ?? '')
                );

            ?>

            <div class="user-card">

                <div class="user-info">

                    <h3>
                        <?= esc(
                            $nombreCompleto !== ''
                                ? $nombreCompleto
                                : 'Usuario'
                        ) ?>
                    </h3>

                    <?php if (!empty($usuario->email)): ?>

                        <p>
                            <?= esc($usuario->email) ?>
                        </p>

                    <?php endif; ?>


                    <?php if ($rol === 'propietario'): ?>

                        <span class="role owner">
                            👑 Propietario
                        </span>

                    <?php elseif ($rol === 'administrador'): ?>

                        <span class="role admin">
                            ⚙️ Administrador
                        </span>

                    <?php else: ?>

                        <span class="role reader">
                            👁️ Lector
                        </span>

                    <?php endif; ?>

                </div>


                <div>

                    <?php if ($rol === 'propietario'): ?>

                        <span class="owner-label">
                            Propietario del Eco-Tacho
                        </span>

                    <?php elseif ($rol === 'lector'): ?>

                        <form
                            action="<?= site_url('usuarios-tacho/cambiar-rol') ?>"
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
                                name="usuario_id"
                                value="<?= (int) $usuario->usuario_id ?>"
                            >

                            <input
                                type="hidden"
                                name="rol"
                                value="administrador"
                            >

                            <button
                                type="submit"
                                class="make-admin"
                            >
                                ⚙️ Hacer administrador
                            </button>

                        </form>

                    <?php elseif ($rol === 'administrador'): ?>

                        <form
                            action="<?= site_url('usuarios-tacho/cambiar-rol') ?>"
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
                                name="usuario_id"
                                value="<?= (int) $usuario->usuario_id ?>"
                            >

                            <input
                                type="hidden"
                                name="rol"
                                value="lector"
                            >

                            <button
                                type="submit"
                                class="remove-admin"
                            >
                                👁️ Quitar administrador
                            </button>

                        </form>

                    <?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>