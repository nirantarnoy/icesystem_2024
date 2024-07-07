<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car}}`.
 */
class m210115_161634_add_sale_com_id_column_to_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car}}', 'sale_com_id', $this->integer());
        $this->addColumn('{{%car}}', 'sale_com_extra', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%car}}', 'sale_com_id');
        $this->dropColumn('{{%car}}', 'sale_com_extra');
    }
}
