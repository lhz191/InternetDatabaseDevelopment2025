<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_guestbook".
 *
 * @property int $id
 * @property string $nickname 留言者昵称
 * @property string|null $email
 * @property string $content 留言内容
 * @property string|null $ip_address 留言IP
 * @property int|null $is_read 管理员是否已读
 * @property string|null $created_at
 */
class GuestBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_guestbook';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nickname', 'content'], 'required'],
            [['content'], 'string'],
            [['is_read'], 'integer'],
            [['created_at'], 'safe'],
            [['nickname', 'ip_address'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nickname' => '留言者昵称',
            'email' => 'Email',
            'content' => '留言内容',
            'ip_address' => '留言IP',
            'is_read' => '管理员是否已读',
            'created_at' => 'Created At',
        ];
    }
}
