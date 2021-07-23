<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%suspects}}`.
 */
class m210722_102149_create_suspects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%suspects}}', [
            'id' => $this->primaryKey(),
            'crime_id' => $this->bigInteger()->notNull(),
            'code_link_id' => $this->integer()->notNull(),
            'quantity' => $this->string(5)->defaultValue(null),
            'name' => $this->string(120)->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%suspects}}');
    }
}
