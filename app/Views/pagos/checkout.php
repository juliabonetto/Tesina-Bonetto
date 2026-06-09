<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago con PayPal - EcoScam</title>

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

        .checkout-container{
            width:100%;
            max-width:1100px;
            background:white;
            border-radius:20px;
            overflow:hidden;
            box-shadow:0 10px 40px rgba(0,0,0,.12);

            display:grid;
            grid-template-columns: 1.3fr 1fr;
        }

        /* PANEL IZQUIERDO */

        .left{
            padding:50px;
        }

        .paypal-logo{
            color:#003087;
            font-size:38px;
            font-weight:bold;
            margin-bottom:40px;
        }

        .paypal-logo span{
            color:#009cde;
        }

        .welcome{
            color:#666;
            margin-bottom:30px;
        }

        .producto{
            border-bottom:1px solid #ddd;
            padding-bottom:25px;
            margin-bottom:25px;
        }

        .producto h2{
            color:#333;
            margin-bottom:15px;
        }

        .producto p{
            color:#666;
            line-height:1.6;
        }

        .beneficios{
            margin-top:25px;
        }

        .beneficio{
            display:flex;
            align-items:center;
            gap:10px;
            margin-bottom:15px;
            color:#444;
        }

        .beneficio i{
            color:#28a745;
        }

        .metodo-pago{
            margin-top:40px;
            border:1px solid #ddd;
            border-radius:10px;
            padding:20px;
        }

        .metodo-pago h3{
            margin-bottom:15px;
            color:#333;
        }

        .paypal-option{
            display:flex;
            align-items:center;
            gap:12px;
            color:#003087;
            font-weight:bold;
        }

        /* PANEL DERECHO */

        .right{
            background:#fafafa;
            padding:50px;
            border-left:1px solid #eee;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .resumen-title{
            font-size:26px;
            margin-bottom:30px;
            color:#333;
        }

        .fila{
            display:flex;
            justify-content:space-between;
            margin-bottom:18px;
            color:#555;
        }

        .total{
            margin-top:25px;
            padding-top:20px;
            border-top:1px solid #ddd;
            font-size:24px;
            font-weight:bold;
            color:#222;
        }

        .security-box{
            margin:35px 0;
            text-align:center;
        }

        .security-box i{
            font-size:65px;
            color:#009cde;
            margin-bottom:15px;
        }

        .security-box h3{
            color:#333;
            margin-bottom:10px;
        }

        .security-box p{
            color:#777;
            line-height:1.5;
        }

        .btn-paypal{
            width:100%;
            background:#0070ba;
            color:white;
            border:none;
            border-radius:8px;
            padding:18px;
            font-size:18px;
            font-weight:bold;
            cursor:pointer;
            transition:.3s;
        }

        .btn-paypal:hover{
            background:#005ea6;
        }

        .footer-text{
            text-align:center;
            margin-top:15px;
            font-size:13px;
            color:#888;
        }

        @media(max-width:900px){

            .checkout-container{
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

<div class="checkout-container">

    <!-- IZQUIERDA -->

    <div class="left">

        <div class="paypal-logo">
            Pay<span>Pal</span>
        </div>

        <p class="welcome">
            Estás a punto de adquirir una suscripción premium de EcoScam.
        </p>

        <div class="producto">

            <h2>EcoScam Premium</h2>

            <p>
                Accede a funciones exclusivas y mejora tu experiencia dentro
                de la plataforma de reciclaje inteligente.
            </p>

        </div>

        <div class="beneficios">

            <div class="beneficio">
                <i class="fas fa-check-circle"></i>
                Estadísticas avanzadas
            </div>

            <div class="beneficio">
                <i class="fas fa-check-circle"></i>
                Historial completo de clasificaciones
            </div>

            <div class="beneficio">
                <i class="fas fa-check-circle"></i>
                Logros y recompensas premium
            </div>

   
        </div>

        <div class="metodo-pago">

            <h3>Método de pago</h3>

            <div class="paypal-option">
                <i class="fab fa-paypal fa-2x"></i>
                PayPal
            </div>

        </div>

    </div>

    <!-- DERECHA -->

    <div class="right">

        <h2 class="resumen-title">
            Resumen de compra
        </h2>

        <div class="fila">
            <span>Producto</span>
            <span>EcoS-cam Premium</span>
        </div>

        <div class="fila">
            <span>Garantía</span>
            <span>1 año</span>
        </div>

        <div class="fila">
            <span>Precio</span>
            <span>$200.000 ARS</span>
        </div>

        <div class="fila total">
            <span>Total</span>
            <span>$200.000 ARS</span>
        </div>

        <div class="security-box">

            <i class="fas fa-shield-alt"></i>

            <h3>Pago seguro</h3>

            <p>
                PayPal protege tus datos financieros y permite realizar
                pagos de forma rápida y segura.
            </p>

        </div>

        <!-- aca irá la API real -->

        <a href="<?= site_url('pagos/exito') ?>" class="btn-paypal">
  Pagar con PayPal
</a>
   


    </div>

</div>

</body>
</html>
