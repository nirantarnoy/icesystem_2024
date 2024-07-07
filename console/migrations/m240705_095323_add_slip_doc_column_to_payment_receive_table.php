<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payment_receive}}`.
 */
class m240705_095323_add_slip_doc_column_to_payment_receive_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payment_receive}}', 'slip_doc', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payment_receive}}', 'slip_doc');
    }
}
