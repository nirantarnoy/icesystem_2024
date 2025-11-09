<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request}}`.
 */
class m250518_092235_create_customer_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'customer_ref_id' => $this->integer(),
            'customer_name' => $this->string(),
            'age' => $this->float(),
            'idcard_no' => $this->string(),
            'address' => $this->string(),
            'moo' => $this->integer(),
            'district_id' => $this->integer(),
            'city_id' => $this->integer(),
            'province_id' => $this->integer(),
            'phone' => $this->string(),
            'company_name' => $this->string(),
            'route_id' => $this->integer(),
            'route_num' => $this->integer(),
            'start_date' => $this->datetime(),
            'sale_price' => $this->string(),
            'remark' => $this->string(),
            'payment_method_id' => $this->integer(),
            'account_no' => $this->string(),
            'credit_term' => $this->integer(),
            'account_credit_no' => $this->string(),
            'after_invoice_day' => $this->integer(),
            'user_box' => $this->integer(),
            'marget_emp_id' => $this->integer(),
            'market_emp_date' => $this->datetime(),
            'is_approve' => $this->integer(),
            'approve_emp_id' => $this->integer(),
            'approve_date' => $this->datetime(),
            'is_shop_place' => $this->integer(),
            'emp_operate_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request}}');
    }
}
