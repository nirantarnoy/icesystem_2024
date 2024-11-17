<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%plan_line}}`.
 */
class m210621_023218_create_plan_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%plan_line}}', [
            'id' => $this->primaryKey(),
            'plan_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%plan_line}}');
    }
}
