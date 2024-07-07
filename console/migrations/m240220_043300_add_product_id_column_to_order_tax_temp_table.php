<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order_tax_temp}}`.
 */
class m240220_043300_add_product_id_column_to_order_tax_temp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%order_tax_temp}}', 'product_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%order_tax_temp}}', 'product_id');
    }
}
