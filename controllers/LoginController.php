<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\User;
use yii\web\UnauthorizedHttpException;

class LoginController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $username = $request->post('username');
        $password = $request->post('password');

        $user = User::findOne(['username' => $username]);

        if ($user && $user->validatePassword($password)) {
            $token = $user->generateJwtToken();
            return ['token' => $token];
        } else {
            throw new UnauthorizedHttpException('Invalid username or password');
        }
    }
}
