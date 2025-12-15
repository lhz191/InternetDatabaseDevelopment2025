<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeamDepartment */

$this->title = '更新团队: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '团队部门', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="team-department-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
