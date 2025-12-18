<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '用户登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login" style="text-align: center;">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写以下信息进行登录：</p>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '请输入用户名'])->label('用户名') ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码'])->label('密码') ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>

                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
                </div>

                <div style="color:#999;margin:1em 0; border-top: 1px solid #eee; padding-top: 15px;">
                    如果没有账号，请先 <?= Html::a('注册新账号', ['site/signup']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
