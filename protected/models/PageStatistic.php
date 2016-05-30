<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%page_statistic}}".
 *
 * @property string $id
 * @property string $url
 * @property string $page_title
 * @property integer $count
 * @property integer $unique_count
 * @property integer $time
 */
class PageStatistic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_statistic}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'count', 'unique_count', 'time'], 'required'],
            [['count', 'unique_count', 'time'], 'integer'],
            [['id'], 'string', 'max' => 32],
            [['url', 'page_title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'page_title' => 'Page Title',
            'count' => 'Count',
            'unique_count' => 'Unique Count',
            'time' => 'Time',
        ];
    }
}
