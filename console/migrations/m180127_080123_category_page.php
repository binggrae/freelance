<?php

use yii\db\Migration;

/**
 * Class m180127_080123_category_page
 */
class m180127_080123_category_page extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('category', 'page', $this->integer()->null()->defaultValue(1));

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180127_080123_category_page cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180127_080123_category_page cannot be reverted.\n";

        return false;
    }
    */
}
