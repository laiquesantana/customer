<?php
use yii\db\Migration;

class m240914_183749_add_image_to_customers_and_books extends Migration
{
    public function safeUp(): void
    {
        $this->addColumn('{{%customer}}', 'image_path', $this->string()->null());
        $this->addColumn('{{%book}}', 'image_path', $this->string()->null());
    }

    public function safeDown(): void
    {
        $this->dropColumn('{{%customer}}', 'image_path');
        $this->dropColumn('{{%book}}', 'image_path');
    }
}
