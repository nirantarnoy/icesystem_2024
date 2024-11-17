<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_asset}}`.
 */
class m210603_035340_create_customer_asset_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_asset_status}}', [
            'id' => $this->primaryKey(),
            'cus_asset_id' => $this->integer(),
            'photo' => $this->string(),
            'description' => $this->string(),
            'trans_date' => $this->datetime(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_asset}}');
    }
}
