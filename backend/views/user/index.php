<?php
/**
 * 用户列表页 (View层)
 * @author 组员A
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-sys-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'uid',
            'username',
            'email:email',
            //'phone',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->status == 1 ? '正常' : '禁用';
                },
            ],
            'created_at',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, $model, $key, $index) {
                    return [$action, 'uid' => $model->uid];
                },
            ],
        ],
    ]); ?>

</div>


