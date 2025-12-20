<?php
/**
 * 用户表单 (View层)
 * @author 组员A
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="pre-sys-user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true, 'placeholder' => '留空则不修改密码']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'role')->dropDownList([0 => '普通用户', 1 => '管理员']) ?>

    <?= $form->field($model, 'status')->dropDownList([0 => '禁用', 1 => '正常']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


