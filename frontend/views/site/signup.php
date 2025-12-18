<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册新用户';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup" style="text-align: center;">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写以下信息进行注册：</p>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4"> <!-- 使用 offset-4 将 4列宽的 div 居中 -->
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => '请输入用户名'])->label('用户名') ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder' => '请输入密码'])->label('密码') ?>

                <div class="form-group">
                    <?= Html::submitButton('立即注册', ['class' => 'btn btn-primary btn-block', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
