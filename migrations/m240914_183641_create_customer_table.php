<?php
// migrations/mXXXXXX_create_customer_table.php
use yii\db\Migration;

class m240914_183641_create_customer_table extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'cpf' => $this->string(11)->notNull()->unique(),
            'cep' => $this->string(8)->notNull(),
            'address' => $this->string()->notNull(),
            'number' => $this->string()->notNull(),
            'city' => $this->string()->notNull(),
            'state' => $this->string(2)->notNull(),
            'complement' => $this->string()->null(),
            'gender' => $this->string(1)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add indexes
        $this->createIndex('idx_customer_cpf', '{{%customer}}', 'cpf');
        $this->createIndex('idx_customer_city', '{{%customer}}', 'city');
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%customer}}');
    }
}
