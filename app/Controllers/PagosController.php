<?php

namespace App\Controllers;

use App\Models\PagoModel;

class PagosController extends BaseController
{
    private $accessToken = 'TU_ACCESS_TOKEN';

    public function comprar($planId)
    {
        $planes = [
            1 => [
                'nombre' => 'EcoScam Premium',
                'precio' => 5000
            ]
        ];

        if (!isset($planes[$planId])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $plan = $planes[$planId];

        $body = [
            "items" => [
                [
                    "title" => "EcoScam",
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => 5000
                ]
            ],
            "back_urls" => [
                "success" => base_url('pagos/exito'),
                "failure" => base_url('pagos/error'),
                "pending" => base_url('pagos/pendiente')
            ],
            "auto_return" => "approved",
            "external_reference" => session()->get('usuario_id'),
            "notification_url" => base_url('pagos/webhook')
        ];
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.mercadopago.com/checkout/preferences",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->accessToken}",
                "Content-Type: application/json"
            ],
            CURLOPT_POSTFIELDS => json_encode($body)
        ]);

        $response = curl_exec($ch);

        curl_close($ch);

        $preference = json_decode($response, true);

        return redirect()->to($preference['init_point']);
    }

    public function exito()
    {
        return view('pagos/exito');
    }

    public function error()
    {
        return view('pagos/error');
    }

    public function pendiente()
    {
        return view('pagos/pendiente');
    }
}