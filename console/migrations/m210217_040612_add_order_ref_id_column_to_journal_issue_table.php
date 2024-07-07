<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue}}`.
 */
class m210217_040612_add_order_ref_id_column_to_journal_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue}}', 'order_ref_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue}}', 'order_ref_id');
    }
}
