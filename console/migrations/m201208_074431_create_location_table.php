<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%location}}`.
 */
class m201208_074431_create_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%location}}', [
            'id' => $this->primaryKey(),
            'warehouse_id' => $this->integer(),
            'code' => $this->string(),
            'name' => $this->string(),
            'description' => $this->string(),
            'photo' => $this->string(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_location','location','company_id','company','id');
        $this->addForeignKey('fk_branch_location','location','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%location}}');
    }
}
