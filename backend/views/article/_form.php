<?php
/**
 * 文章表单 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

?>

<div class="pre-news-article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'cid')->dropDownList(
        ArrayHelper::map($categories, 'cid', 'name'),
        ['prompt' => '请选择分类']
    ) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 10]) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_top')->dropDownList([0 => '否', 1 => '是']) ?>

    <?= $form->field($model, 'is_hot')->dropDownList([0 => '否', 1 => '是']) ?>

    <?= $form->field($model, 'status')->dropDownList([
        0 => '草稿',
        1 => '已发布',
        2 => '已下架',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

