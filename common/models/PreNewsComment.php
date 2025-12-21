<?php
/**
 * 新闻评论模型 (Model层)
 * 
 * @author 组员D
 * @date 2025-12-08
 * @description 新闻评论表的数据模型，处理评论相关的数据逻辑
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 新闻评论模型类
 * 
 * @property int $id 评论ID
 * @property int $aid 文章ID
 * @property int $uid 用户ID
 * @property string $content 评论内容
 * @property int|null $parent_id 父评论ID(用于回复)
 * @property int|null $likes 点赞数
 * @property int|null $status 状态: 0待审核 1已发布 2已删除
 * @property string|null $created_at 创建时间
 */
class PreNewsComment extends ActiveRecord
{
    /**
     * 状态常量
     */
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DELETED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_news_comment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['aid', 'uid', 'content'], 'required'],
            [['aid', 'uid', 'parent_id', 'likes', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['content'], 'string', 'min' => 1, 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '评论ID',
            'aid' => '文章',
            'uid' => '用户',
            'content' => '评论内容',
            'parent_id' => '回复',
            'likes' => '点赞数',
            'status' => '状态',
            'created_at' => '评论时间',
        ];
    }

    /**
     * 获取评论所属文章
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(PreNewsArticle::class, ['aid' => 'aid']);
    }

    /**
     * 获取评论用户
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(\common\models\User::class, ['uid' => 'uid']);
    }

    /**
     * 获取父评论
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(PreNewsComment::class, ['id' => 'parent_id']);
    }

    /**
     * 获取子评论（回复）
     * @return \yii\db\ActiveQuery
     */
    public function getReplies()
    {
        return $this->hasMany(PreNewsComment::class, ['parent_id' => 'id']);
    }

    /**
     * 获取状态文本
     * @return string
     */
    public function getStatusText()
    {
        $statuses = [
            self::STATUS_PENDING => '待审核',
            self::STATUS_APPROVED => '已发布',
            self::STATUS_DELETED => '已删除',
        ];
        return $statuses[$this->status] ?? '未知';
    }

    /**
     * 增加点赞数
     */
    public function increaseLikes()
    {
        $this->updateCounters(['likes' => 1]);
    }
}

