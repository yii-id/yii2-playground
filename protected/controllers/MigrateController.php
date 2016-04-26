<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use dee\console\MigrateController as Migrate;
use yii\di\Instance;
use yii\db\Connection;

defined('STDOUT') or define('STDOUT', fopen('php://output', 'w'));

/**
 * MigrateController.
 */
class MigrateController extends Controller
{
    public $db = ['dsn' => 'sqlite:@runtime/test_migrate.sqlite'];

    /**
     *
     * @return type
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *
     * @param type $id
     * @return type
     */
    public function actionRun($id)
    {
        $cmd = $this->getMigrate();
        $params = ['id' => $id];
        if ($migration = Yii::$app->getRequest()->post('migrations')) {
            $migration = implode(',', $migration);
            ob_start();
            ob_implicit_flush(false);
            $cmd->runAction($id, [$migration]);
            $params['result'] = ob_get_clean();
        }
        $params['migrations'] = $cmd->getVersions($id === 'up' ? 'new' : 'history');
        return $this->render('run', $params);
    }

    /**
     * @return Migrate
     */
    protected function getMigrate()
    {
        $this->db = Instance::ensure($this->db, Connection::className());
        return new Migrate('cmd', Yii::$app, [
            'interactive' => false,
            'db' => $this->db,
        ]);
    }
}
