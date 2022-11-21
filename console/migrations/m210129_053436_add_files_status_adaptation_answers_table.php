<?php

use yii\db\Migration;

/**
 * Class m210129_053436_add_files_status_adaptation_answers_table
 */
class m210129_053436_add_files_status_adaptation_answers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation_answers', 'files_status', $this->string(20)->notNull()->defaultValue('unknown'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation_answers', 'files_status');
    }
}
