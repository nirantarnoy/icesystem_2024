<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%scrap}}`.
 */
class m210921_034207_create_scrap_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%scrap}}', [
            'id' => $this->primaryKey(),
            'journal_no' => $this->string(),
            'trans_date' => $this->datetime(),
            'status' => $this->integer(),
            'scrap_type_id' => $this->integer(),
            'prodrec_id' => $this->integer(),
            'created_by' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%scrap}}');
    }
}
