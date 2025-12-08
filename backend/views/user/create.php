<?php
/**
 * 创建用户页 (View层)
 * @author 组员A
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '添加用户';
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-sys-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>

