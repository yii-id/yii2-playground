<?php

namespace app\models;

/**
 * Description of ContactInfo
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ContactInfo extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['email'], 'email'],
            [['phone', 'keterangan'], 'safe'],
        ];
    }
}
