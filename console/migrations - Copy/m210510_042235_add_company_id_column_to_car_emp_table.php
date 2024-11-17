<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%car_emp}}`.
 */
class m210510_042235_add_company_id_column_to_car_emp_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car_emp}}', 'company_id', $this->integer());
        $this->addColumn('{{%car_emp}}', 'branch_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%car_emp}}', 'company_id');
        $this->dropColumn('{{%car_emp}}', 'branch_id');
    }
}
