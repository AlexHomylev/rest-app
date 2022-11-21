<?php

use yii\db\Migration;

/**
 * Class m210224_070351_add_open_at_in_adaptation_answers_table
 */
class m210224_070351_add_open_at_in_adaptation_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation_answers', 'open_at', $this->dateTime()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation_answers', 'open_at');
    }
}
