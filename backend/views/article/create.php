<?php
/**
 * 创建文章页 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;

$this->title = '添加文章';
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>

