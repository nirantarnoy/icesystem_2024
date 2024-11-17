<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%journal_transfer}}`.
 */
class m210612_042137_add_from_route_id_column_to_journal_transfer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%journal_transfer}}', 'from_route_id', $this->integer());
        $this->addColumn('{{%journal_transfer}}', 'to_route_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%journal_transfer}}', 'from_route_id');
        $this->dropColumn('{{%journal_transfer}}', 'to_route_id');
    }
}
