<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%sequence}}`.
 */
class m210409_133209_add_company_id_column_to_sequence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%sequence}}', 'company_id', $this->integer());
        $this->addColumn('{{%sequence}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%sequence}}', 'company_id');
        $this->dropColumn('{{%sequence}}', 'branch_id');
    }
}
