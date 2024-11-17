<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_rec_issue}}`.
 */
class m240828_075419_create_production_rec_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_rec_issue}}', [
            'id' => $this->primaryKey(),
            'stock_trans_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'issue_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_rec_issue}}');
    }
}
