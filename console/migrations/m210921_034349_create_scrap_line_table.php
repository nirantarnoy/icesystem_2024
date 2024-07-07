<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%scrap}}`.
 */
class m210921_034349_create_scrap_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%scrap_line}}', [
            'id' => $this->primaryKey(),
            'scrap_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'prodrec_id' => $this->integer(),
            'note' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%scrap}}');
    }
}
