<?php
namespace core\Modules\Book\Create\Entities;

class BookEntity
{
    public int $id;
    public string $isbn;
    public string $title;
    public string $author;
    public string $price;
    public int $stock;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BookEntity
    {
        $this->id = $id;
        return $this;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): BookEntity
    {
        $this->isbn = $isbn;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BookEntity
    {
        $this->title = $title;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): BookEntity
    {
        $this->author = $author;
        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): BookEntity
    {
        $this->price = $price;
        return $this;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): BookEntity
    {
        $this->stock = $stock;
        return $this;
    }


}
