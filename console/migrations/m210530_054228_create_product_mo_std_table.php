<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_mo_std}}`.
 */
class m210530_054228_create_product_mo_std_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_mo_std}}', [
            'id' => $this->primaryKey(),
            'level1_qty' => $this->float(),
            'level2_qty'=>$this->float(),
            'level3_qty' => $this->float(),
            'level4_qty' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_mo_std}}');
    }
}
