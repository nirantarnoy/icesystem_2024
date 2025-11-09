<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_request_asset_photo}}`.
 */
class m250914_100215_create_customer_request_asset_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_request_asset_photo}}', [
            'id' => $this->primaryKey(),
            'customer_req_id' => $this->integer(),
            'photo' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_request_asset_photo}}');
    }
}
