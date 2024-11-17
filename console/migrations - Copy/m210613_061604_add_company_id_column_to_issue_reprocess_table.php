<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%issue_reprocess}}`.
 */
class m210613_061604_add_company_id_column_to_issue_reprocess_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%issue_reprocess}}', 'company_id', $this->integer());
        $this->addColumn('{{%issue_reprocess}}', 'branch_id', $this->integer());
        $this->addColumn('{{%issue_reprocess}}', 'reason', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%issue_reprocess}}', 'company_id');
        $this->dropColumn('{{%issue_reprocess}}', 'branch_id');
        $this->dropColumn('{{%issue_reprocess}}', 'reason');
    }
}
