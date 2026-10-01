<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EcoS-cam- Mercado Pago</title>

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f5f5f5;
            min-height: 100vh;
            color: #333;
        }

        /* =========================
           HEADER
        ========================= */

        .header {
            height: 64px;
            background: #ffe600;
            display: flex;
            align-items: center;
            padding: 0 7%;
            box-shadow: 0 1px 3px rgba(0,0,0,.12);
        }

        .mp-logo {
            font-size: 25px;
            font-weight: bold;
            color: #111;
            letter-spacing: -1px;
        }

        .mp-logo i {
            margin-right: 8px;
            font-size: 22px;
        }

        /* =========================
           CONTENEDOR
        ========================= */

        .page {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .checkout {
            display: grid;
            grid-template-columns: 1.35fr .75fr;
            gap: 25px;
            align-items: start;
        }

        /* =========================
           TARJETAS
        ========================= */

        .card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,.10);
        }

        /* =========================
           PRODUCTO
        ========================= */

        .product-card {
            padding: 30px;
        }

        .back {
            color: #3483fa;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 25px;
        }

        .back:hover {
            text-decoration: underline;
        }

        .product {
            display: flex;
            gap: 25px;
            padding-bottom: 30px;
            border-bottom: 1px solid #eee;
        }

        .product-image {
            width: 230px;
            height: 230px;
            border-radius: 8px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .product-info {
            padding-top: 5px;
        }

        .product-info h1 {
            font-size: 25px;
            font-weight: 400;
            color: #333;
            margin-bottom: 12px;
        }

        .product-description {
            color: #666;
            font-size: 15px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .rating {
            color: #3483fa;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .price {
            font-size: 34px;
            color: #333;
            font-weight: 400;
            margin-bottom: 6px;
        }

        .installments {
            color: #00a650;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .shipping {
            color: #00a650;
            font-size: 14px;
            margin-top: 12px;
        }

        /* =========================
           CARACTERÍSTICAS
        ========================= */

        .features {
            padding-top: 28px;
        }

        .features h2 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 22px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
        }

        .feature-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #eaf3ff;
            color: #3483fa;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .feature-text strong {
            display: block;
            font-size: 15px;
            margin-bottom: 3px;
        }

        .feature-text span {
            color: #777;
            font-size: 13px;
        }

        /* =========================
           RESUMEN
        ========================= */

        .summary-card {
            padding: 25px;
        }

        .summary-card h2 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 25px;
        }

        .summary-product {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .summary-image {
            width: 65px;
            height: 65px;
            border-radius: 6px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .summary-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .summary-product-info {
            flex: 1;
        }

        .summary-product-info strong {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .summary-product-info span {
            color: #777;
            font-size: 13px;
        }

        .summary-price {
            font-size: 14px;
            font-weight: bold;
        }

        /* =========================
           DETALLES PRECIO
        ========================= */

        .price-details {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
            color: #555;
        }

        .price-row:last-child {
            margin-bottom: 0;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .total span:first-child {
            font-size: 18px;
        }

        .total-price {
            font-size: 28px;
            font-weight: 500;
        }

        /* =========================
           MÉTODO DE PAGO
        ========================= */

        .payment-method {
            border: 1px solid #ddd;
            border-radius: 7px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .payment-method-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .payment-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #eaf3ff;
            color: #3483fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .payment-method-title strong {
            font-size: 14px;
        }

        .payment-method-title span {
            display: block;
            color: #777;
            font-size: 12px;
            margin-top: 3px;
        }

        /* =========================
           BOTÓN
        ========================= */

        .btn-payment {
            display: block;
            width: 100%;
            border: none;
            border-radius: 6px;
            padding: 15px;
            background: #3483fa;
            color: white;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: .2s;
        }

        .btn-payment:hover {
            background: #2968c8;
        }

        .security {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            color: #777;
            font-size: 12px;
            line-height: 1.4;
        }

        .security i {
            color: #3483fa;
            font-size: 16px;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #888;
            font-size: 12px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 850px) {

            .checkout {
                grid-template-columns: 1fr;
            }

            .product {
                flex-direction: column;
            }

            .product-image {
                width: 100%;
                height: 280px;
            }

            .header {
                padding: 0 20px;
            }
        }

        @media (max-width: 500px) {

            .page {
                margin: 15px auto;
                padding: 0 10px;
            }

            .product-card,
            .summary-card {
                padding: 20px;
            }

            .price {
                font-size: 28px;
            }

            .total-price {
                font-size: 24px;
            }
        }

    </style>
</head>

<body>

<!-- =========================
     HEADER MERCADO PAGO
========================= -->

<header class="header">

    <div class="mp-logo">
        <i class="fas fa-hand-holding-dollar"></i>
        Mercado Pago
    </div>

</header>


<div class="page">

    <div class="checkout">

        <!-- =========================
             PRODUCTO
        ========================= -->

        <div class="card product-card">

            <a href="javascript:history.back()" class="back">
                <i class="fas fa-arrow-left"></i>
                Volver
            </a>


            <div class="product">

                <div class="product-image">

                    <!-- ==========================================
                         REEMPLAZAR ESTA URL POR LA FOTO REAL
                    =========================================== -->

                   <img src="<?= base_url('img/ecoscam-fisico.png') ?>" alt="EcoS-cam">

                </div>


                <div class="product-info">

                    <h1>
                     Tacho   EcoS-cam 
                    </h1>

                    <div class="rating">
                        <i class="fas fa-star"></i>
                        Sistema de reciclaje inteligente
                    </div>

                 

                    <div class="price">
                        $420.000
                    </div>

                    <div class="installments">
                        Podés pagar de forma segura con Mercado Pago
                    </div>

                    <div class="shipping">
                        <i class="fas fa-check"></i>
                        Acceso premium incluido
                    </div>

                </div>

            </div>


            <!-- =========================
                 BENEFICIOS
            ========================= -->

            <div class="features">

                <h2>
                    Incluye
                </h2>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>

                    <div class="feature-text">
                        <strong>Estadísticas avanzadas</strong>
                        <span>
                            Visualizá el rendimiento de tus Eco-Tachos.
                        </span>
                    </div>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fas fa-clock-rotate-left"></i>
                    </div>

                    <div class="feature-text">
                        <strong>Historial completo</strong>
                        <span>
                            Consultá todas las clasificaciones realizadas.
                        </span>
                    </div>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        <i class="fas fa-trophy"></i>
                    </div>

                    <div class="feature-text">
                        <strong>Logros y recompensas</strong>
                        <span>
                            Accedé al sistema de logros premium de EcoS-cam.
                        </span>
                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             RESUMEN DE COMPRA
        ========================= -->

        <div class="card summary-card">

            <h2>
                Resumen de compra
            </h2>


            <div class="summary-product">

                <div class="summary-image">

                    <!-- MISMA FOTO DEL PRODUCTO -->

                <img src="<?= base_url('img/ecoscam-fisico.png') ?>" alt="EcoS-cam">

                </div>


                <div class="summary-product-info">

                    <strong>
                       Tacho EcoS-cam
                    </strong>

                 

                </div>

                <div class="summary-price">
                    $420.000
                </div>

            </div>


            <!-- =========================
                 PRECIO
            ========================= -->

            <div class="price-details">

                <div class="price-row">

                    <span>
                        Producto
                    </span>

                    <span>
                        $420.000
                    </span>

                </div>


                <div class="price-row">

                    <span>
                        Descuento
                    </span>

                    <span>
                        $0
                    </span>

                </div>


                <div class="price-row">

                    <span>
                        Envío
                    </span>

                    <span>
                        Gratis
                    </span>

                </div>

            </div>


            <div class="total">

                <span>
                    Total
                </span>

                <span class="total-price">
                    $420.000
                </span>

            </div>


            <!-- =========================
                 MÉTODO DE PAGO
            ========================= -->

            <div class="payment-method">

                <div class="payment-method-title">

                    <div class="payment-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>

                    <div>

                        <strong>
                            Mercado Pago
                        </strong>

                        <span>
                            Tarjetas, dinero en cuenta y otros medios
                        </span>

                    </div>

                </div>

            </div>


            <!-- =========================
                 BOTÓN
            ========================= -->

            <a
                href="<?= site_url('pagos/crear-preferencia') ?>"
                class="btn-payment">

                Continuar al pago

            </a>


            <!-- =========================
                 SEGURIDAD
            ========================= -->

            <div class="security">

                <i class="fas fa-shield-halved"></i>

                <span>
                    Tus datos están protegidos.
                    El pago será procesado de forma segura mediante Mercado Pago.
                </span>

            </div>

        </div>

    </div>


    <div class="footer">

        <i class="fas fa-lock"></i>
        Compra segura · EcoS-cam

    </div>

</div>

</body>
</html>