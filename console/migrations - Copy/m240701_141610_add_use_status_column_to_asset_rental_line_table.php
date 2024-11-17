<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%asset_rental_line}}`.
 */
class m240701_141610_add_use_status_column_to_asset_rental_line_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%asset_rental_line}}', 'use_status', $this->integer());
        $this->addColumn('{{%asset_rental_line}}', 'return_status', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%asset_rental_line}}', 'use_status');
        $this->dropColumn('{{%asset_rental_line}}', 'return_status');
    }
}
