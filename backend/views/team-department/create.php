<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeamDepartment */

$this->title = '新建团队';
$this->params['breadcrumbs'][] = ['label' => '团队部门', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-department-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
