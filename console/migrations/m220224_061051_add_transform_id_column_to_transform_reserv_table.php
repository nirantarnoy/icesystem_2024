<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transform_reserv}}`.
 */
class m220224_061051_add_transform_id_column_to_transform_reserv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transform_reserv}}', 'transform_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transform_reserv}}', 'transform_id');
    }
}
