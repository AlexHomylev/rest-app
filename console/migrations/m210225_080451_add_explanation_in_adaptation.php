<?php

use yii\db\Migration;

/**
 * Class m210225_080451_add_explanation_in_adaptation
 */
class m210225_080451_add_explanation_in_adaptation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation', 'explanation', $this->text()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation', 'explanation');
    }
}
