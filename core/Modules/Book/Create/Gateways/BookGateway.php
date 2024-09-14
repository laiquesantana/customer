<?php
namespace core\Modules\Book\Create\Gateways;

use core\Modules\Book\Create\Entities\BookEntity;

interface BookGateway
{
    public function save(BookEntity $bookEntity): BookEntity;
}
