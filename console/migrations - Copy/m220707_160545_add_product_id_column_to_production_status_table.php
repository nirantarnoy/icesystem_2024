<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%production_status}}`.
 */
class m220707_160545_add_product_id_column_to_production_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%production_status}}', 'product_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%production_status}}', 'product_id');
    }
}
