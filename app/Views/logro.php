<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Mi Logro EcoS-cam</title>

<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

<style>

body{
    background:#eef5ee;
    font-family:Arial,sans-serif;
    text-align:center;
}

.tarjeta{

    width:600px;
    margin:40px auto;
    padding:40px;

    border-radius:20px;

    background:white;

    box-shadow:0 10px 30px rgba(0,0,0,.1);
}

.logo{

    font-size:40px;
}

.titulo{

    font-size:30px;
    font-weight:bold;
    color:#2e7d32;
}

.numero{

    font-size:55px;
    font-weight:bold;
    margin-top:20px;
}

.dato{

    margin-top:15px;
    font-size:22px;
}

.nivel{

    margin-top:25px;
    font-size:28px;
    color:#1b5e20;
}

.botones{

    margin-top:30px;
}

button{

    padding:12px 25px;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
}

.descargar{

    background:#4caf50;
    color:white;
}

.copiar{

    background:#2196f3;
    color:white;
}


</style>

</head>

<body>

<div id="tarjeta" class="tarjeta">

    <div class="logo">♻</div>

    <div class="titulo">
        EcoS-cam
    </div>

    <h2>
        Mi impacto ecológico
    </h2>

    <div class="numero">

        <?= $residuosHoy ?>

    </div>

    <div class="dato">
        residuos reciclados hoy
    </div>

    <div class="dato">
        🌍 Reducción estimada de CO₂:
        <?= $impactoAmbiental ?>%
    </div>

    <div class="nivel">
        🏆 <?= $nivelEco ?>
    </div>

    <div class="dato">
        Usuario:
        <?= esc($usuario['nombre']) ?>
    </div>

</div>

<div class="botones">

    <button class="descargar" onclick="descargarTarjeta()">
        📸 Descargar imagen
    </button>

    <button class="copiar" onclick="copiarTexto()">
        📋 Copiar texto
    </button>

</div>

<script>

function descargarTarjeta()
{
    html2canvas(document.getElementById('tarjeta'))
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
        'Hoy reciclé <?= $residuosHoy ?> residuos usando EcoS-cam ♻. Mi impacto ambiental alcanzó <?= $impactoAmbiental ?>% y soy <?= $nivelEco ?>.';

    navigator.clipboard.writeText(texto);

    alert('Texto copiado');
}

</script>

</body>
</html>