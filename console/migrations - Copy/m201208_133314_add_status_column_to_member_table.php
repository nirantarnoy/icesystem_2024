<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%member}}`.
 */
class m201208_133314_add_status_column_to_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%member}}', 'status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%member}}', 'status');
    }
}
