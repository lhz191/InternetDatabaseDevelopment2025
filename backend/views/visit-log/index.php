<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\VisitLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Visit Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visit-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Visit Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'page_url:url',
            'ip_address',
            'user_agent',
            'visit_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
