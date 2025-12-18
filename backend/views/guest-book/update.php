<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GuestBook */

$this->title = '新增留言: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '前台留言', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="guest-book-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
