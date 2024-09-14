<?php
// migrations/mXXXXXX_create_book_table.php
use yii\db\Migration;

class m240914_183747_create_book_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'isbn' => $this->string(13)->notNull()->unique(),
            'title' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'price' => $this->decimal(10,2)->notNull(),
            'stock' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add indexes
        $this->createIndex('idx_book_title', '{{%book}}', 'title');
        $this->createIndex('idx_book_price', '{{%book}}', 'price');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%book}}');
    }
}
