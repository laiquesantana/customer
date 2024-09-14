<?php

namespace app\components;

use yii\filters\auth\AuthMethod;
use Yii;
use Firebase\JWT\JWT;
use yii\web\UnauthorizedHttpException;

class JwtAuth extends AuthMethod
{
    public function authenticate($user, $request, $response): ?\yii\web\IdentityInterface
    {
        $authHeader = $request->getHeaders()->get('Authorization');
        if ($authHeader !== null && preg_match('/^Bearer\s+(.*?)$/', $authHeader, $matches)) {
            $token = $matches[1];
            try {
                $identity = $user->loginByAccessToken($token, get_class($this));
                if ($identity !== null) {
                    return $identity;
                }
            } catch (\Exception $e) {
                throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
            }
        }
        return null;
    }
}
