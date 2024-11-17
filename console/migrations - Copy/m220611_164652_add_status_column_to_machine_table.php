<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%machine}}`.
 */
class m220611_164652_add_status_column_to_machine_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%machine}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%machine}}', 'status');
    }
}
