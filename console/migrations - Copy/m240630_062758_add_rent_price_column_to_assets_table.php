<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%assets}}`.
 */
class m240630_062758_add_rent_price_column_to_assets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%assets}}', 'rent_price', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%assets}}', 'rent_price');
    }
}
