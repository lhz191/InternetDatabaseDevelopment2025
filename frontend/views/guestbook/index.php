<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\PreGuestbook */
/* @var $messages common\models\PreGuestbook[] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = '留言互动';
?>

<style>
    /* 顶部 Banner */
    .guestbook-hero {
        height: 300px;
        background: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -20px;
        margin-bottom: 40px;
    }
    
    .guestbook-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.9), rgba(231, 76, 60, 0.4));
    }
    
    .hero-text {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .hero-text h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    /* 布局容器 */
    .guestbook-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px 60px;
    }

    /* 左侧：表单卡片 */
    .form-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-top: 4px solid #e74c3c;
        position: sticky;
        top: 80px; /* 滚动时固定 */
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #eee;
        padding: 12px 15px;
        font-size: 14px;
        background: #fcfcfc;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #e74c3c;
        background: white;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }

    .btn-submit {
        background: #1a1a1a;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-submit:hover {
        background: #e74c3c;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 76, 60, 0.3);
    }

    /* 右侧：留言列表 */
    .message-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .message-item {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        display: flex;
        gap: 20px;
        transition: transform 0.2s;
    }

    .message-item:hover {
        transform: translateX(5px);
    }

    .msg-avatar {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f0f0f0;
        border: 2px solid white;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }

    .msg-body {
        flex-grow: 1;
    }

    .msg-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .msg-author {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 16px;
    }

    .msg-time {
        font-size: 12px;
        color: #999;
        background: #f8f9fa;
        padding: 4px 8px;
        border-radius: 4px;
    }

    .msg-content {
        color: #555;
        line-height: 1.6;
        font-size: 15px;
        background: #f9f9f9;
        padding: 15px;
        border-radius: 0 12px 12px 12px;
    }
    
    .empty-state {
        text-align: center;
        padding: 50px;
        color: #999;
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ddd;
    }
</style>

<div class="site-guestbook">
    
    <div class="guestbook-hero">
        <div class="hero-text">
            <h1>Guestbook</h1>
            <p>留下您的宝贵意见，与我们共同进步</p>
        </div>
    </div>

    <div class="guestbook-container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-card">
                    <div class="form-title">
                        <i class="fas fa-pen-fancy" style="color: #e74c3c;"></i> 
                        写留言
                    </div>
                    
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'guestbook-form']]); ?>

                    <?= $form->field($model, 'nickname', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-3']
                    ])->textInput(['placeholder' => '怎么称呼您？', 'class' => 'form-control'])->label('昵称') ?>

                    <?= $form->field($model, 'email', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-3']
                    ])->textInput(['placeholder' => '选填，用于接收回复', 'class' => 'form-control'])->label('邮箱 (可选)') ?>

                    <?= $form->field($model, 'content', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-4']
                    ])->textarea(['rows' => 5, 'placeholder' => '想对我们说什么...', 'class' => 'form-control'])->label('留言内容') ?>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fas fa-paper-plane"></i> 提交留言', ['class' => 'btn-submit']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="message-list">
                    <h3 style="margin-bottom: 20px; font-weight: 700; color: #1a1a1a;">
                        最新留言 <span class="badge" style="background: #e74c3c; font-size: 14px; vertical-align: middle;"><?= count($messages) ?></span>
                    </h3>

                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $msg): ?>
                            <div class="message-item">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= urlencode($msg->nickname) ?>&backgroundColor=ffe5e5,e5f3ff,e5ffe5" 
                                     class="msg-avatar" 
                                     alt="Avatar">
                                
                                <div class="msg-body">
                                    <div class="msg-header">
                                        <div class="msg-author"><?= Html::encode($msg->nickname) ?></div>
                                        <div class="msg-time">
                                            <i class="far fa-clock"></i> 
                                            <?= Yii::$app->formatter->asRelativeTime($msg->created_at) ?>
                                        </div>
                                    </div>
                                    <div class="msg-content">
                                        <?= nl2br(Html::encode($msg->content)) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="far fa-comments"></i>
                            <p>还没有人留言，快来抢沙发吧！</p>
                        </div>
                    <?php endif; ?>

                    <div class="pagination-container" style="margin-top: 30px; text-align: center;">
                        <?= LinkPager::widget([
                            'pagination' => $pages,
                            'options' => ['class' => 'pagination justify-content-center'],
                            'linkOptions' => ['class' => 'page-link'],
                            'pageCssClass' => 'page-item',
                            'disabledPageCssClass' => 'disabled page-item',
                            'prevPageCssClass' => 'page-item',
                            'nextPageCssClass' => 'page-item',
                            'activePageCssClass' => 'active',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>