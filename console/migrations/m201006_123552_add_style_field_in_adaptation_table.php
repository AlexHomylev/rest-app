<?php

use yii\db\Migration;

/**
 * Class m201006_123552_add_style_field_in_adaptation_table
 */
class m201006_123552_add_style_field_in_adaptation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation', 'style', $this->string(20)->notNull()->defaultValue('normal'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation', 'style');
    }
}
