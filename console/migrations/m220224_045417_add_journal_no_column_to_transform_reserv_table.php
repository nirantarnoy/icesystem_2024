<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%transform_reserv}}`.
 */
class m220224_045417_add_journal_no_column_to_transform_reserv_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%transform_reserv}}', 'journal_no', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%transform_reserv}}', 'journal_no');
    }
}
