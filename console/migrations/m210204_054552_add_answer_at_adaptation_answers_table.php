<?php

use common\models\AdaptationAnswers;
use yii\db\Migration;

/**
 * Class m210204_054552_add_answer_at_adaptation_answers_table
 */
class m210204_054552_add_answer_at_adaptation_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation_answers', 'answer_at', $this->dateTime()->null());
        $this->execute('UPDATE adaptation_answers SET answer_at = updated_at WHERE answers_jsonb NOTNULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation_answers', 'answer_at');
    }
}
