<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
    <style>
body {
  font-family: 'Roboto', sans-serif;
  margin: 0;
  padding: 0;
  background-color:rgb(206, 253, 220);
}


        @keyframes fondoDegrade {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        header {
            background-color:rgb(1, 156, 27);
            padding: 10px 20px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu {
            position: relative;
            display: inline-block;
        }

        .menu-button {
            background-color:rgb(0, 143, 24);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
        }

        .menu-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 6px;
            z-index: 1;
        }

        .menu-content a {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-bottom: 1px solid #eee;
        }

        .menu-content a:hover {
            background-color: #f1f1f1;
        }

        .menu:hover .menu-content {
            display: block;
        }

        .perfil-container {
            max-width: 500px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 2px solidrgb(219, 253, 218);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            position: relative;
        }

        .perfil-container h2 {
            color:rgb(3, 80, 3);
            margin-bottom: 20px;
            text-align: center;
        }

        .perfil-info p {
            margin: 12px 0;
            font-size: 1rem;
            color: #333;
        }

        .btn-editar {
            display: block;
            margin: 20px auto 0;
            background-color:rgb(63, 199, 92);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-editar:hover {
            background-color:rgb(6, 112, 11);
            transform: scale(1.05);
        }

        .volver {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color:rgb(20, 141, 40);
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 0.95rem;
            transition: background-color 0.3s;
        }

        .volver:hover {
            background-color:rgb(6, 112, 11);
        }
        .botones-acciones {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
}

.botones-acciones .btn-editar {
  margin: 0;
  flex: 1;
  text-align: center;
}

    </style>
</head>
<body>

<div class="perfil-container">
    <a href="<?= site_url('usuario/principal') ?>" class="volver">← Volver al inicio</a>
    <h2>Mi Perfil</h2>
    <div class="perfil-info">
        <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
        <p><strong>Nombre:</strong> <?= esc($usuario['nombre'] ?? 'No especificado') ?></p>
        <p><strong>Rol:</strong> <?= esc($usuario['rol']) ?></p>
    </div>

<div class="botones-acciones">
  <a href="<?= site_url('usuario/cambiarPass') ?>" class="btn-editar">Editar contraseña</a>
</div>

</body>
</html>
