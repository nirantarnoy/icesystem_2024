<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%customer_request}}`.
 */
class m250622_083229_add_use_box_description_column_to_customer_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%customer_request}}', 'use_box_description', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%customer_request}}', 'use_box_description');
    }
}
