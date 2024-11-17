<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%daily_count_stock}}`.
 */
class m211115_122841_create_daily_count_stock_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%daily_count_stock}}', [
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
        $this->dropTable('{{%daily_count_stock}}');
    }
}
