<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%contacts}}`.
 */
class m201208_042926_create_contacts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%contacts}}', [
            'id' => $this->primaryKey(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'name' => $this->string(),
            'contact_type' => $this->integer(),
            'contact_detail' => $this->string(),
            'is_primary' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
        $this->addForeignKey('fk_company_contact','contacts','company_id','company','id');
        $this->addForeignKey('fk_branch_contact','contacts','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%contacts}}');
    }
}
