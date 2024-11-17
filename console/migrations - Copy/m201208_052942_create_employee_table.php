<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%employee}}`.
 */
class m201208_052942_create_employee_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%employee}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'fname' => $this->string(),
            'lname' => $this->string(),
            'gender' => $this->integer(),
            'position' => $this->integer(),
            'salary_type' => $this->integer(),
            'emp_start' => $this->datetime(),
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
        $this->addForeignKey('fk_company_employee','employee','company_id','company','id');
        $this->addForeignKey('fk_branch_employee','employee','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%employee}}');
    }
}
