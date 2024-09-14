<?php

namespace app\repositories;

use app\models\Book;
use core\Modules\Book\Create\Entities\BookEntity;
use core\Modules\Book\Create\Gateways\BookGateway;
use core\Modules\Book\List\Gateways\ListBookGateway;

class BookRepository implements BookGateway, ListBookGateway
{
    public function save(BookEntity $bookEntity): BookEntity
    {
        $model = new Book();
        $model->setAttributes([
            'isbn' => $bookEntity->getIsbn(),
            'title' => $bookEntity->getTitle(),
            'author' => $bookEntity->getAuthor(),
            'price' => $bookEntity->getPrice(),
            'stock' => $bookEntity->getStock(),
        ]);

        if ($model->save()) {
            $bookEntity->id = $model->id;
            return $bookEntity;
        } else {
            throw new \Exception('Failed to save book: ' . json_encode($model->getErrors()));
        }
    }

    public function findAll($filters, $sort, $limit, $offset): array
    {
        $query = Book::find();

        if (isset($filters['title'])) {
            $query->andFilterWhere(['like', 'title', $filters['title']]);
        }
        if (isset($filters['author'])) {
            $query->andFilterWhere(['like', 'author', $filters['author']]);
        }
        if (isset($filters['isbn'])) {
            $query->andFilterWhere(['isbn' => $filters['isbn']]);
        }

        $query->orderBy($sort);
        $query->limit($limit)->offset($offset);

        $models = $query->all();
        $books = [];
        foreach ($models as $model) {
            $book = new BookEntity();
            $book->id = $model->id;
            $book->title = $model->title;
            $book->author = $model->author;
            $book->isbn = $model->isbn;
            $book->price = $model->price;
            $book->stock = $model->stock;

            $books[] = $book;
        }

        return $books;
    }
}
