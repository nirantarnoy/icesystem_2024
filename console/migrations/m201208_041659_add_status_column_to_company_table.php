<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company}}`.
 */
class m201208_041659_add_status_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%company}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%company}}', 'status');
    }
}
