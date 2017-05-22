<?php

use yii\db\Migration;

class m160917_003426_oauth extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%auth}}', [
            'id'=>  $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string(128),
            'source_id' => $this->string(128),
            ], $tableOptions);

        $columns = $this->db->getTableSchema('{{%user_profile}}')->columns;
        if (!isset($columns['avatar'])) {
            $this->addColumn('{{%user_profile}}', 'avatar', $this->string());
        }
    }

    public function down()
    {
        $this->dropTable('{{%auth}}');
    }
}
