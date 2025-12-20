<?php
/**
 * 分类表单 (View层)
 * @author 组员B
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="pre-news-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort_order')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'status')->dropDownList([0 => '禁用', 1 => '正常']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


