<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class SwaggerController extends Controller
{
    public function actionJson(): \yii\web\Response
    {
        dd("asd");
        $openapi = \OpenApi\scan(Yii::getAlias('@app/controllers'));
        return $this->asJson($openapi);
    }
}
