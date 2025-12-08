<?php
/**
 * 文章详情页 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '文章管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'aid' => $model->aid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'aid' => $model->aid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这篇文章吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'aid',
            [
                'attribute' => 'cid',
                'value' => $model->category ? $model->category->name : '未分类',
            ],
            'title',
            'summary:ntext',
            'content:html',
            'source',
            'author',
            'views',
            'likes',
            [
                'attribute' => 'is_top',
                'value' => $model->is_top ? '是' : '否',
            ],
            [
                'attribute' => 'is_hot',
                'value' => $model->is_hot ? '是' : '否',
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatusText(),
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

