<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%balance_daily}}`.
 */
class m210922_033603_create_balance_daily_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%balance_daily}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'from_user_id' => $this->integer(),
            'sale_close_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'balance_qty' => $this->float(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%balance_daily}}');
    }
}
