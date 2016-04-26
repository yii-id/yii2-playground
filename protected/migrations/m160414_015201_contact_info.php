<?php

use yii\db\Migration;

class m160414_015201_contact_info extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%contact_info}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'email' => $this->string(64),
            'phone' => $this->string(32),
            'keterangan' => $this->string(128),
            ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%contact_info}}');
    }
}
