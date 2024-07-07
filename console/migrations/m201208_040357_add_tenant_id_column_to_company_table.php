<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company}}`.
 */
class m201208_040357_add_tenant_id_column_to_company_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%company}}', 'tenant_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%company}}', 'tenant_id');
    }
}
