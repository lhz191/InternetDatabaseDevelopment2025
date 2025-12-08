<?php
/**
 * 分类列表页 (View层)
 * @author 组员B
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '分类管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加分类', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'cid',
            'name',
            'description',
            'sort_order',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusText();
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return [$action, 'cid' => $model->cid];
                },
            ],
        ],
    ]); ?>

</div>

