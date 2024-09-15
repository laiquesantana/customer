<?php

namespace core\Modules\Login;

use core\Modules\Login\Gateways\AuthGateway;
use Firebase\JWT\JWT;
use core\Modules\Generics\Entities\Status;
use core\Responses\Response;
use core\Responses\ResponseInterface;
use core\Presenters\JsonResponsePresenter;
use app\Adapters\ConfigAdapter;

class UseCase
{
    private AuthGateway $authGateway;
    private ConfigAdapter $config;
    private Response $response;

    public function __construct(AuthGateway $authGateway, ConfigAdapter $config)
    {
        $this->authGateway = $authGateway;
        $this->config = $config;
        $this->response = new Response(new JsonResponsePresenter());
    }

    /**
     * Executa o login e gera o JWT Token.
     *
     * @param array $data
     * @throws \Exception Se autenticação falhar
     */
    public function execute(array $data): void
    {
        $userEntity = $this->authGateway->findUserByUsername($data['username']);

        if ($userEntity === null) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(401)->setMessage('Invalid username or password')
                );
            return;
        }

        if (!$this->authGateway->validatePassword($userEntity->getUsername(), $data['password'])) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(401)->setMessage('Invalid username or password')
                );
            return;
        }

        $jwtSecret = $this->config->getJwtSecret();
        $jwtExpirationTime = (int)$this->config->getJwtExpiry();

        $payload = [
            'iss' => $this->config->getJwtIssuer(),
            'aud' => $this->config->getJwtAudience(),
            'iat' => time(),
            'exp' => time() + $jwtExpirationTime,
            'uid' => $userEntity->getId(),
        ];

        $token = JWT::encode($payload, $jwtSecret, 'HS256');

        $this->response
            ->setStatus(
                (new Status())->setCode(200)->setMessage('Login successful')
            )
            ->setData([
                'token' => $token,
                'expires_in' => $jwtExpirationTime,
            ]);
    }

    /**
     * Retorna a resposta padronizada.
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
