<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%delivery_route}}`.
 */
class m260208_062401_add_is_two_rap_column_to_delivery_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%delivery_route}}', 'is_two_rap', $this->integer());
      $this->addColumn('{{%delivery_route}}', 'prod_show_seq', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%delivery_route}}', 'is_two_rap');
        $this->dropColumn('{{%delivery_route}}', 'prod_show_seq');
    }
}
