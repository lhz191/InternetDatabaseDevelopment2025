<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model common\models\PreGuestbook */
/* @var $messages common\models\PreGuestbook[] */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = '铭记 · 传承 - 留言寄语';
?>

<style>
    /* 顶部 Banner - 抗战风格 */
    .guestbook-hero {
        height: 350px;
        /* 使用长城或巍峨山河的图片 */
        background: url('https://images.unsplash.com/photo-1508804185872-d7badad00f7d?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -20px;
        margin-bottom: 50px;
        border-bottom: 5px solid #8B0000;
    }
    
    .guestbook-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        /* 深红色渐变遮罩 */
        background: linear-gradient(135deg, rgba(60, 0, 0, 0.85), rgba(139, 0, 0, 0.6));
    }
    
    .hero-text {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .hero-text h1 {
        font-family: 'Noto Serif SC', serif; /* 衬线字体 */
        font-size: 48px;
        font-weight: 700;
        margin-bottom: 16px;
        color: #FFD700; /* 金色 */
        text-shadow: 0 4px 10px rgba(0,0,0,0.5);
        letter-spacing: 4px;
    }
    
    .hero-text p {
        font-family: 'Noto Serif SC', serif;
        font-size: 20px;
        opacity: 0.9;
        font-weight: 300;
        border-top: 1px solid rgba(255, 215, 0, 0.3);
        padding-top: 15px;
        display: inline-block;
    }

    /* 布局容器 */
    .guestbook-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 20px 80px;
    }

    /* 左侧：表单卡片 */
    .form-card {
        background: white;
        border-radius: 8px; /* 稍微减小圆角，更硬朗 */
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        border-top: 4px solid #8B0000; /* 深红色顶边 */
        position: sticky;
        top: 80px;
    }

    .form-title {
        font-size: 22px;
        font-weight: 700;
        color: #8B0000;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Noto Serif SC', serif;
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
    }

    .form-control {
        border-radius: 4px;
        border: 1px solid #ddd;
        padding: 12px 15px;
        font-size: 14px;
        background: #fdfdfd;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #8B0000;
        background: white;
        box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
    }

    .btn-submit {
        background: linear-gradient(135deg, #8B0000, #6B0000);
        color: #FFD700;
        border: none;
        padding: 12px 30px;
        border-radius: 4px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
        letter-spacing: 2px;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #a00000, #800000);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
        color: white;
    }

    /* 右侧：留言列表 */
    .message-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .message-item {
        background: white;
        border-radius: 8px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        display: flex;
        gap: 20px;
        transition: transform 0.2s;
        border-left: 3px solid transparent; /* 预留左边框 */
    }

    .message-item:hover {
        transform: translateX(5px);
        border-left: 3px solid #8B0000; /* 悬停显示红色左边框 */
    }

    .msg-avatar {
        flex-shrink: 0;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #f8f8f8;
        border: 2px solid #e0e0e0;
        padding: 2px;
    }

    .msg-body {
        flex-grow: 1;
    }

    .msg-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .msg-author {
        font-weight: 700;
        color: #333;
        font-size: 16px;
    }

    .msg-time {
        font-size: 12px;
        color: #999;
        background: #f5f5f5;
        padding: 4px 8px;
        border-radius: 2px;
    }

    .msg-content {
        color: #555;
        line-height: 1.8;
        font-size: 15px;
        background: #fcfcfc;
        padding: 15px;
        border-radius: 4px;
        border: 1px dashed #eee; /* 虚线边框增加质感 */
    }
    
    .empty-state {
        text-align: center;
        padding: 60px;
        color: #999;
        background: #f9f9f9;
        border-radius: 8px;
    }
    
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        color: #ccc;
    }

    /* 分页样式重写 */
    .pagination .page-item .page-link {
        color: #8B0000;
        border: 1px solid #ddd;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #8B0000;
        border-color: #8B0000;
        color: #FFD700;
    }
</style>

<div class="site-guestbook">
    
    <div class="guestbook-hero">
        <div class="hero-text">
            <h1>铭记 · 传承</h1>
            <p>写下您的感言，缅怀先烈，珍爱和平</p>
        </div>
    </div>

    <div class="guestbook-container">
        <div class="row">
            <div class="col-md-4">
                <div class="form-card">
                    <div class="form-title">
                        <i class="fas fa-feather-alt"></i> 
                        寄语留言
                    </div>
                    
                    <?php if (Yii::$app->session->hasFlash('success')): ?>
                        <div class="alert alert-success" role="alert" style="background-color: #f0fff4; border-color: #c3e6cb; color: #155724;">
                            <i class="fas fa-check-circle"></i> <?= Yii::$app->session->getFlash('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'guestbook-form']]); ?>

                    <?= $form->field($model, 'nickname', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-3']
                    ])->textInput(['placeholder' => '您的姓名/昵称', 'class' => 'form-control'])->label('姓名') ?>

                    <?= $form->field($model, 'email', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-3']
                    ])->textInput(['placeholder' => '选填，仅用于接收回复通知', 'class' => 'form-control'])->label('邮箱 (可选)') ?>

                    <?= $form->field($model, 'content', [
                        'template' => "{label}\n{input}\n{error}",
                        'options' => ['class' => 'form-group mb-4']
                    ])->textarea(['rows' => 6, 'placeholder' => '写下您的感言，致敬抗战英雄...', 'class' => 'form-control'])->label('留言内容') ?>

                    <div class="form-group">
                        <?= Html::submitButton('<i class="fas fa-paper-plane"></i> 提交寄语', ['class' => 'btn-submit']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>

            <div class="col-md-8">
                <div class="message-list">
                    <h3 style="margin-bottom: 20px; font-weight: 700; color: #333; font-family: 'Noto Serif SC', serif;">
                        最新寄语 <span class="badge" style="background: #8B0000; font-size: 14px; vertical-align: middle; color: #FFD700;"><?= count($messages) ?></span>
                    </h3>

                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $msg): ?>
                            <div class="message-item">
                                <div class="msg-avatar" style="display:flex; align-items:center; justify-content:center; background: #8B0000;">
                                    <span style="color: #FFD700; font-weight: bold; font-size: 18px;">
                                        <?= mb_substr($msg->nickname, 0, 1) ?>
                                    </span>
                                </div>
                                
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
                            <p>暂无寄语，成为第一个致敬的人吧！</p>
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