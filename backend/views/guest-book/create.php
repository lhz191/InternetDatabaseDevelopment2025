<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GuestBook */

$this->title = '新增留言';
$this->params['breadcrumbs'][] = ['label' => '前台留言', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-book-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
