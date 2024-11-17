<?php

use yii\db\Migration;

/**
 * Handles the creation of table `sequence`.
 */
class m180505_140600_create_sequence_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('sequence', [
            'id' => $this->primaryKey(),
            'plant_id' => $this->integer(),
            'module_id' => $this->integer(),
            'prefix' => $this->string(),
            'symbol' => $this->string(),
            'use_year' => $this->integer(),
            'use_month' => $this->integer(),
            'use_day' => $this->integer(),
            'minimum' => $this->integer(),
            'maximum' => $this->integer(),
            'currentnum' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('sequence');
    }
}
