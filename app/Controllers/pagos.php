<?php


namespace App\Controllers;


use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use Config\MercadoPago as MPConfig;


class Pagos extends BaseController
{
    public function __construct()
    {
        // Configura el SDK con tu Access Token de prueba
        $config = new MPConfig();
        MercadoPagoConfig::setAccessToken($config->accessToken);
    }


    /**
     * Muestra la vista de checkout (tu HTML ya hecho).
     */
    public function checkout()
    {
        return view('pagos/checkout');
    }


    /**
     * Se ejecuta cuando el usuario hace clic en "Pagar con PayPal/MercadoPago".
     * Crea la preferencia de pago y redirige al Checkout Pro de MercadoPago.
     */
    public function crearPreferencia()
{
    $client = new PreferenceClient();


    $preference = $client->create([
        "items" => [
            [
                "title"       => "EcoScam Premium",
                "quantity"    => 1,
                "unit_price"  => 420000,
                "currency_id" => "ARS",
            ]
        ],
        "external_reference" => session()->get('user_id')
            ? (string) session()->get('user_id')
            : uniqid('pedido_'),
    ]);


    return redirect()->to($preference->sandbox_init_point);
}


    /**
     * Vuelta desde MercadoPago cuando el pago fue aprobado.
     */
    public function exito()
    {
        $status    = $this->request->getGet('status');
        $paymentId = $this->request->getGet('payment_id');
        $external  = $this->request->getGet('external_reference');


        // Acá, en un hito posterior, guardarías el pago en tu BD:
        // this->pagoModel->registrar(paymentId, $status, $external, ...);


        return view('pagos/exito', [
            'payment_id' => $paymentId,
            'status'     => $status,
        ]);
    }


    /**
     * Vuelta desde MercadoPago cuando el pago fue rechazado.
     */
    public function error()
    {
        return view('pagos/error');
    }


    /**
     * Vuelta desde MercadoPago cuando el pago quedó pendiente
     * (ej: pago en efectivo tipo Rapipago/Pago Fácil).
     */
    public function pendiente()
    {
        $paymentId = $this->request->getGet('payment_id');


        return view('pagos/pendiente', [
            'payment_id' => $paymentId,
        ]);
    }


    /**
     * Webhook: MercadoPago notifica acá directamente (servidor a servidor),
     * más confiable que confiar solo en la redirección del navegador.
     * Configurá esta URL en el panel de tu aplicación (Webhooks).
     */
    public function webhook()
    {
        $payload = $this->request->getJSON();


        log_message('info', 'Webhook MercadoPago: ' . json_encode($payload));


        // Acá procesarías la notificación real (consultar el pago por su ID
        // contra la API de MercadoPago y actualizar tu BD).


        return $this->response->setStatusCode(200);
    }
}

