<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%assets_photo}}`.
 */
class m221213_072801_add_in_use_column_to_assets_photo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%assets_photo}}', 'in_use', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%assets_photo}}', 'in_use');
    }
}
