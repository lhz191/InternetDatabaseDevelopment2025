<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GuestBookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '前台留言';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="guest-book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增留言', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nickname',
            'email:email',
            'content:ntext',
            'ip_address',
            //'is_read',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
