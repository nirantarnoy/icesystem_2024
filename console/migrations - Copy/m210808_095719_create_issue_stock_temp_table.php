<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%issue_stock_temp}}`.
 */
class m210808_095719_create_issue_stock_temp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%issue_stock_temp}}', [
            'id' => $this->primaryKey(),
            'issue_id' => $this->integer(),
            'prodrec_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'status' => $this->integer(),
            'created_by' => $this->integer(),
            'crated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%issue_stock_temp}}');
    }
}
