<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $password;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => '用户名不能为空'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '用户名已存在，请重新命名'],
            ['username', 'string', 'min' => 2, 'max' => 50],

            ['password', 'required', 'message' => '密码不能为空'],
            ['password', 'string', 'min' => 6, 'message' => '密码至少包含6个字符'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->username . '@example.com'; // 填充一个默认邮箱，避免非空约束
        $user->status = User::STATUS_ACTIVE; // 直接设置为激活状态
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        
        // 直接保存，不需要发送邮件
        return $user->save();
    }
}
