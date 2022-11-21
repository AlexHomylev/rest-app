<?php

use yii\db\Migration;

/**
 * Class m210305_051341_add_is_shuffle_in_adaptation
 */
class m210305_051341_add_is_shuffle_in_adaptation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation', 'is_shuffle', $this->boolean()->defaultValue(false)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation', 'is_shuffle');
    }
}
