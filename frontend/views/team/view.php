<?php
/**
 * 成员详情页
 * @var $this yii\web\View
 * @var $model common\models\TeamMember
 */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->name . ' - 团队风采';
?>

<div class="team-view-page">
    <div class="profile-header">
        <div class="header-content">
            <h1>团队精英</h1>
            <p>铭记历史 · 砥砺前行</p>
        </div>
    </div>

    <div class="container profile-container">
        <a href="<?= Url::to(['team/index']) ?>" class="back-link">
            <i class="fas fa-arrow-left"></i> 返回团队列表
        </a>

        <div class="profile-card-large">
            <div class="row">
                <div class="col-md-4 profile-sidebar">
                    <div class="profile-avatar-box">
                        <img src="<?= $model->avatar ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $model->name ?>" 
                             alt="<?= Html::encode($model->name) ?>">
                    </div>
                    <h2 class="profile-name"><?= Html::encode($model->name) ?></h2>
                    <div class="profile-position"><?= Html::encode($model->position) ?></div>
                    
                    <div class="profile-meta">
                        <?php if($model->dept_id): ?>
                            <div class="meta-item">
                                <i class="fas fa-building"></i> 
                                <span>所属学院: <?= $model->department ? \yii\helpers\Html::encode($model->department->name) : '未知/无' ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if($model->email): ?>
                            <div class="meta-item">
                                <i class="fas fa-envelope"></i> 
                                <a href="mailto:<?= $model->email ?>"><?= Html::encode($model->email) ?></a>
                            </div>
                        <?php endif; ?>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i> 
                            <span>加入时间: 2025.11.20</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 profile-content">
                    <div class="section-block">
                        <h3 class="block-title"><i class="fas fa-user-tag"></i> 个人简介</h3>
                        <div class="content-text">
                            <?= nl2br(Html::encode($model->bio ?: '这位成员很低调，暂无详细介绍。')) ?>
                        </div>
                    </div>

                    <div class="section-block">
                        <h3 class="block-title"><i class="fas fa-star"></i> 工作职责</h3>
                    <div class="content-text">
                        <?php if (!empty($model->responsibilities)): ?>
                            <?= nl2br(\yii\helpers\Html::encode($model->responsibilities)) ?>
                        <?php else: ?>
                        <p class="text-muted">该成员暂未填写详细工作职责。</p>
                        <?php endif; ?>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* 页面样式 */
.profile-header {
    height: 260px;
    background: linear-gradient(135deg, #8B0000 0%, #6B0000 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFD700;
    margin-bottom: -80px; /* 让卡片上浮覆盖 */
    text-align: center;
}

.header-content h1 {
    font-family: 'Noto Serif SC', serif;
    font-size: 36px;
    margin-bottom: 10px;
}

.profile-container {
    max-width: 1000px;
    padding-bottom: 60px;
}

.back-link {
    display: inline-block;
    color: rgba(255,255,255,0.8);
    margin-bottom: 20px;
    text-decoration: none;
    font-size: 14px;
}
.back-link:hover { color: #FFD700; }

.profile-card-large {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    position: relative;
    z-index: 10;
    min-height: 500px;
}

.profile-sidebar {
    background: #fdfdfd;
    border-right: 1px solid #eee;
    padding: 50px 30px;
    text-align: center;
}

.profile-avatar-box {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    margin: 0 auto 20px;
    padding: 5px;
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.profile-avatar-box img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.profile-name {
    font-family: 'Noto Serif SC', serif;
    font-size: 28px;
    color: #333;
    margin-bottom: 5px;
}

.profile-position {
    color: #e74c3c;
    font-weight: 500;
    text-transform: uppercase;
    margin-bottom: 30px;
    font-size: 14px;
    letter-spacing: 1px;
}

.profile-meta {
    text-align: left;
    margin-top: 30px;
    border-top: 1px solid #eee;
    padding-top: 20px;
}

.meta-item {
    margin-bottom: 15px;
    color: #666;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.meta-item i { color: #8B0000; width: 20px; text-align: center; }
.meta-item a { color: #666; text-decoration: none; }
.meta-item a:hover { color: #e74c3c; }

.profile-content {
    padding: 50px 40px;
}

.section-block {
    margin-bottom: 40px;
}

.block-title {
    font-size: 20px;
    color: #8B0000;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f0f0f0;
    font-family: 'Noto Serif SC', serif;
}

.content-text {
    color: #555;
    line-height: 1.8;
    font-size: 16px;
}

@media (max-width: 768px) {
    .profile-sidebar { border-right: none; border-bottom: 1px solid #eee; }
    .profile-header { margin-bottom: 0; height: 200px; }
    .profile-card-large { margin-top: 20px; }
    .back-link { color: #666; margin-top: 20px; display: block; }
}
</style>