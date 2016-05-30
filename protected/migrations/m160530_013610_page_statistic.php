<?php

use yii\db\Migration;

class m160530_013610_page_statistic extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%page_statistic}}', [
            'id' => $this->string(32),
            'url' => $this->string()->notNull(),
            'page_title' => $this->string(),
            'count' => $this->integer()->notNull(),
            'unique_count' => $this->integer()->notNull(),
            'time' => $this->integer()->notNull(),
            'PRIMARY KEY ([[id]])'
            ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%page_statistic}}');
    }
}
