<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Modificar Usuario | EcoS-cam</title>

<style>
:root {
  --bg: #f4f1ea;
  --ink: #14241b;
  --ink-soft: #3a4a40;
  --green: #1f6b3a;
  --lime: #c8f257;
  --radius: 22px;
  --serif: 'Fraunces', Georgia, serif;
  --sans: 'Inter', system-ui, sans-serif;
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:var(--bg);
  font-family:var(--sans);
  color:var(--ink);
  min-height:100vh;
}

header{
  background:var(--green);
  padding:12px 20px;
  color:#fff;
}

.perfil-container{
  max-width:600px;
  margin:50px auto;
  background:#fff;
  padding:35px;
  border-radius:var(--radius);
  border:2px solid var(--green);
  box-shadow:0 12px 30px rgba(20,36,27,.15);
  position:relative;
}

.perfil-container h2{
  font-family:var(--serif);
  text-align:center;
  color:var(--green);
  margin-bottom:25px;
}

.volver{
  position:absolute;
  top:20px;
  left:20px;
  background:var(--ink);
  color:#fff;
  padding:8px 16px;
  border-radius:8px;
  text-decoration:none;
  font-weight:600;
}

.volver:hover{
  background:var(--green);
}

.form-group{
  margin-bottom:18px;
}

.form-group label{
  display:block;
  margin-bottom:6px;
  font-weight:600;
  color:var(--ink-soft);
}

.form-group input,
.form-group select{
  width:100%;
  padding:12px;
  border:1px solid #ccc;
  border-radius:10px;
  font-size:1rem;
}

.form-group input:focus,
.form-group select:focus{
  outline:none;
  border-color:var(--green);
}

.botones{
  display:flex;
  gap:15px;
  margin-top:25px;
}

.btn{
  flex:1;
  border:none;
  padding:12px;
  border-radius:12px;
  cursor:pointer;
  font-weight:600;
  text-decoration:none;
  text-align:center;
}

.btn-guardar{
  background:var(--green);
  color:#fff;
}

.btn-guardar:hover{
  background:var(--ink);
}

.btn-cancelar{
  background:#ddd;
  color:#333;
}

.btn-cancelar:hover{
  background:#c8c8c8;
}
</style>

</head>
<body>

<header>
  <span>EcoS-cam · Modificar Usuario</span>
</header>

<div class="perfil-container">

  <a href="<?= site_url('usuario/principal') ?>" class="volver">
    ← Volver
  </a>

  <h2>Modificar Usuario</h2>

  <form action="<?= site_url('usuario/actualizar') ?>" method="post">

    <input type="hidden" name="id"
           value="<?= esc($usuario['id']) ?>">

    <div class="form-group">
      <label>Nombre y Apellido</label>
      <input type="text"
             name="nombre"
             value="<?= esc($usuario['nombre']) ?>"
             required>
    </div>

    <div class="form-group">
      <label>E-mail</label>
      <input type="email"
             name="email"
             value="<?= esc($usuario['email']) ?>">
    </div>

    <div class="form-group">
      <label>Nueva Contraseña</label>
      <input type="password"
             name="password"
             placeholder="Dejar vacío para mantener la actual">
    </div>

    <div class="form-group">
      <label>Rol</label>
      <select name="rol" required>

        <option value="usuario"
          <?= ($usuario['rol'] == 'usuario') ? 'selected' : '' ?>>
          Usuario
        </option>

        <option value="administrador"
          <?= ($usuario['rol'] == 'administrador') ? 'selected' : '' ?>>
          Administrador
        </option>

      </select>
    </div>

    <div class="botones">
      <button type="submit" class="btn btn-guardar">
        Guardar Cambios
      </button>

      <a href="<?= site_url('usuario/principal') ?>"
         class="btn btn-cancelar">
         Cancelar
      </a>
    </div>

  </form>

</div>

</body>
</html>