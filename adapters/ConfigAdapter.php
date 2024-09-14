<?php

namespace app\adapters;

use yii\base\BaseObject;
use yii\base\InvalidConfigException;

class ConfigAdapter extends BaseObject
{
    public function getJwtSecret(): string
    {
        return $this->getConfig('JWT_SECRET_KEY');
    }

    public function getJwtIssuer(): string
    {
        return $this->getConfig('JWT_ISSUER');
    }

    public function getJwtAudience(): string
    {
        return $this->getConfig('JWT_AUDIENCE');
    }

    public function getBrasilApiBaseUrl(): string
    {
        return $this->getConfig('BRASILAPI_BASE_URL') ?? 'https://brasilapi.com.br';
    }

    public function getJwtExpiry(): int
    {
        return (int)$this->getConfig('JWT_EXPIRY', 3600);
    }

    private function getConfig(string $name, string $defaultValue = null): string
    {
        $config = getenv($name) ?: $defaultValue;
        if (is_null($config)) {
            throw new InvalidConfigException(sprintf("The environment variable %s is not set", $name));
        }

        return $config;
    }
}
