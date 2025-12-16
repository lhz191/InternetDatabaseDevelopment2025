<?php
/* @var $this yii\web\View */
$this->title = '团队介绍';
?>
<div class="site-team">
    <h1><?= \yii\helpers\Html::encode($this->title) ?></h1>

    <?php foreach ($departments as $dept): ?>
        <div class="department-section">
            <h2><?= $dept->name ?> <small class="text-muted"><?= $dept->description ?></small></h2>
            <hr>
            <div class="row">
                <?php foreach ($dept->teamMembers as $member): ?>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-body text-center">
                                <img src="<?= $member->avatar ?: '/images/default-avatar.png' ?>" class="img-circle" style="width: 100px; height: 100px;">
                                <h3><?= $member->name ?></h3>
                                <p class="text-primary"><?= $member->position ?></p>
                                <p><?= $member->bio ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>