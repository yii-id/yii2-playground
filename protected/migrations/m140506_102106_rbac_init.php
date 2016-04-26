<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
use yii\helpers\ArrayHelper;

/**
 * Initializes RBAC tables
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @since 2.0
 */
class m140506_102106_rbac_init extends \yii\db\Migration
{
    public $tableNames = [
        'itemTable' => '{{%auth_item}}',
        'itemChildTable' => '{{%auth_item_child}}',
        'assignmentTable' => '{{%auth_assignment}}',
        'ruleTable' => '{{%auth_rule}}',
    ];

    public function safeUp()
    {
        $tableNames = array_merge($this->tableNames, ArrayHelper::getValue(Yii::$app->params, 'migration.rbac', []));

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($tableNames['ruleTable'], [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            ], $tableOptions);

        $this->createTable($tableNames['itemTable'], [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $tableNames['ruleTable'] . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
            ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $tableNames['itemTable'], 'type');

        $this->createTable($tableNames['itemChildTable'], [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $tableNames['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $tableNames['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);

        $this->createTable($tableNames['assignmentTable'], [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $tableNames['itemTable'] . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            ], $tableOptions);
    }

    public function safeDown()
    {
        $tableNames = array_merge($this->tableNames, ArrayHelper::getValue(Yii::$app->params, 'migration.rbac', []));

        $this->dropTable($tableNames['assignmentTable']);
        $this->dropTable($tableNames['itemChildTable']);
        $this->dropTable($tableNames['itemTable']);
        $this->dropTable($tableNames['ruleTable']);
    }
}