<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeamMember */

$this->title = '更新成员: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '团队成员', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="team-member-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
