<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>EcoScam</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right,rgb(207, 255, 221),rgb(82, 190, 124));
      color:rgb(9, 75, 44);
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 40px;
      background-color: #ffffffcc;
      box-shadow: 0 2px 4px rgba(4, 49, 8, 0.89);
    }

    .logo {
      font-size: 24px;
      font-weight: bold;
      color:rgb(44, 170, 107);
    }

    nav a {
      margin: 0 15px;
      text-decoration: none;
      color:rgb(48, 139, 89);
      font-weight: 500;
    }

    .menu-icon {
      font-size: 24px;
      cursor: pointer;
      display: none;
    }

    .main-content {
      text-align: center;
      padding: 100px 20px;
    }

    .main-content h1 {
      font-size: 48px;
      margin-bottom: 20px;
      color:rgb(7, 71, 7);
    }

    .main-content p {
      font-size: 19px;
      max-width: 600px;
      margin: 0 auto 40px;
  color: rgb(0, 44, 71); }

  

    .buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .buttons a {
      padding: 12px 24px;
      text-decoration: none;
      font-size: 16px;
      border-radius: 6px;
      background-color:rgb(17, 145, 70);
      color: white;
      transition: background-color 0.3s ease;
    }

    .buttons a:hover {
      background-color:rgb(48, 173, 58);
    }

    @media (max-width: 768px) {
      nav {
        display: none;
      }
      .menu-icon {
        display: block;
      }
    }
  </style>
</head>
<body>

  <header>
    <div class="logo">EcoScam</div>
    <nav>
  <a href="https://mail.google.com/mail/?view=cm&fs=1&to=optiglass.clinica@gmail.com&su=Consulta&body=Hola%20OptiGlass%2C%0AQuisiera%20consultar%20por" target="_blank" style="color: #000; text-decoration: none; font-family: 'Montserrat', sans-serif;">Contacto</a>
</nav>
    <div class="menu-icon">☰</div>
  </header>

  <div class="main-content">
    <h1>¡Bienvenido a EcoScam!🗑️</h1>
    <p>
     
info  <br>

<br><br> info <br>
info <br>Tinfo
<br><br> info <br>
info </p>

    <div class="buttons">
      <a href="<?= site_url('usuario/login') ?>">Inicio de Sesión</a>
      <a href="<?= site_url('usuario/registro') ?>">Registro</a>
    </div>
  </div>

</body>
</html>
