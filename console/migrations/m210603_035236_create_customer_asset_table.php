<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_asset}}`.
 */
class m210603_035236_create_customer_asset_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_asset}}', [
            'id' => $this->primaryKey(),
            'customer_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'start_date' => $this->datetime(),
            'end_date' => $this->datetime(),
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
        $this->dropTable('{{%customer_asset}}');
    }
}
