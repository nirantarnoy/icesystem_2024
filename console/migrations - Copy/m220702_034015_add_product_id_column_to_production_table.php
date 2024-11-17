<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%production}}`.
 */
class m220702_034015_add_product_id_column_to_production_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%production}}', 'product_id', $this->integer());
        $this->addColumn('{{%production}}', 'qty', $this->float());
        $this->addColumn('{{%production}}', 'remain_qty', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%production}}', 'product_id');
        $this->dropColumn('{{%production}}', 'qty');
        $this->dropColumn('{{%production}}', 'remain_qty');
    }
}
