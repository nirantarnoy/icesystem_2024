<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assets_photo}}`.
 */
class m220523_013921_create_assets_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assets_photo}}', [
            'id' => $this->primaryKey(),
            'asset_id' => $this->integer(),
            'photo' => $this->string(),
            'file_ext' => $this->string(),
            'status' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%assets_photo}}');
    }
}
