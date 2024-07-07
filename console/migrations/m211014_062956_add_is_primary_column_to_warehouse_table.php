<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%warehouse}}`.
 */
class m211014_062956_add_is_primary_column_to_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%warehouse}}', 'is_primary', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%warehouse}}', 'is_primary');
    }
}
