<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = '核心团队';
?>

<style>
    /* 团队页面的 Hero Banner */
    .team-hero {
        height: 350px;
        background: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1400') center/cover;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: -20px; /* 抵消掉默认的容器边距，视情况调整 */
        margin-bottom: 40px;
    }
    
    .team-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(135deg, rgba(26, 26, 26, 0.8), rgba(231, 76, 60, 0.2));
    }
    
    .team-hero-content {
        position: relative;
        z-index: 1;
        text-align: center;
        color: white;
    }
    
    .team-hero h1 {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 12px;
        text-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    
    .team-hero p {
        font-size: 18px;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto;
    }

    /* 部门标题 */
    .dept-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 50px 0 30px;
        padding-left: 15px;
        border-left: 5px solid #e74c3c; /* 使用主色调 */
        display: flex;
        align-items: baseline;
        gap: 15px;
    }
    
    .dept-desc {
        font-size: 14px;
        color: #666;
        font-weight: 400;
    }

    /* 团队成员网格 */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 60px;
    }

    /* 成员卡片 */
    .member-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        text-align: center;
        border: 1px solid #f0f0f0;
    }

    .member-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        border-color: #e74c3c;
    }

    /* 头像区域 */
    .card-header {
        height: 120px;
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        position: relative;
        margin-bottom: 60px;
    }

    .avatar-wrapper {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: white;
        padding: 4px;
        position: absolute;
        bottom: -60px; /* 悬挂在分界线上 */
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background-color: #eee;
    }

    /* 文本内容 */
    .card-body {
        padding: 0 25px 30px;
    }

    .member-name {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 5px;
    }

    .member-position {
        color: #e74c3c; /* 主色调 */
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 15px;
        display: block;
    }

    .member-bio {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        /* 限制行数 */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        height: 4.8em; /* 备用高度限制 */
    }

    .social-links {
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .social-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f5f5f5;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.2s;
    }

    .social-btn:hover {
        background: #e74c3c;
        color: white;
    }
</style>

<div class="site-team">
    
    <div class="team-hero">
        <div class="team-hero-content">
            <h1>Our Awesome Team</h1>
            <p>汇聚创意与技术的精英团队，致力于打造最优质的新闻资讯平台</p>
        </div>
    </div>

    <div class="container">
        <?php foreach ($departments as $dept): ?>
            <div class="department-section">
                <div class="dept-title">
                    <?= Html::encode($dept->name) ?>
                    <span class="dept-desc"><?= Html::encode($dept->description) ?></span>
                </div>

                <div class="team-grid">
                    <?php if (!empty($dept->preTeamMembers) || !empty($dept->teamMembers)): ?>
                        <?php 
                        // 兼容两种关联命名（preTeamMembers 或 teamMembers）
                        $members = !empty($dept->preTeamMembers) ? $dept->preTeamMembers : $dept->teamMembers;
                        ?>
                        <?php foreach ($members as $member): ?>
                            <div class="member-card">
                                <div class="card-header">
                                    <div class="avatar-wrapper">
                                        <img src="<?= $member->avatar ?: 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . $member->name ?>" 
                                             class="avatar-img" 
                                             alt="<?= Html::encode($member->name) ?>">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h3 class="member-name"><?= Html::encode($member->name) ?></h3>
                                    <span class="member-position"><?= Html::encode($member->position) ?></span>
                                    <p class="member-bio"><?= Html::encode($member->bio ?: '这个家伙很懒，什么都没写。') ?></p>
                                    
                                    <div class="social-links">
                                        <a href="mailto:<?= $member->email ?>" class="social-btn" title="Email">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        <a href="<?= \yii\helpers\Url::to(['team/view', 'id' => $member->id]) ?>" class="social-btn" title="Profile">
                                            <i class="fas fa-user"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-muted">该部门暂无成员。</div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>