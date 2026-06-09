<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Aprobado - EcoScam</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background:#f5f7fa;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
        }

        .success-card{

            width:100%;
            max-width:900px;

            background:white;

            border-radius:20px;

            overflow:hidden;

            box-shadow:0 10px 40px rgba(0,0,0,.12);

            display:grid;
            grid-template-columns:1.2fr 1fr;
        }

        .left{

            padding:50px;
        }

        .logo{

            color:#003087;
            font-size:38px;
            font-weight:bold;

            margin-bottom:40px;
        }

        .logo span{

            color:#009cde;
        }

        .estado{

            display:flex;
            align-items:center;
            gap:15px;

            margin-bottom:25px;
        }

        .estado i{

            color:#28a745;
            font-size:60px;
        }

        .estado h1{

            color:#333;
        }

        .mensaje{

            color:#666;
            line-height:1.7;
            margin-bottom:30px;
        }

        .beneficios{

            background:#f8f9fa;

            padding:20px;

            border-radius:12px;
        }

        .beneficios h3{

            margin-bottom:15px;
            color:#333;
        }

        .beneficios ul{

            list-style:none;
        }

        .beneficios li{

            margin-bottom:12px;
            color:#555;
        }

        .beneficios i{

            color:#28a745;
            margin-right:8px;
        }

        .right{

            background:#fafafa;

            border-left:1px solid #eee;

            display:flex;

            flex-direction:column;

            justify-content:center;

            align-items:center;

            padding:50px;
        }

        .circle{

            width:140px;
            height:140px;

            border-radius:50%;

            background:#28a745;

            display:flex;

            justify-content:center;

            align-items:center;

            margin-bottom:25px;
        }

        .circle i{

            color:white;
            font-size:70px;
        }

        .right h2{

            color:#28a745;
            margin-bottom:15px;
        }

        .right p{

            color:#666;
            text-align:center;
            line-height:1.6;
            margin-bottom:30px;
        }

        .btn{

            display:inline-block;

            text-decoration:none;

            background:#0070ba;

            color:white;

            padding:15px 30px;

            border-radius:8px;

            font-weight:bold;

            transition:.3s;
        }

        .btn:hover{

            background:#005ea6;
        }

        @media(max-width:900px){

            .success-card{

                grid-template-columns:1fr;
            }

            .right{

                border-left:none;
                border-top:1px solid #eee;
            }
        }

    </style>

</head>

<body>

<div class="success-card">

    <div class="left">

        <div class="logo">
            Pay<span>Pal</span>
        </div>

        <div class="estado">

            <i class="fas fa-check-circle"></i>

            <h1>Pago aprobado</h1>

        </div>

        <p class="mensaje">

            Tu suscripción <strong>EcoScam Premium</strong>
            ha sido activada correctamente.

            Ya puedes acceder a todas las funciones exclusivas
            de la plataforma.

        </p>

        <div class="beneficios">

            <h3>Beneficios habilitados</h3>

            <ul>

                <li>
                    <i class="fas fa-check"></i>
                    Estadísticas avanzadas
                </li>

                <li>
                    <i class="fas fa-check"></i>
                    Historial completo
                </li>

                <li>
                    <i class="fas fa-check"></i>
                    Logros premium
                </li>

          
            </ul>

        </div>

    </div>

    <div class="right">

        <div class="circle">

            <i class="fas fa-check"></i>

        </div>

        <h2>Transacción exitosa</h2>

        <p>

            El pago fue procesado correctamente y tu cuenta
            ya dispone de los beneficios Premium.

        </p>

        <a href="<?= base_url('usuario/principal') ?>" class="btn">
            Ir al Panel Principal
        </a>

    </div>

</div>

</body>
</html>