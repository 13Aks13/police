<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%crime}}`.
 */
class m210722_102109_create_crimes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%crimes}}', [
            'id' => $this->primaryKey(),
            'code_id' => $this->bigInteger()->unique(),
            'crime_name' => $this->string(),
            'crime_number' => $this->bigInteger(),
            'crime_date' => $this->date(),
            'crime_location' => $this->string(),
            'lat' => $this->string(),
            'long' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%crime}}');
    }
}
