<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Description of DataController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DataController extends Controller
{

    public function actionSampleProduct()
    {
        if (!Console::confirm('Are you sure you want to create sample data. Old data will be lose')) {
            return self::EXIT_CODE_NORMAL;
        }

        $command = Yii::$app->db->createCommand();
        $sampleDir = __DIR__ . '/samples';

        // product category
        $rows = require $sampleDir . '/category.php';
        $total = count($rows);
        echo "\ninsert table {{%category}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $command->insert('{{%category}}', $this->toAssoc($row, ['id', 'code', 'name']))->execute();
            Console::updateProgress($i + 1, $total);
        }
        $command->resetSequence('{{%category}}')->execute();
        Console::endProgress();

        // product
        $rows = require $sampleDir . '/product.php';
        $total = count($rows);
        echo "\ninsert table {{%product}}\n";
        Console::startProgress(0, $total);
        foreach ($rows as $i => $row) {
            $row = [
                'id' => $row[0],
                'category_id' => $row[2],
                'code' => $row[3],
                'name' => $row[4],
                'status' => $row[5],
                'created_at' => time(),
                'created_by' => 1
            ];

            $command->insert('{{%product}}', $row)->execute();
            Console::updateProgress($i + 1, $total);
        }
        $command->resetSequence('{{%product}}')->execute();
        Console::endProgress();
    }

    protected function toAssoc($array, $fields, $time = true)
    {
        $result = [];
        foreach ($fields as $i => $field) {
            $result[$field] = $array[$i];
        }
        if ($time) {
            return array_merge([
                'created_at' => time(),
                'created_by' => 1,
                ], $result);
        }
        return $result;
    }
}
