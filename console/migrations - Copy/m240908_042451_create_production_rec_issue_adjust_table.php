<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_rec_issue_adjust}}`.
 */
class m240908_042451_create_production_rec_issue_adjust_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_rec_issue_adjust}}', [
            'id' => $this->primaryKey(),
            'stock_trans_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'type_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_rec_issue_adjust}}');
    }
}
