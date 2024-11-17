<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m201208_082456_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'order_no' => $this->string(),
            'customer_id' => $this->integer(),
            'customer_type' => $this->integer(),
            'customer_name' => $this->string(),
            'order_date' => $this->datetime(),
            'vat_amt' => $this->float(),
            'vat_per' => $this->float(),
            'order_total_amt' => $this->float(),
            'emp_sale_id' => $this->integer(),
            'car_ref_id' => $this->integer(),
            'order_channel_id' => $this->integer(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_order','orders','company_id','company','id');
        $this->addForeignKey('fk_branch_order','orders','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
