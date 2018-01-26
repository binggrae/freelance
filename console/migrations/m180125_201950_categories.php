<?php

use yii\db\Migration;

/**
 * Class m180125_201950_categories
 */
class m180125_201950_categories extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->createTable('people', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),

        ], $tableOptions);

        $this->createTable('category_people', [
            'cat_id' => $this->integer()->notNull(),
            'people_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_people_catPeople',
            'category_people', 'cat_id',
            'category', 'id',
            'CASCADE', 'RESTRICT');

        $this->addForeignKey('fk_category_catPeople',
            'category_people', 'people_id',
            'people', 'id',
            'CASCADE', 'RESTRICT');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m180125_201950_categories cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180125_201950_categories cannot be reverted.\n";

        return false;
    }
    */
}
