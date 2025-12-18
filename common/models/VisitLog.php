<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_visit_log".
 *
 * @property int $id
 * @property string $page_url
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $visit_time
 */
class VisitLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_visit_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_url'], 'required'],
            [['visit_time'], 'safe'],
            [['page_url', 'user_agent'], 'string', 'max' => 255],
            [['ip_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_url' => 'Page Url',
            'ip_address' => 'Ip Address',
            'user_agent' => 'User Agent',
            'visit_time' => 'Visit Time',
        ];
    }
}
