<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_type}}`.
 */
class m201208_080819_create_car_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_type}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_car_type','car_type','company_id','company','id');
        $this->addForeignKey('fk_branch_car_type','car_type','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car_type}}');
    }
}
