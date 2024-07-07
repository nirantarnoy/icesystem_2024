<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_trans}}`.
 */
class m220530_150412_create_production_trans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_trans}}', [
            'id' => $this->primaryKey(),
            'machine_detail_id' => $this->integer(),
            'production_ref_id'=> $this->integer(),
            'product_id' => $this->integer(),
            'start_date' => $this->datetime(),
            'finished_date' => $this->datetime(),
            'status' => $this->integer(),
            'emp_id' => $this->integer(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_trans}}');
    }
}
