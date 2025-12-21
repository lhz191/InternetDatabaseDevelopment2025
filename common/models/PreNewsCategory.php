<?php
/**
 * 新闻分类模型 (Model层)
 * 
 * @author 组员B
 * @date 2025-12-08
 * @description 新闻分类表的数据模型，处理分类相关的数据逻辑
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 新闻分类模型类
 * 
 * @property int $cid 分类ID
 * @property string $name 分类名称
 * @property string|null $description 分类描述
 * @property string|null $icon 分类图标
 * @property int|null $sort_order 排序
 * @property int|null $status 状态: 0禁用 1正常
 * @property string|null $created_at 创建时间
 */
class PreNewsCategory extends ActiveRecord
{
    /**
     * 状态常量
     */
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_news_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sort_order', 'status'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cid' => '分类ID',
            'name' => '分类名称',
            'description' => '分类描述',
            'icon' => '分类图标',
            'sort_order' => '排序',
            'status' => '状态',
            'created_at' => '创建时间',
        ];
    }

    /**
     * 获取该分类下的所有文章
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(PreNewsArticle::class, ['cid' => 'cid']);
    }

    /**
     * 获取文章数量
     * @return int
     */
    public function getArticleCount()
    {
        return $this->getArticles()->count();
    }

    /**
     * 获取状态文本
     * @return string
     */
    public function getStatusText()
    {
        $statuses = [
            self::STATUS_INACTIVE => '禁用',
            self::STATUS_ACTIVE => '正常',
        ];
        return $statuses[$this->status] ?? '未知';
    }

    /**
     * 获取所有启用的分类（下拉框使用）
     * @return array
     */
    public static function getActiveCategories()
    {
        return self::find()
            ->where(['status' => self::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }
}


