<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%assets_photo}}`.
 */
class m221213_073727_add_request_id_column_to_assets_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%assets_photo}}', 'request_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%assets_photo}}', 'request_id');
    }
}
