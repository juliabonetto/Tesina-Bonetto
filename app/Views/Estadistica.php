<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Estadísticas | EcoS-cam</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

:root{
    /* ===== PALETA ECO-CAM ===== */
    --green-dark: #1f4d2b;
    --green:      #2f7a3f;
    --green-light:#4ea25c;
    --green-soft: #e8f4ea;
    --bg:         #f7faf7;
    --card:       #ffffff;
    --text:       #1c2620;
    --muted:      #647069;
    --border:     #dfe8e1;
    --shadow:     0 4px 14px rgba(20, 40, 25, 0.08);
    --radius:     18px;

    /* Variables antiguas (se mantienen para compatibilidad) */
    --ink:       var(--text);
    --ink-soft:  var(--muted);
    --lime:      #c8f257;   /* no se usa, se conserva */
    --serif:     'Fraunces', Georgia, serif;
    --sans:      system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:var(--bg);
    font-family:var(--sans);
    color:var(--text);
    min-height:100vh;
    padding:30px 20px;
}

.estadisticas-container{
    max-width:1200px;
    margin:auto;
}

/* ==========================
   HEADER
========================== */

.header-card{
    background:var(--card);
    border-radius:var(--radius);
    border:2px solid var(--green);
    box-shadow:var(--shadow);
    padding:30px 30px 20px 30px;
    margin-bottom:30px;
    position:relative;
    display:flex;
    flex-direction:column;
    align-items:center;
}

.header-card .volver{
    align-self:flex-start;
    background:var(--text);
    color:white;
    text-decoration:none;
    padding:10px 18px;
    border-radius:10px;
    transition:.3s;
    font-weight:600;
    margin-bottom:10px;
}

.header-card .volver:hover{
    background:var(--green);
}

.header-card h1{
    color:var(--green);
    font-family:var(--serif);
    font-size:2rem;
    margin-bottom:6px;
}

.header-card .nombre-tacho{
    color:var(--muted);
    font-size:1.2rem;
    font-weight:500;
    background:var(--green-soft);
    padding:6px 18px;
    border-radius:30px;
    display:inline-block;
}

/* ==========================
   CARDS
========================== */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(200px, 1fr));
    gap:20px;
    margin-bottom:30px;
}

.card{
    background:var(--card);
    border-radius:var(--radius);
    border:2px solid var(--green);
    padding:25px 15px;
    text-align:center;
    box-shadow:var(--shadow);
    transition: transform 0.2s;
}

.card:hover{
    transform:translateY(-3px);
}

.card h3{
    color:var(--muted);
    margin-bottom:8px;
    font-weight:500;
    font-size:1rem;
    text-transform:uppercase;
    letter-spacing:0.5px;
}

.card h2{
    color:var(--green-dark);
    font-size:2.2rem;
    font-weight:700;
}

/* ==========================
   GRAFICOS
========================== */

.graficos{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
    margin-bottom:30px;
}

.panel{
    background:var(--card);
    border-radius:var(--radius);
    border:2px solid var(--green);
    padding:25px;
    box-shadow:var(--shadow);
}

.panel h2{
    color:var(--green-dark);
    margin-bottom:18px;
    font-family:var(--serif);
    font-size:1.5rem;
    text-align:center;
}

.chart-container{
    width:100%;
    max-width:280px;
    height:280px;
    margin:0 auto;
}

.resumen-item{
    display:flex;
    justify-content:space-between;
    padding:10px 0;
    border-bottom:1px solid var(--border);
    font-size:1.05rem;
}

.resumen-item:last-child{
    border-bottom:none;
}

.resumen-item strong{
    color:var(--text);
}

.resumen-item span{
    color:var(--green-dark);
    font-weight:600;
}

/* ==========================
   TABLA
========================== */

.tabla-container{
    background:var(--card);
    border-radius:var(--radius);
    border:2px solid var(--green);
    padding:25px;
    box-shadow:var(--shadow);
}

.tabla-container h2{
    color:var(--green-dark);
    margin-bottom:18px;
    font-family:var(--serif);
    font-size:1.5rem;
    text-align:center;
}

.table-scroll{
    max-height:380px;
    overflow-y:auto;
    border-radius:12px;
}

table{
    width:100%;
    border-collapse:collapse;
    font-size:0.95rem;
}

thead{
    position:sticky;
    top:0;
    z-index:2;
}

th{
    background:var(--green);
    color:white;
    padding:14px 12px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.3px;
}

td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid var(--border);
}

tbody tr:hover{
    background:var(--green-soft);
}

/* ==========================
   RESPONSIVE
========================== */

@media(max-width:800px){
    .graficos{
        grid-template-columns:1fr;
    }
    .chart-container{
        max-width:220px;
        height:220px;
    }
    .cards{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:500px){
    .cards{
        grid-template-columns:1fr;
    }
    .header-card h1{
        font-size:1.6rem;
    }
    .header-card .nombre-tacho{
        font-size:1rem;
    }
}

</style>

</head>

<body>

<div class="estadisticas-container">

    <div class="header-card">

<a href="<?= site_url('usuario/mis-tachos') ?>" class="volver">
    ← Volver
</a>

<h1>
Estadísticas <?= esc($tacho->nombre) ?> </h1>
</div>

    <!-- ===== TARJETAS ===== -->
    <div class="cards">

        <div class="card">
            <h3>Total Clasificaciones</h3>
            <h2><?= $total ?></h2>
        </div>

        <div class="card">
            <h3>Clasificaciones Hoy</h3>
            <h2><?= $hoy['cantidad'] ?></h2>
        </div>

        <div class="card">
            <h3>Confianza Promedio</h3>
            <h2><?= round($promedio['promedio'] * 100, 2) ?>%</h2>
        </div>

    </div>

    <!-- ===== GRÁFICOS Y RESUMEN ===== -->
    <div class="graficos">

        <div class="panel">

            <h2>Distribución de residuos</h2>

            <div class="chart-container">
                <canvas id="grafico"></canvas>
            </div>

        </div>

        <div class="panel">

            <h2>Resumen</h2>

            <?php
            $residuos = json_decode($labels);
            $cantidades = json_decode($datos);
            for($i=0; $i<count($residuos); $i++):
            ?>
                <div class="resumen-item">
                    <strong><?= ucfirst($residuos[$i]) ?></strong>
                    <span><?= $cantidades[$i] ?></span>
                </div>
            <?php endfor; ?>

        </div>

    </div>

    <!-- ===== TABLA ===== -->
    <div class="tabla-container">

        <h2>Últimas Clasificaciones</h2>

        <div class="table-scroll">

            <table>

                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Residuo</th>
                        <th>Confianza</th>
                        <th>Tipo</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach($ultimos as $fila): ?>
                    <tr>
                        <td><?= $fila['fecha_hora'] ?></td>
                        <td><?= ucfirst($fila['residuo']) ?></td>
                        <td><?= round($fila['confianza'] * 100,2) ?>%</td>
                        <td><?= ucfirst($fila['clasificacion']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

new Chart(
    document.getElementById('grafico'),
    {
        type:'pie',
        data:{
            labels: <?= $labels ?>,
            datasets:[{
                data: <?= $datos ?>,
                backgroundColor: [
                    '#2f7a3f', '#4ea25c', '#8bc34a', '#c8f257', '#aed581'
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{
                legend:{
                    position:'bottom'
                }
            }
        }
    }
);

</script>

</body>
</html>