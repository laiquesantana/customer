<?php

namespace app\controllers;

use app\adapters\ConfigAdapter;
use app\components\JwtAuth;
use Yii;
use yii\rest\Controller;
use app\repositories\BookRepository;
use app\adapters\Http\ClientAdapter;
use core\Modules\Book\Create\UseCase as CreateBookUseCase;
use core\Modules\Book\List\UseCase as ListBookUseCase;
use app\models\Book;

class BookController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Apply JWT authentication
        $behaviors['authenticator'] = [
            'class' => JwtAuth::class,
            'except' => ['options'],
        ];
        $behaviors['contentNegotiator']['formats']['application/json'] = \yii\web\Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @OA\Post(
     *     path="/book",
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="isbn", type="string", example="9788535902777"),
     *             @OA\Property(property="title", type="string", example="Clean Code"),
     *             @OA\Property(property="author", type="string", example="Robert C. Martin"),
     *             @OA\Property(property="price", type="number", format="float", example="45.99"),
     *             @OA\Property(property="stock", type="integer", example=100)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", description="ID of the created book")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation failed"),
     *     security={{"bearerAuth": {}}}
     * )
     */

    public function actionCreate(): array
    {
        $data = Yii::$app->request->post();
        $model = new Book();
        $model->setAttributes($data);

        if (!$model->validate()) {
            Yii::$app->response->statusCode = 422;
            return [
                'errors' => $model->getErrors(),
            ];
        }

        $bookGateway = new BookRepository();
        $clientAdapter = new ClientAdapter();
        $configAdapter = new ConfigAdapter();

        // Create UseCase and execute
        $useCase = new CreateBookUseCase(
            $bookGateway,
            $clientAdapter,
            $configAdapter
        );

        $useCase->execute($data);

        return $useCase->getResponse()->present();
    }

    /**
     * Lists all books.
     */
    public function actionList(): array
    {
        $params = Yii::$app->request->get();
        $bookGateway = new BookRepository();
        $useCase = new ListBookUseCase($bookGateway);
        $useCase->execute($params);
        return $useCase->getResponse()->present();
    }
}
