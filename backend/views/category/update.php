<?php
/**
 * 编辑分类页 (View层)
 * @author 组员B
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '编辑分类: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'cid' => $model->cid]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="pre-news-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>


