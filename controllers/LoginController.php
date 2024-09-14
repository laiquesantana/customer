<?php

namespace app\controllers;

use app\adapters\ConfigAdapter;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
use core\Modules\Login\UseCase;
use app\repositories\AuthRepository;

class LoginController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * Action para realizar o login de um usuário e retornar o JWT Token.
     *
     * @return array
     * @throws UnauthorizedHttpException
     * @throws BadRequestHttpException
     */
    public function actionIndex(): array
    {
        $data = Yii::$app->request->post();

        if (empty($data['username']) || empty($data['password'])) {
            throw new BadRequestHttpException('Username and password are required');
        }

        $authGateway = new AuthRepository();

        $useCase = new UseCase($authGateway, new ConfigAdapter());

        try {
            $useCase->execute($data);
            return $useCase->getResponse()->present();
        } catch (\Exception $e) {
            throw new UnauthorizedHttpException($e->getMessage());
        }
    }
}
