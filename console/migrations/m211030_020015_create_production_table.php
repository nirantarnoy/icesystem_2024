<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production}}`.
 */
class m211030_020015_create_production_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production}}', [
            'id' => $this->primaryKey(),
            'prod_no' => $this->string(),
            'prod_date' => $this->datetime(),
            'plan_id' => $this->integer(),
            'status' => $this->integer(),
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
        $this->dropTable('{{%production}}');
    }
}
