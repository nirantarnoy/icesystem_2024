<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%delivery_route}}`.
 */
class m211105_073235_add_type_id_column_to_delivery_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%delivery_route}}', 'type_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%delivery_route}}', 'type_id');
    }
}
