<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%close_monthly_quantity}}`.
 */
class m250323_040400_create_close_monthly_quantity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%close_monthly_quantity}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%close_monthly_quantity}}');
    }
}
