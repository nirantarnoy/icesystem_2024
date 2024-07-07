<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%position}}`.
 */
class m210507_044452_add_company_id_column_to_position_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%position}}', 'company_id', $this->integer());
        $this->addColumn('{{%position}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%position}}', 'company_id');
        $this->dropColumn('{{%position}}', 'branch_id');
    }
}
