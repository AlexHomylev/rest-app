<?php

use yii\db\Migration;

/**
 * Class m200318_045543_add_table_adaptation_answers
 */
class m200318_045543_create_table_adaptation_answers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('adaptation_answers', [
            'uid' => 'UUID NOT NULL PRIMARY KEY',
            'adaptation_uid' => 'UUID NOT NULL',
            'username' => $this->string()->defaultValue(null),
            'answers_jsonb' => 'JSONB DEFAULT NULL',
            'is_processed' => $this->boolean()->defaultValue(false),
            'device_id' => $this->integer()->null()->unique(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(null),
        ]);

        $this->addForeignKey('fk_adaptation_adaptation_uid', 'adaptation_answers', 'adaptation_uid', 'adaptation', 'uid', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('adaptation_answers');
        $this->dropForeignKey('fk_adaptation_adaptation_uid', 'adaptation_answers');
    }
}
