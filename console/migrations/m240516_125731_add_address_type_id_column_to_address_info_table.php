<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%address_info}}`.
 */
class m240516_125731_add_address_type_id_column_to_address_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%address_info}}', 'address_is_same', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%address_info}}', 'address_is_same');
    }
}
