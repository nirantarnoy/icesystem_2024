<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%asset_rental}}`.
 */
class m240804_031545_add_use_from_column_to_asset_rental_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%asset_rental}}', 'use_from', $this->datetime());
        $this->addColumn('{{%asset_rental}}', 'use_to', $this->datetime());
        $this->addColumn('{{%asset_rental}}', 'work_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%asset_rental}}', 'use_from');
        $this->dropColumn('{{%asset_rental}}', 'use_to');
        $this->dropColumn('{{%asset_rental}}', 'work_name');
    }
}
