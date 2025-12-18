<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pre_article_tag".
 *
 * @property int $aid
 * @property int $tid
 */
class ArticleTag extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_article_tag';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aid', 'tid'], 'required'],
            [['aid', 'tid'], 'integer'],
            [['aid', 'tid'], 'unique', 'targetAttribute' => ['aid', 'tid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aid' => 'Aid',
            'tid' => 'Tid',
        ];
    }
}
