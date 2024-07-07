<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%production_status}}`.
 */
class m220707_153007_create_production_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%production_status}}', [
            'id' => $this->primaryKey(),
            'loc_id' => $this->integer(),
            'loc_name' => $this->string(),
            'color_status' => $this->string(),
            'start_date' => $this->datetime(),
            'end_date' => $this->datetime(),
            'total_hour' => $this->float(),
            'updated_date' => $this->datetime(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%production_status}}');
    }
}
