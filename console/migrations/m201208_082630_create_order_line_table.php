<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car}}`.
 */
class m201208_082630_create_order_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_line}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'price' => $this->float(),
            'line_disc_amt' => $this->float(),
            'line_disc_per' => $this->float(),
            'line_total' => $this->float(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_order_line','order_line','company_id','company','id');
        $this->addForeignKey('fk_branch_order_line','order_line','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car}}');
    }
}
