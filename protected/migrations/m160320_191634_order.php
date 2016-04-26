<?php

use yii\db\Migration;

class m160320_191634_order extends Migration
{

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'number' => $this->string(16)->notNull(),
            'date' => $this->date()->notNull(),
            'keterangan' => $this->string(128),
            ], $tableOptions);

        $this->createTable('{{%order_item}}', [
            'id' => $this->primaryKey(),
            'order_id'=>  $this->integer()->notNull(),
            'product'=>  $this->string(64)->notNull(),
            'qty' => $this->integer()->notNull(),
            'FOREIGN KEY (order_id) REFERENCES {{%order}} (id) ON DELETE CASCADE ON UPDATE CASCADE'
            ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%order_item}}');
        $this->dropTable('{{%order}}');
    }
}
