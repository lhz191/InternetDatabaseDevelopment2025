<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TeamMember */

$this->title = '新增成员';
$this->params['breadcrumbs'][] = ['label' => '团队成员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
