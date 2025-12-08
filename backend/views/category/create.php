<?php
/**
 * 创建分类页 (View层)
 * @author 组员B
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '添加分类';
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>

