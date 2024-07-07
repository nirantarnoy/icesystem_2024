<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%branch_transfer}}`.
 */
class m210513_023512_add_company_id_column_to_branch_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%branch_transfer}}', 'company_id', $this->integer());
        $this->addColumn('{{%branch_transfer}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%branch_transfer}}', 'company_id');
        $this->dropColumn('{{%branch_transfer}}', 'branch_id');
    }
}
