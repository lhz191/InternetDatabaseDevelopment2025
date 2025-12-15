<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_team_member".
 *
 * @property int $id
 * @property int $dept_id 所属部门ID
 * @property string $name 姓名
 * @property string|null $position 职位
 * @property string|null $avatar 照片路径
 * @property string|null $bio 个人简介
 * @property string|null $email
 * @property int|null $status 1在职 0离职
 * @property string|null $created_at
 */
class TeamMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_team_member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dept_id', 'name'], 'required'],
            [['dept_id', 'status'], 'integer'],
            [['bio'], 'string'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['position', 'email'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dept_id' => '所属部门ID',
            'name' => '姓名',
            'position' => '职位',
            'avatar' => '照片路径',
            'bio' => '个人简介',
            'email' => 'Email',
            'status' => '1在职 0离职',
            'created_at' => 'Created At',
        ];
    }
}
