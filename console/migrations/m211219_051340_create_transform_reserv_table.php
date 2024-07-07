<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%transform_reserv}}`.
 */
class m211219_051340_create_transform_reserv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%transform_reserv}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'user_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%transform_reserv}}');
    }
}
