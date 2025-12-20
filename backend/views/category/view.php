<?php
/**
 * 分类详情页 (View层)
 * @author 组员B
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '分类管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-news-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'cid' => $model->cid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'cid' => $model->cid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这个分类吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cid',
            'name',
            'description',
            'icon',
            'sort_order',
            [
                'attribute' => 'status',
                'value' => $model->getStatusText(),
            ],
            'created_at',
        ],
    ]) ?>

</div>


