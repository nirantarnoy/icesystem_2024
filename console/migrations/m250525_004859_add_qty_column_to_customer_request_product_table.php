<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_request_product}}`.
 */
class m250525_004859_add_qty_column_to_customer_request_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_request_product}}', 'qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_request_product}}', 'qty');
    }
}
