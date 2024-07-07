<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_receive_line}}`.
 */
class m210309_130513_add_doc_column_to_payment_receive_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_receive_line}}', 'doc', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_receive_line}}', 'doc');
    }
}
