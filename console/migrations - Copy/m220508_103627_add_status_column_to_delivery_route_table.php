<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%delivery_route}}`.
 */
class m220508_103627_add_status_column_to_delivery_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%delivery_route}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%delivery_route}}', 'status');
    }
}
