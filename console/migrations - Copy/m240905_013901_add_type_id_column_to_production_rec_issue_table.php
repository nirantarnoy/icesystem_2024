<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%production_rec_issue}}`.
 */
class m240905_013901_add_type_id_column_to_production_rec_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%production_rec_issue}}', 'type_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%production_rec_issue}}', 'type_id');
    }
}
