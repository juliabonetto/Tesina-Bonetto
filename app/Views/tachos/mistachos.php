<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mis Eco-Tachos | EcoS-cam</title>

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

    --shadow:
        0 4px 14px rgba(20, 40, 25, 0.08);

    --radius: 18px;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:var(--bg);
    color:var(--text);

    font-family:
        system-ui,
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        sans-serif;

    line-height:1.5;
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

.container{

    width:100%;
    max-width:1300px;

    margin:auto;

    padding:40px 24px;
}

.card {
    position: relative; /* Necesario para posicionar el botón dentro */
}

.btn-eliminar {
    position: absolute;
    top: 12px;
    right: 12px;
    background: transparent;
    border: none;
    font-size: 1.4rem;
    cursor: pointer;
    color: #b0b0b0;
    transition: color 0.2s;
    padding: 4px 8px;
    line-height: 1;
}
.btn-eliminar:hover {
    color: #d32f2f;
}

.welcome-block{

    background:
        linear-gradient(
            135deg,
            #e6f5e8,
            #f7fcf8
        );

    border:1px solid var(--border);

    border-radius:var(--radius);

    padding:50px;

    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:30px;

    box-shadow:var(--shadow);

    margin-bottom:40px;
}

.welcome-text h1{

    font-size:2.5rem;

    margin-bottom:12px;
}

.user-name{
    color:var(--green);
}

.welcome-text p{

    color:var(--muted);

    max-width:650px;
}

.hero-badge{

    background:white;

    border:1px solid var(--border);

    padding:16px 22px;

    border-radius:16px;

    font-weight:600;

    color:var(--green-dark);
}

/* =========================================================
   botones
========================================================= */

.acciones-tachos{

    display:flex;
    gap:15px;

    margin-bottom:35px;

    flex-wrap:wrap;
}

.btn-accion1{
    display:inline-block;

    position: absolute;
    left: 40px;      /* distancia desde el borde izquierdo */
    top: 40px;       /* ajustá este valor hasta alinearlo con el título */

    text-decoration:none;

    background: linear-gradient(
        135deg,
        var(--green),
        var(--green-light)
    );

    color:white;
    padding:14px 22px;
    border-radius:14px;
    font-weight:600;
    transition:.25s;
    box-shadow:var(--shadow);
}

.btn-accion1:hover{
    transform:translateY(-2px);
}

.btn-accion{

    text-decoration:none;

    background:
        linear-gradient(
            135deg,
            var(--green),
            var(--green-light)
        );

    color:white;

    padding:14px 22px;

    border-radius:14px;

    font-weight:600;

    transition:.25s;

    box-shadow:var(--shadow);
}

.btn-accion:hover{

    transform:translateY(-2px);
}

/* =========================================================
   tarjetas
========================================================= */

.cards-grid{

    display:grid;

    grid-template-columns:
        repeat(auto-fit,minmax(280px,1fr));

    gap:22px;
}

.card{

    background:var(--card);

    border-radius:var(--radius);

    padding:28px;

    border:1px solid var(--border);

    box-shadow:var(--shadow);

    transition:.25s;
}

.card:hover{

    transform:translateY(-4px);
}

.card h3{

    margin-bottom:15px;

    color:var(--green-dark);
}

.card p{

    color:var(--muted);

    margin-bottom:10px;
}

.btn-estadisticas{

    display:inline-block;

    margin-top:15px;

    text-decoration:none;

    background:var(--green-soft);

    color:var(--green-dark);

    padding:10px 16px;

    border-radius:12px;

    font-weight:600;

    transition:.25s;
}

.btn-estadisticas:hover{

    background:var(--green);

    color:white;
}



@media(max-width:900px){

    .welcome-block{

        flex-direction:column;

        align-items:flex-start;
    }
}

@media(max-width:600px){

    .welcome-text h1{

        font-size:2rem;
    }

    .container{

        padding:25px 16px;
    }

    .welcome-block{

        padding:30px;
    }
}

</style>

</head>

<body>

<div class="container">

    <div style="margin-bottom: 16px;">
        <a href="<?= site_url('usuario/principal') ?>" class="btn-volver">
            ← Volver
        </a>
    </div>

    <div class="welcome-block">

   

        <div class="welcome-text">
            <h1>
                Mis <span class="user-name">Eco-Tachos</span>
            </h1>
            <p>
                Administra tus Eco-Tachos, consulta estadísticas
                y visualiza la información de cada dispositivo.
            </p>
        </div>

        <div class="hero-badge">
            <?= count($tachos) ?> Eco-Tachos registrados
        </div>

    </div>

    <div class="acciones-tachos">

        <a
            href="<?= base_url('unirse-tacho') ?>"
            class="btn-accion"
        >
            ➕ Unirse a un EcoScam
        </a>

        <a
            href="<?= base_url('registrar-tacho') ?>"
            class="btn-accion"
        >
            ♻️ Registrar nuevo Eco-Tacho
        </a>

    </div>

    <div class="cards-grid">

        <?php foreach($tachos as $tacho): ?>

        <div class="card">
        <button class="btn-eliminar" data-id="<?= $tacho->id ?>" title="Eliminar este Eco-Tacho de mi lista">🗑 </button>
            <h3>
                <?= esc($tacho->nombre) ?>
            </h3>

            <p>
                <strong>Tipo:</strong>
                <?= esc($tacho->tipo) ?>
            </p>

            <p>
                <strong>Ubicación:</strong>
                <?= esc($tacho->ubicacion) ?>
            </p>

            <p>
               <strong>Tu rol:</strong>
              <?= esc($tacho->rol ?? 'Sin rol') ?>
            </p>

            <a
                href="<?= base_url('estadisticas-tacho/'.$tacho->id) ?>"
                class="btn-estadisticas"
            >
                Ver estadísticas
            </a>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const eliminarBtns = document.querySelectorAll('.btn-eliminar');

    eliminarBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const card = this.closest('.card');

            if (!confirm('¿Estás seguro de que quieres eliminar este Eco-Tacho de tu lista? Perderás acceso a sus estadísticas.')) {
                return;
            }

            const formData = new URLSearchParams();
            <?php if (function_exists('csrf_token')): ?>
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            <?php endif; ?>

            fetch('<?= base_url('eliminar-tacho') ?>/' + id, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData.toString()
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Eliminar la tarjeta del DOM
                    if (card) card.remove();

                    // Actualizar contador
                    const badge = document.querySelector('.hero-badge');
                    if (badge) {
                        let text = badge.textContent;
                        let num = parseInt(text);
                        if (!isNaN(num)) {
                            num--;
                            badge.textContent = num + ' Eco-Tachos registrados';
                        }
                    }

                    // Mensaje si no quedan tachos
                    const cardsGrid = document.querySelector('.cards-grid');
                    if (cardsGrid && cardsGrid.children.length === 0) {
                        cardsGrid.innerHTML = '<p style="grid-column: 1/-1; text-align:center; color:var(--muted);">No tienes Eco-Tachos en tu lista.</p>';
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Ocurrió un error al intentar eliminar el tacho.');
                console.error(error);
            });
        });
    });
});
</script>

</body>
</html>
