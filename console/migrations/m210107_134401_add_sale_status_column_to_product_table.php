<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%product}}`.
 */
class m210107_134401_add_sale_status_column_to_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%product}}', 'sale_status', $this->integer());
        $this->addColumn('{{%product}}', 'stock_type', $this->integer());
        $this->addColumn('{{%product}}', 'barcode', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%product}}', 'sale_status');
        $this->dropColumn('{{%product}}', 'stock_type');
        $this->dropColumn('{{%product}}', 'barcode');
    }
}
