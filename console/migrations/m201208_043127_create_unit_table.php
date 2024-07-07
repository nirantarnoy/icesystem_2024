<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit}}`.
 */
class m201208_043127_create_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit}}', [
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
        $this->addForeignKey('fk_company_unit','unit','company_id','company','id');
        $this->addForeignKey('fk_branch_unit','unit','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%unit}}');
    }
}
