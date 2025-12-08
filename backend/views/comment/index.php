<?php
/**
 * 评论列表页 (View层)
 * @author 组员D
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'aid',
                'value' => function($model) {
                    return $model->article ? $model->article->title : '文章已删除';
                },
            ],
            [
                'attribute' => 'uid',
                'value' => function($model) {
                    return $model->user ? $model->user->username : '用户已删除';
                },
            ],
            [
                'attribute' => 'content',
                'value' => function($model) {
                    return mb_substr($model->content, 0, 50) . '...';
                },
            ],
            'likes',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusText();
                },
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {approve} {delete}',
                'buttons' => [
                    'approve' => function ($url, $model) {
                        if ($model->status == 0) {
                            return Html::a('<span class="glyphicon glyphicon-ok"></span>', 
                                ['approve', 'id' => $model->id], 
                                ['title' => '审核通过']
                            );
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>

</div>

