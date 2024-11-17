<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%scrap}}`.
 */
class m211004_071935_add_order_id_column_to_scrap_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%scrap}}', 'order_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%scrap}}', 'order_id');
    }
}
