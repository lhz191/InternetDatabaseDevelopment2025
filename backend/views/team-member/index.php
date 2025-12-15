<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TeamMemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '团队成员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="team-member-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增成员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dept_id',
            'name',
            'position',
            'avatar',
            //'bio:ntext',
            //'email:email',
            //'status',
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
