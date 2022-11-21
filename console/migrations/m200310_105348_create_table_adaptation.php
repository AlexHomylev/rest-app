<?php

use yii\db\Migration;

/**
 * Таблица для хранения тестов
 * Class m200310_105348_create_table_adaptation
 */
class m200310_105348_create_table_adaptation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('adaptation', [
            'uid' => 'UUID NOT NULL PRIMARY KEY',
            'title' => $this->string()->defaultValue(null),
            'form_jsonb' => 'JSONB NOT NULL',
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->defaultValue(null),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('adaptation');
    }
}
