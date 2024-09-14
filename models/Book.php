<?php
namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%book}}';
    }

    public function rules()
    {
        return [
            [['isbn', 'title', 'author', 'price', 'stock'], 'required'],
            ['isbn', 'string', 'max' => 13],
            ['price', 'number'],
            ['stock', 'integer'],
            [['title', 'author'], 'string'],
            ['isbn', 'unique', 'targetClass' => self::class, 'message' => 'This ISBN already exists.'],
        ];
    }
}
