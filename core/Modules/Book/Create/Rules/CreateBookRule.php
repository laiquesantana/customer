<?php
namespace core\Modules\Book\Create\Rules;

use core\Modules\Book\Create\Entities\BookEntity;
use core\Modules\Book\Create\Gateways\BookGateway;
use app\adapters\Http\ClientAdapter;
use app\adapters\ConfigAdapter;
use Exception;

class CreateBookRule
{
    private BookGateway $bookGateway;
    private ClientAdapter $clientAdapter;
    private ConfigAdapter $configAdapter;
    private array $data;

    public function __construct(BookGateway $bookGateway, ClientAdapter $clientAdapter, ConfigAdapter $configAdapter)
    {
        $this->bookGateway = $bookGateway;
        $this->clientAdapter = $clientAdapter;
        $this->configAdapter = $configAdapter;
    }

    public function __invoke( array $data)
    {
        $this->data = $data;
        return $this;
    }

    public function apply(): BookEntity
    {
        if (isset($this->data['isbn']) && !empty($this->data['isbn'])) {
            $isbnData = $this->fetchBookDataFromApi($this->data['isbn']);
            if ($isbnData) {
                $this->data['title'] = $isbnData['title'] ?? $this->data['title'];
                $this->data['author'] = $isbnData['author'] ?? $this->data['author'];
            }
        }

        $book = new BookEntity();
        $book->setIsbn($this->data['isbn']);
        $book->setTitle($this->data['title']);
        $book->setAuthor($this->data['author']);
        $book->setPrice($this->data['price']);
        $book->setStock($this->data['stock']);

        return $this->bookGateway->save($book);
    }

    private function fetchBookDataFromApi(string $isbn): ?array
    {

        $baseUrl = $this->configAdapter->getBrasilApiBaseUrl();
        $endpoint = "{$baseUrl}/api/isbn/v1/{$isbn}";

        try {
            $response = $this->clientAdapter->get($endpoint);
            $data = json_decode($response, true);
            if (isset($data['title']) && isset($data['author'])) {
                return $data;
            }
        } catch (Exception $e) {
        }

        return null;
    }
}
