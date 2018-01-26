<?php

use yii\db\Migration;

/**
 * Class m180126_131844_add_people_field
 */
class m180126_131844_add_people_field extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('people', 'name', $this->string());
        $this->addColumn('people', 'email', $this->string());
        $this->addColumn('people', 'telegram', $this->string());
        $this->addColumn('people', 'skype', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180126_131844_add_people_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180126_131844_add_people_field cannot be reverted.\n";

        return false;
    }
    */
}
