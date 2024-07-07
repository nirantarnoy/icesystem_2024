<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_daily_close}}`.
 */
class m210508_145931_create_sale_daily_close_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_daily_close}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'user_id' => $this->integer(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sale_daily_close}}');
    }
}
