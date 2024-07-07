<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%price_group}}`.
 */
class m210405_093614_add_company_id_column_to_price_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%price_group}}', 'company_id', $this->integer());
        $this->addColumn('{{%price_group}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%price_group}}', 'company_id');
        $this->dropColumn('{{%price_group}}', 'branch_id');
    }
}
