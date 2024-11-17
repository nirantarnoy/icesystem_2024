<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_sum}}`.
 */
class m210405_092309_create_stock_sum_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_sum}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'warehouse_id' => $this->integer(),
            'location_id' => $this->integer(),
            'lot_no' => $this->string(),
            'product_id' => $this->integer(),
            'qty' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_sum}}');
    }
}
