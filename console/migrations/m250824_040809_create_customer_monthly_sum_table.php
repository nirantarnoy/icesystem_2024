<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_monthly_sum}}`.
 */
class m250824_040809_create_customer_monthly_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_monthly_sum}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'year' => $this->integer(),
            'month' => $this->integer(),
            'total_amount' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_monthly_sum}}');
    }
}
