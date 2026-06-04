<?php

namespace App\Controllers;

use App\Models\PagoModel;

class Webhook extends BaseController
{
    private $accessToken = 'TU_ACCESS_TOKEN';

    public function mercadoPago()
    {
        $json = file_get_contents('php://input');

        $data = json_decode($json, true);

        if (
            isset($data['type']) &&
            $data['type'] == 'payment'
        ) {

            $paymentId = $data['data']['id'];

            $url = "https://api.mercadopago.com/v1/payments/$paymentId";

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Bearer {$this->accessToken}"
                ]
            ]);

            $response = curl_exec($ch);

            curl_close($ch);

            $payment = json_decode($response, true);

            $pagoModel = new PagoModel();

            $pagoModel->insert([
                'usuario_id' => 1,
                'plan_id' => 1,
                'payment_id' => $paymentId,
                'estado' => $payment['status'],
                'monto' => $payment['transaction_amount']
            ]);
        }

        return $this->response->setStatusCode(200);
    }
}