<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%warehouse}}`.
 */
class m210410_033705_add_is_reprocess_column_to_warehouse_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%warehouse}}', 'is_reprocess', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%warehouse}}', 'is_reprocess');
    }
}
