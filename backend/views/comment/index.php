<?php
/**
 * 评论列表页 (View层)
 * @author 组员C
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
            'id',
            [
                'attribute' => 'aid',
                'label' => '文章',
                'value' => function($model) {
                    return $model->article ? $model->article->title : '已删除';
                },
            ],
            [
                'attribute' => 'uid',
                'label' => '用户',
                'value' => function($model) {
                    return $model->user ? $model->user->username : '匿名';
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
                    $statusText = ['待审核', '已发布', '已删除'];
                    return $statusText[$model->status] ?? '未知';
                },
            ],
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {approve} {delete}',
                'buttons' => [
                    'approve' => function($url, $model) {
                        if ($model->status == 0) {
                            return Html::a('通过', ['approve', 'id' => $model->id], ['class' => 'btn btn-xs btn-success']);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>

</div>
