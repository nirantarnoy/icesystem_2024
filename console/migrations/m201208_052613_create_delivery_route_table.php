<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%delivery_route}}`.
 */
class m201208_052613_create_delivery_route_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%delivery_route}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_delivery_route','delivery_route','company_id','company','id');
        $this->addForeignKey('fk_branch_delivery_route','delivery_route','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%delivery_route}}');
    }
}
