<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_line}}`.
 */
class m211030_020900_create_production_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_line}}', [
            'id' => $this->primaryKey(),
            'prod_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'remain_qty' => $this->float(),
            'status'=> $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_line}}');
    }
}
