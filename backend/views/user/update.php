<?php
/**
 * 编辑用户页 (View层)
 * @author 组员A
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '编辑用户: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'uid' => $model->uid]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="pre-sys-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>

