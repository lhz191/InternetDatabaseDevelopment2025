<?php
/**
 * 用户模型 (Model层)
 * 
 * @author 组员A
 * @date 2025-12-08
 * @description 用户表的数据模型，处理用户相关的数据逻辑
 */

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * 用户模型类
 * 
 * @property int $uid 用户ID
 * @property string $username 用户名
 * @property string $password_hash 密码哈希
 * @property string|null $email 邮箱
 * @property string|null $phone 手机号
 * @property string|null $avatar 头像
 * @property int|null $role 角色: 0普通用户 1管理员
 * @property int|null $status 状态: 0禁用 1正常
 * @property string|null $created_at 创建时间
 * @property string|null $updated_at 更新时间
 */
class PreSysUser extends ActiveRecord
{
    /**
     * 角色常量
     */
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    
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
        return 'pre_sys_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash'], 'required'],
            [['role', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['password_hash', 'avatar'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户ID',
            'username' => '用户名',
            'password_hash' => '密码',
            'email' => '邮箱',
            'phone' => '手机号',
            'avatar' => '头像',
            'role' => '角色',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * 获取用户发布的文章
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(PreNewsArticle::class, ['uid' => 'uid']);
    }

    /**
     * 获取用户的评论
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(PreNewsComment::class, ['uid' => 'uid']);
    }

    /**
     * 获取角色文本
     * @return string
     */
    public function getRoleText()
    {
        $roles = [
            self::ROLE_USER => '普通用户',
            self::ROLE_ADMIN => '管理员',
        ];
        return $roles[$this->role] ?? '未知';
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
}

