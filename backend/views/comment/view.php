<?php
/**
 * 评论详情页 (View层)
 * @author 组员D
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = '评论详情 #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '评论管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if ($model->status == 0): ?>
            <?= Html::a('审核通过', ['approve', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这条评论吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'aid',
                'value' => $model->article ? $model->article->title : '文章已删除',
            ],
            [
                'attribute' => 'uid',
                'value' => $model->user ? $model->user->username : '用户已删除',
            ],
            'content:ntext',
            'likes',
            [
                'attribute' => 'status',
                'value' => $model->getStatusText(),
            ],
            'created_at',
        ],
    ]) ?>

</div>

