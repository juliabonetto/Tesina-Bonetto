<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Estadísticas | EcoS-cam</title>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

:root{
    --bg:#f4f1ea;
    --ink:#14241b;
    --ink-soft:#3a4a40;
    --green:#1f6b3a;
    --lime:#c8f257;
    --radius:22px;
    --serif:'Fraunces', Georgia, serif;
    --sans:'Inter', system-ui, sans-serif;
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
    padding:30px;
}

.estadisticas-container{
    max-width:1200px;
    margin:auto;
}

/* ==========================
   HEADER
========================== */

.header-card{
    background:white;
    border-radius:var(--radius);
    border:2px solid var(--green);
    box-shadow:0 12px 30px rgba(20,36,27,.15);
    padding:30px;
    margin-bottom:25px;
    position:relative;
}

.header-card h1{
    text-align:center;
    color:var(--green);
    font-family:var(--serif);
    font-size:2rem;
}

.volver{
    position:absolute;
    top:20px;
    left:20px;

    background:var(--ink);
    color:white;

    text-decoration:none;

    padding:10px 18px;

    border-radius:10px;

    transition:.3s;
}

.volver:hover{
    background:var(--green);
}

/* ==========================
   CARDS
========================== */

.cards{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card{
    background:white;
    border-radius:18px;
    border:2px solid var(--green);
    padding:25px;
    text-align:center;
    box-shadow:0 8px 20px rgba(20,36,27,.10);
}

.card h3{
    color:var(--ink-soft);
    margin-bottom:10px;
}

.card h2{
    color:var(--green);
    font-size:2rem;
}

/* ==========================
   GRAFICOS
========================== */

.graficos{
    display:grid;
    grid-template-columns:380px 1fr;
    gap:25px;
    margin-bottom:25px;
}

.panel{
    background:white;
    border-radius:var(--radius);
    border:2px solid var(--green);
    padding:25px;
    box-shadow:0 8px 20px rgba(20,36,27,.10);
}

.panel h2{
    color:var(--green);
    margin-bottom:20px;
}

.chart-container{
    width:280px;
    height:280px;
    margin:auto;
}

.resumen-item{
    display:flex;
    justify-content:space-between;
    padding:12px;
    border-bottom:1px solid #eee;
}

.resumen-item:last-child{
    border-bottom:none;
}

/* ==========================
   TABLA
========================== */

.tabla-container{
    background:white;
    border-radius:var(--radius);
    border:2px solid var(--green);
    padding:25px;
    box-shadow:0 8px 20px rgba(20,36,27,.10);
}

.tabla-container h2{
    color:var(--green);
    margin-bottom:20px;
}

.table-scroll{
    max-height:350px;
    overflow-y:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    position:sticky;
    top:0;
}

th{
    background:var(--green);
    color:white;
}

th,td{
    padding:12px;
    text-align:center;
}

tr:nth-child(even){
    background:#f8f8f8;
}

/* ==========================
   RESPONSIVE
========================== */

@media(max-width:900px){

    .cards{
        grid-template-columns:1fr;
    }

    .graficos{
        grid-template-columns:1fr;
    }

    .chart-container{
        width:220px;
        height:220px;
    }

}

</style>

</head>

<body>

<div class="estadisticas-container">

    <!-- HEADER -->

    <div class="header-card">

        <a href="<?= site_url('usuario/principal') ?>" class="volver">
            ← Volver
        </a>

        <h1>Estadísticas EcoS-cam</h1>

    </div>

    <!-- TARJETAS -->

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

    <!-- GRAFICOS -->

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

                    <strong>
                        <?= ucfirst($residuos[$i]) ?>
                    </strong>

                    <span>
                        <?= $cantidades[$i] ?>
                    </span>

                </div>

            <?php endfor; ?>

        </div>

    </div>

    <!-- TABLA -->

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

                        <td>
                            <?= $fila['fecha_hora'] ?>
                        </td>

                        <td>
                            <?= ucfirst($fila['residuo']) ?>
                        </td>

                        <td>
                            <?= round($fila['confianza'] * 100,2) ?>%
                        </td>

                        <td>
                            <?= ucfirst($fila['clasificacion']) ?>
                        </td>

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
                data: <?= $datos ?>
            }]
        },

        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    }
);

</script>

</body>
</html>