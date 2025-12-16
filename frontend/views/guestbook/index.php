<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '留言板';
?>
<div class="site-guestbook">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'nickname')->textInput() ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
                <div class="form-group">
                    <?= Html::submitButton('提交留言', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        
        <div class="col-lg-7">
            <h3>最新留言</h3>
            <?php foreach ($messages as $msg): ?>
                <div class="well">
                    <strong><?= Html::encode($msg->nickname) ?></strong> 
                    <span class="text-muted pull-right"><?= $msg->created_at ?></span>
                    <p><?= Html::encode($msg->content) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>