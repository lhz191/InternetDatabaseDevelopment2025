<?php
/**
 * 编辑文章页 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '编辑文章: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'aid' => $model->aid]];
$this->params['breadcrumbs'][] = '编辑';
?>
<div class="pre-news-article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>

