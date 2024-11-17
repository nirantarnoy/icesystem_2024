<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_issue}}`.
 */
class m210216_132536_add_car_ref_id_column_to_journal_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_issue}}', 'car_ref_id', $this->integer());
        $this->addColumn('{{%journal_issue}}', 'delivery_route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_issue}}', 'car_ref_id');
        $this->dropColumn('{{%journal_issue}}', 'delivery_route_id');
    }
}
