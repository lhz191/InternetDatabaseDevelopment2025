<?php
/**
 * 新闻文章模型 (Model层)
 * 
 * @author 刘浩泽 (2212478)
 * @date 2025-12-08
 * @description 新闻文章表的数据模型，处理文章相关的数据逻辑
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 新闻文章模型类
 * 
 * @property int $aid 文章ID
 * @property int $cid 分类ID
 * @property int|null $uid 作者ID
 * @property string $title 文章标题
 * @property string|null $summary 文章摘要
 * @property string|null $content 文章内容
 * @property string|null $cover_image 封面图片
 * @property string|null $source 来源
 * @property string|null $author 作者名
 * @property int|null $views 浏览量
 * @property int|null $likes 点赞数
 * @property int|null $is_top 是否置顶
 * @property int|null $is_hot 是否热门
 * @property int|null $status 状态: 0草稿 1发布 2下架
 * @property string|null $created_at 创建时间
 * @property string|null $updated_at 更新时间
 */
class PreNewsArticle extends ActiveRecord
{
    /**
     * 状态常量
     */
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_OFFLINE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_news_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cid', 'title'], 'required'],
            [['cid', 'uid', 'views', 'likes', 'is_top', 'is_hot', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'cover_image'], 'string', 'max' => 255],
            [['summary'], 'string', 'max' => 500],
            [['source'], 'string', 'max' => 100],
            [['author'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'aid' => '文章ID',
            'cid' => '所属分类',
            'uid' => '作者ID',
            'title' => '文章标题',
            'summary' => '文章摘要',
            'content' => '文章内容',
            'cover_image' => '封面图片',
            'source' => '来源',
            'author' => '作者',
            'views' => '浏览量',
            'likes' => '点赞数',
            'is_top' => '置顶',
            'is_hot' => '热门',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取文章所属分类
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PreNewsCategory::class, ['cid' => 'cid']);
    }

    /**
     * 获取文章作者
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(PreSysUser::class, ['uid' => 'uid']);
    }

    /**
     * 获取文章评论
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(PreNewsComment::class, ['aid' => 'aid']);
    }

    /**
     * 获取评论数量
     * @return int
     */
    public function getCommentCount()
    {
        return $this->getComments()->count();
    }

    /**
     * 获取状态文本
     * @return string
     */
    public function getStatusText()
    {
        $statuses = [
            self::STATUS_DRAFT => '草稿',
            self::STATUS_PUBLISHED => '已发布',
            self::STATUS_OFFLINE => '已下架',
        ];
        return $statuses[$this->status] ?? '未知';
    }

    /**
     * 增加浏览量
     */
    public function increaseViews()
    {
        $this->updateCounters(['views' => 1]);
    }

    /**
     * 增加点赞数
     */
    public function increaseLikes()
    {
        $this->updateCounters(['likes' => 1]);
    }

    /**
     * 获取热门文章
     * @param int $limit
     * @return array
     */
    public static function getHotArticles($limit = 10)
    {
        return self::find()
            ->where(['status' => self::STATUS_PUBLISHED])
            ->orderBy(['views' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    /**
     * 获取最新文章
     * @param int $limit
     * @return array
     */
    public static function getLatestArticles($limit = 10)
    {
        return self::find()
            ->where(['status' => self::STATUS_PUBLISHED])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($limit)
            ->all();
    }
}

