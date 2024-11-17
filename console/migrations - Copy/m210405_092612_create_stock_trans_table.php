<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%stock_trans}}`.
 */
class m210405_092612_create_stock_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%stock_trans}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'warehouse_id' => $this->integer(),
            'location_id' => $this->integer(),
            'lot_no' => $this->string(),
            'qty' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%stock_trans}}');
    }
}
