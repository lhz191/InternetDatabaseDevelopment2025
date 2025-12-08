<?php
/**
 * 评论详情页 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = '评论 #' . $model->id;
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
                'label' => '所属文章',
                'value' => $model->article ? $model->article->title : '已删除',
            ],
            [
                'attribute' => 'uid',
                'label' => '评论用户',
                'value' => $model->user ? $model->user->username : '匿名',
            ],
            'content:ntext',
            'likes',
            'parent_id',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    $statusText = ['待审核', '已发布', '已删除'];
                    return $statusText[$model->status] ?? '未知';
                },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
