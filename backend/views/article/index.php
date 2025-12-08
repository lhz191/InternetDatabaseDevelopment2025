<?php
/**
 * 文章列表页 (View层)
 * @author 组员C
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\PreNewsCategory;
use yii\helpers\ArrayHelper;

$this->title = '文章管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'aid',
            [
                'attribute' => 'cid',
                'value' => function($model) {
                    return $model->category ? $model->category->name : '未分类';
                },
                'filter' => ArrayHelper::map(PreNewsCategory::find()->all(), 'cid', 'name'),
            ],
            'title',
            'author',
            'views',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatusText();
                },
                'filter' => [0 => '草稿', 1 => '已发布', 2 => '已下架'],
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return [$action, 'aid' => $model->aid];
                },
            ],
        ],
    ]); ?>

</div>

