<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%scrap}}`.
 */
class m210921_034719_add_company_id_column_to_scrap_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%scrap}}', 'company_id', $this->integer());
        $this->addColumn('{{%scrap}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%scrap}}', 'company_id');
        $this->dropColumn('{{%scrap}}', 'branch_id');
    }
}
