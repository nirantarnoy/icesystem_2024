<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assets}}`.
 */
class m220523_013537_create_assets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assets}}', [
            'id' => $this->primaryKey(),
            'asset_no' => $this->string(),
            'asset_name' => $this->string(),
            'description' => $this->string(),
            'status' => $this->integer(),
            'company_id'=> $this->integer(),
            'branch_id'=> $this->integer(),
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
        $this->dropTable('{{%assets}}');
    }
}
