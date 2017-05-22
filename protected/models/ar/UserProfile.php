<?php

namespace app\models\ar;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property string $fullname
 * @property integer $photo_id
 * @property string $avatar
 * @property string $avatarUrl
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fullname'], 'required'],
            [['photo_id'], 'integer'],
            [['fullname', 'avatar'], 'string', 'max' => 255],
            [['file'], 'file'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'User ID',
            'fullname' => 'Fullname',
            'photo_id' => 'Photo ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    public function getAvatarUrl()
    {
        if ($this->photo_id) {
            return \yii\helpers\Url::to(['/file','id'=> $this->photo_id], true);
        }
        return $this->avatar;
    }

    public function behaviors()
    {
        return[
            [
                'class' => 'mdm\upload\UploadBehavior',
                'savedAttribute' => 'photo_id',
            ]
        ];
    }
}