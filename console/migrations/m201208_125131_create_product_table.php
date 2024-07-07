<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m201208_125131_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'product_type_id' => $this->integer(),
            'product_group_id' => $this->integer(),
            'photo' => $this->string(),
            'std_cost' => $this->float(),
            'sale_price' => $this->float(),
            'unit_id' => $this->integer(),
            'nw' => $this->float(),
            'gw' => $this->float(),
            'min_stock' => $this->float(),
            'max_stock' => $this->float(), 'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_product','product','company_id','company','id');
        $this->addForeignKey('fk_branch_product','product','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer}}');
    }
}
