<?php
/**
 * 用户详情页 (View层)
 * @author 组员A
 * @date 2025-12-08
 */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pre-sys-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('编辑', ['update', 'uid' => $model->uid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'uid' => $model->uid], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除这个用户吗？',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'uid',
            'username',
            'email:email',
            //'phone',
            [
                'attribute' => 'role',
                'value' => $model->getRoleText(),
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


