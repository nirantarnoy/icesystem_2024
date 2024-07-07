<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sale_route_daily_close}}`.
 */
class m211110_081418_create_sale_route_daily_close_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sale_route_daily_close}}', [
            'id' => $this->primaryKey(),
            'trans_date' => $this->datetime(),
            'route_id' => $this->integer(),
            'product_id' => $this->integer(),
            'qty' => $this->float(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'crated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sale_route_daily_close}}');
    }
}
