<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_team_department".
 *
 * @property int $id
 * @property string $name 部门名称
 * @property string|null $description 部门职能描述
 * @property int|null $sort_order 排序
 */
class TeamDepartment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_team_department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '部门名称',
            'description' => '部门职能描述',
            'sort_order' => '排序',
        ];
    }
}
