<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%addressbook}}`.
 */
class m201208_042419_create_addressbook_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%addressbook}}', [
            'id' => $this->primaryKey(),
            'address' => $this->integer(),
            'street' => $this->string(),
            'district_id' => $this->integer(),
            'city_id' => $this->integer(),
            'province_id' => $this->integer(),
            'zipcode' => $this->string(),
            'address_type_id' => $this->integer(),
            'status' => $this->integer(),
            'company_id' => $this->integer(),
            'branch_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey('fk_company_address','addressbook','company_id','company','id');
        $this->addForeignKey('fk_branch_address','addressbook','branch_id','branch','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%addressbook}}');
    }
}
