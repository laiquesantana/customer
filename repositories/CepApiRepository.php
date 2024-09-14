<?php
namespace app\repositories;

use app\core\Dependencies\Http\HttpClientInterface;
use app\core\Modules\Customer\Create\Gateways\CepGateway;

class CepApiRepository implements CepGateway
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchAddressByCep(string $cep): array
    {
        $endpoint = "https://brasilapi.com.br/api/cep/v1/{$cep}";
        $response = $this->httpClient->get($endpoint);

        $data = json_decode($response, true);

        if (isset($data['errors'])) {
            throw new \Exception('CEP not found');
        }

        return [
            'street' => $data['street'] ?? '',
            'city' => $data['city'] ?? '',
            'state' => $data['state'] ?? '',
        ];
    }
}
