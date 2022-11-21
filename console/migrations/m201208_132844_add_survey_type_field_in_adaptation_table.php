<?php

use yii\db\Migration;

/**
 * Class m201208_132844_add_survey_type_field_in_adaptation_table
 */
class m201208_132844_add_survey_type_field_in_adaptation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('adaptation', 'survey_type', $this->integer()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('adaptation', 'survey_type');
    }
}
