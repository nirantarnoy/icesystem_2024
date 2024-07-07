<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%standard_price}}`.
 */
class m201208_045324_create_standard_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%standard_price}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'name' => $this->string(),
            'status' => $this->integer(),
            'description' => $this->string(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_standard_price','standard_price','company_id','company','id');
        $this->addForeignKey('fk_branch_standard_price','standard_price','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%standard_price}}');
    }
}
