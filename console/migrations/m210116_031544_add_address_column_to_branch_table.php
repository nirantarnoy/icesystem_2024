<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%branch}}`.
 */
class m210116_031544_add_address_column_to_branch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%branch}}', 'address', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%branch}}', 'address');
    }
}
