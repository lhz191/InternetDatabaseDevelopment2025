<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_tag".
 *
 * @property int $id
 * @property string $name 标签名
 * @property int|null $frequency 使用频率
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标签名',
            'frequency' => '使用频率',
        ];
    }
}
