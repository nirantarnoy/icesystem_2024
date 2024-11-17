<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car}}`.
 */
class m210303_043133_add_meter_column_to_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car}}', 'meter', $this->float());
        $this->addColumn('{{%car}}', 'total_meter', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%car}}', 'meter');
        $this->dropColumn('{{%car}}', 'total_meter');
    }
}
