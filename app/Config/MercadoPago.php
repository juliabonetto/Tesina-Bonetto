<?php
 
namespace Config;
 
use CodeIgniter\Config\BaseConfig;
 
class MercadoPago extends BaseConfig
{
    /**
     * Access Token de prueba (o de producción, según el entorno).
     * Se lee desde .env para no exponerlo en el código.
     */
    public string $accessToken;
 
    /**
     * Public Key, por si la necesitás en el frontend (Checkout Bricks, etc.)
     */
    public string $publicKey;
 
    public function __construct()
    {
        parent::__construct();
 
        $this->accessToken = env('mercadopago.accessToken', '');
        $this->publicKey   = env('mercadopago.publicKey', '');
    }
}

