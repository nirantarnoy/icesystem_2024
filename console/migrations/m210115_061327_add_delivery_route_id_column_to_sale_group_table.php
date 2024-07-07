<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sale_group}}`.
 */
class m210115_061327_add_delivery_route_id_column_to_sale_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sale_group}}', 'delivery_route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sale_group}}', 'delivery_route_id');
    }
}
