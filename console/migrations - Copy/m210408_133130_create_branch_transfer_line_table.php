<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%branch_transfer_line}}`.
 */
class m210408_133130_create_branch_transfer_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%branch_transfer_line}}', [
            'id' => $this->primaryKey(),
            'journal_id' => $this->integer(),
            'product_id' => $this->integer(),
            'from_company_id' => $this->integer(),
            'from_branch_id' => $this->integer(),
            'from_warehouse_id' => $this->integer(),
            'from_location_id' => $this->integer(),
            'to_company_id' => $this->integer(),
            'to_branch_id' => $this->integer(),
            'to_warehouse_id' => $this->integer(),
            'to_location_id' => $this->integer(),
            'qty' => $this->integer(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%branch_transfer_line}}');
    }
}
