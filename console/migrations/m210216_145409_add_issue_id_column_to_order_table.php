<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%order}}`.
 */
class m210216_145409_add_issue_id_column_to_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%orders}}', 'issue_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%orders}}', 'issue_id');
    }
}
