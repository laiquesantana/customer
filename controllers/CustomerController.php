<?php

namespace app\controllers;

use app\adapters\Http\ClientAdapter;
use app\components\JwtAuth;
use app\repositories\CepApiRepository;
use app\repositories\CustomerRepository;
use Yii;
use yii\rest\Controller;
use core\Modules\Customer\List\UseCase as ListUseCase;
use core\Modules\Customer\Create\UseCase as CreateUseCase;
use app\models\Customer;

class CustomerController extends Controller
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
     *     path="/customer",
     *     summary="Cria um novo cliente",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="cpf", type="string"),
     *             @OA\Property(property="cep", type="string"),
     *             @OA\Property(property="number", type="string"),
     *             @OA\Property(property="gender", type="string"),
     *             @OA\Property(property="complement", type="string", nullable=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cliente criado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Dados inválidos"),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function actionCreate(): array
    {
        $data = Yii::$app->request->post();
        $model = new Customer();
        $model->setAttributes($data);
        if (!$model->validate()) {
            Yii::$app->response->statusCode = 422;
            return [
                'errors' => $model->getErrors(),
            ];
        }
        $customerGateway = new CustomerRepository();
        $httpClient = new ClientAdapter();
        $cepGateway = new CepApiRepository($httpClient);

        $useCase = new CreateUseCase(
            $customerGateway,
            $cepGateway
        );

        $useCase->execute($data);

        return $useCase->getResponse()->present();
    }
    /**
     * @OA\Get(
     *     path="/customer",
     *     summary="Listagem de clientes",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nome do cliente para filtro",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="cpf",
     *         in="query",
     *         description="CPF do cliente para filtro",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Clientes listados com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Customer"))
     *         )
     *     ),
     *     @OA\Response(response=500, description="Erro ao buscar clientes"),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function actionList(): array
    {
        $params = Yii::$app->request->get();

        $customerGateway = new CustomerRepository();

        $useCase = new ListUseCase($customerGateway);

        $useCase->execute($params);
        return $useCase->getResponse()->present();
    }
}
