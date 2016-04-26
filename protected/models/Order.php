<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property string $keterangan
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{

    use \mdm\behaviors\ar\RelationTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Date'], 'required'],
            [['date'], 'safe'],
            [['!number'], 'autonumber', 'format' => date('Ymd-?'), 'digit' => 4],
            [['keterangan'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function setOrderItems($value)
    {
        $this->loadRelated('orderItems', $value);
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\converter\DateConverter',
                'type' => 'date', // 'date', 'time', 'datetime'
                'logicalFormat' => 'php:d-m-Y',
                'attributes' => [
                    'Date' => 'date',
                ]
            ],
        ];
    }
}
