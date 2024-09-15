<?php

namespace core\Modules\Customer\Create;

use app\services\FileUploadService;
use core\Modules\Customer\Create\Entities\CustomerEntity;
use core\Modules\Customer\Create\Gateways\CepGateway;
use core\Modules\Customer\Create\Gateways\CustomerGateway;
use core\Responses\Response;
use core\Responses\ResponseInterface;
use core\Presenters\JsonResponsePresenter;
use core\Modules\Generics\Entities\Status;
use yii\web\UploadedFile;

class UseCase
{
    private CustomerGateway $customerGateway;
    private CepGateway $cepGateway;
    private FileUploadService $fileUploadService;
    private ResponseInterface $response;

    public function __construct(
        CustomerGateway $customerGateway,
        CepGateway $cepGateway,
        FileUploadService $fileUploadService
    ) {
        $this->customerGateway = $customerGateway;
        $this->cepGateway = $cepGateway;
        $this->fileUploadService = $fileUploadService;
        $this->response = new Response(new JsonResponsePresenter());
    }

    public function execute(array $data, ?UploadedFile $imageFile = null): void
    {
        try {
            // Busca os dados do CEP
            $cepData = $this->cepGateway->fetchAddressByCep($data['cep']);

            // Cria a entidade de cliente
            $customer = new CustomerEntity();
            $customer->name = $data['name'];
            $customer->cpf = $data['cpf'];
            $customer->cep = $data['cep'];
            $customer->address = $cepData['street'];
            $customer->city = $cepData['city'];
            $customer->state = $cepData['state'];
            $customer->number = $data['number'];
            $customer->complement = $data['complement'] ?? null;
            $customer->gender = $data['gender'];

            // Upload opcional de imagem
            if ($imageFile) {
                $imagePath = $this->fileUploadService->upload($imageFile, 'customers/');
                $customer->image_path = $imagePath;
            }

            // Salva o cliente
            $this->customerGateway->save($customer);

            $this->response
                ->setStatus(
                    (new Status())->setCode(201)->setMessage('Customer created successfully')
                )
                ->setData([$customer]);
        } catch (\Exception $e) {
            $this->response
                ->setStatus(
                    (new Status())->setCode(500)->setMessage('Failed to create customer')
                )
                ->setError($e->getMessage());
        }
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
