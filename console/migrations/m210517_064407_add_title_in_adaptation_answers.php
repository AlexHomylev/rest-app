<?php

use yii\db\Migration;

/**
 * Class m210517_064407_add_title_in_adaptation_answers
 */
class m210517_064407_add_title_in_adaptation_answers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation_answers', 'title', $this->string(120)->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation_answers', 'title');
    }
}
